<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\MemberTable as MemberTable;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Application\Form\LoginForm as LoginForm;
use Application\Form\RegisterForm as RegisterForm;
use Application\Form\ResetForm as ResetForm;
use Application\Form\ResetPasswordForm as ResetPasswordForm;
use Application\Form\ProfileImageUploadForm as ProfileImageUploadForm;
use Application\Model\LoginAuthenticator;
use Application\Model\Emailer;
use Laminas\Authentication\Result;
use Laminas\Session\Container;
use Application\Model\DatabaseReader;
use Laminas\Authentication\Storage\Session;
use Application\Model\User;

class MembershipController extends AbstractActionController {
    const IDENTITY_SESSION_ID = 'identity';

    /**
     * Error message to show when the database is down.
     */
    const DATABASE_ERROR_MESSAGE = 'Sorry. The database is currently down, please try again later.';

    /**
     * Forms
     */
    private $loginForm;
    private $registerForm;
    private $resetForm;
    private $resetPasswordForm;
    private $loginAuthenticator;
    private $profileImageUploadForm;

    /**
     * @var Application\Model\DatabaseReader
     */
    private $databaseReader;

    /**
     * The session.
     * @var Laminas\Authentication\Storage\Session
     */
    private $session;

    /**
     * The emailer Model that sends emails.
     * @var Model\Emailer
     */
    private $emailer;

    public function __construct(
        LoginForm $loginForm,
        RegisterForm $registerForm,
        ResetForm $resetForm,
        ResetPasswordForm $resetPasswordForm,
        ProfileImageUploadForm $profileImageUploadForm,
        LoginAuthenticator $loginAuthenticator,
        DatabaseReader $databaseReader,
        Session $session,
        Emailer $emailer
    ) {
        $this->loginForm = $loginForm;
        $this->registerForm = $registerForm;
        $this->resetForm = $resetForm;
        $this->resetPasswordForm = $resetPasswordForm;
        $this->loginAuthenticator = $loginAuthenticator;
        $this->profileImageUploadForm = $profileImageUploadForm;
        $this->databaseReader = $databaseReader;
        $this->session = $session;
        $this->emailer = $emailer;
    }

    public function indexAction() {
        // redirect to login page if we're not logged in
        if (!$this->loginAuthenticator->hasIdentity()) {
            return $this->redirect()->toRoute('membership/login');
        }

        // get user identity
        $user = $this->loginAuthenticator->getIdentity()['identity'];

        // return view with user in it
        return ['user' => $user];
    }

    public function loginAction() {
        // message and code to pass to view
        $message = "";
        $messageAlert = 'warning';
        $code = Result::FAILURE_UNCATEGORIZED;
        $route = $this->params()->fromQuery('redirect', 'membership');

        // if no post (form not submitted), just return form in view
        if (empty($this->getRequest()->getPost()->toArray())) {
            return ['loginform' => $this->loginForm];
        }

        // check captcha is valid
        $this->loginForm->setData($this->getRequest()->getPost());
        if (!$this->loginForm->isValid()) {
            $message = 'Invalid Form';
            $messageAlert = 'warning';
            return [
                'message' => $message,
                'messageAlert' => $messageAlert,
                'code' => Result::FAILURE_CREDENTIAL_INVALID,
                'loginform' => $this->loginForm,
            ];
        }

        // grab valid form data
        $email = $this->loginForm->getData()['email'];
        $password = $this->loginForm->getData()['password'];
        $captcha = $this->loginForm->getData()['captcha'];

        // login attempt, authenticate
        $this->loginAuthenticator->setEmail($email);
        $this->loginAuthenticator->setPassword($password);
        $result = $this->loginAuthenticator->authenticate();
        $code = $result->getCode();
        switch ($code) {
            case Result::FAILURE_IDENTITY_NOT_FOUND:
                // username not found
                $message = $result->getMessages()[0];
                $messageAlert = 'danger';
                break;
            case Result::FAILURE_CREDENTIAL_INVALID:
                // wrong password
                $message = $result->getMessages()[0];
                $messageAlert = 'danger';
                break;
            case Result::FAILURE:
                // probably a database error
                $message = $result->getMessages()[0];
                $messageAlert = 'danger';
                break;
            case Result::SUCCESS:
                // success!
                $this->session->write([MembershipController::IDENTITY_SESSION_ID => $result->getIdentity()]);
                $message = $result->getMessages()[0];
                $messageAlert = 'success';
                return $this->redirect()->toRoute($route);
                break;
            default:
                // other issue
                $message = $result->getMessages()[0];
                $messageAlert = 'warning';
                break;
        }

        // print login form
        $view = new ViewModel([
            'message' => $message,
            'messageAlert' => $messageAlert,
            'code' => $code,
            'loginform' => $this->loginForm,
        ]);
        return $view;
    }

    /**
     * Clears session, logging out
     */
    public function logoutAction() {
        $this->loginAuthenticator->clearIdentity();
        return $this->redirect()->toRoute('membership');
    }

    /**
     * Displays a form to register a new user.
     */
    public function registerAction() {
        // check if the form is submitted
        $formSubmitted = $this->getRequest()->isPost();
        if (!$formSubmitted) {
            return ['registerform' => $this->registerForm];
        }

        // get form data
        $user = new User();
        $this->registerForm->setInputFilter($user->getInputFilter());
        $this->registerForm->setData($this->getRequest()->getPost());

        // check form's validity
        if (!$this->registerForm->isValid()) {
            return [
                'message' => 'Invalid form.',
                'messageAlert' => 'warning',
                'registerform' => $this->registerForm,
            ];
        }

        // check record doesn't exist
        $emailExists = $this->loginAuthenticator->emailAlreadyExists($this->registerForm->getData()['email']);
        if ($emailExists['error']) {
            return [
                'message' => self::DATABASE_ERROR_MESSAGE,
                'messageAlert' => 'danger',
                'registerform' => $this->registerForm,
            ];
        }
        if ($emailExists['emailExists']) {
            return [
                'message' => 'An account with that email address already exists.',
                'messageAlert' => 'warning',
                'registerform' => $this->registerForm,
            ];
        }

        // populate user object and add to db
        $data = $this->registerForm->getData();
        $user->exchangeArray($data);
        $result = $this->loginAuthenticator->addNewUser($user);

        // check query was a success
        if (!$result['success']) {
            return [
                'message' => self::DATABASE_ERROR_MESSAGE,
                'messageAlert' => 'danger',
            ];
        }

        // return view array
        return [
            'message' => 'Account created.',
            'messageAlert' => 'success',
        ];
    }

    /**
     * Allows users to reset their passwords
     */
    public function resetAction() {
        // check if a form was submitted
        $formSubmitted = $this->getRequest()->isPost();

        // get reset code from URL
        $resetCodeFromUrl = preg_replace('/[^A-Za-z0-9\-]/', '', $this->params()->fromRoute('resetcode'));
        if ($resetCodeFromUrl != null) {
            return $this->resetFormStageTwo($resetCodeFromUrl, $formSubmitted);
        }

        // email not sent, return first stage reset form if not already submitted
        if (!$formSubmitted) {
            return [
                'resetForm' => $this->resetForm,
            ];
        }

        // submitted the first state reset form, check form's validity
        $this->resetForm->setData($this->getRequest()->getPost());
        if (!$this->resetForm->isValid()) {
            return [
                'message' => 'Invalid form.',
                'messageAlert' => 'danger',
                'resetForm' => $this->resetForm,
            ];
        }

        // form valid, check email exists in database
        $email = $this->resetForm->getData()['email'];
        $emailExists = $this->loginAuthenticator->emailAlreadyExists($email);
        if ($emailExists['error']) {
            return [
                'message' => self::DATABASE_ERROR_MESSAGE,
                'messageAlert' => 'danger',
                'resetForm' => $this->resetForm,
            ];
        }

        if (!$emailExists['emailExists']) {
            return [
                'message' => 'No account with that email address exists.',
                'messageAlert' => 'danger',
                'resetForm' => $this->resetForm,
            ];
        }

        // email exists, generate a new code and add to the database record
        $resultArray = $this->loginAuthenticator->generateAndAddResetCode($email);
        $resetCode = $resultArray['resetCode'];

        // send an email to the email address with the reset code
        $resetLink = $this->url()->fromRoute('membership/reset', ['resetcode' => $resetCode], ['force_canonical' => true]);
        $name = "Tata Member";
        $subject = "[NO REPLY] Password Reset";
        $message = "Someone has requested to reset your password on Tata Steel Sailing. ";
        $message .= "If this wasn't you, no action needs to be taken. ";
        $message .= "To reset your password, <a href=".$resetLink.">CLICK HERE</a>.";
        $this->emailer->sendMail($email, $name, $subject, $message);

        // return view of success message telling user to check their emails
        return [
            'message' => 'Email reset link sent. Check your emails for further instructions.<br>Remember to check your junk inbox.',
            'messageAlert' => 'success',
        ];
    }

    /**
     * Stage two of the reset password, from the reset action.
     */
    private function resetFormStageTwo($resetCodeFromUrl, $formSubmitted) {
        // get record with that reset code
        $codeExistArray = $this->loginAuthenticator->checkResetCodeExists($resetCodeFromUrl);

        // if not found, redirect to original login screen
        if (!$codeExistArray['found']) {
            return $this->redirect()->toRoute('membership/reset');
        }

        // grab some data from the codeExistArray
        $email = $codeExistArray['email'];
        $code = $codeExistArray['code'];

        // email found, show reset form stage 2 if not already submitted
        if (!$formSubmitted) {
            return [
                'resetPasswordForm' => $this->resetPasswordForm,
                'email' => $email,
                'code' => $code,
            ];
        }

        // form submitted, reset code in url, record found. check form's valid
        $this->resetPasswordForm->setData($this->getRequest()->getPost());
        if (!$this->resetPasswordForm->isValid()) {
            return [
                'message' => 'Invalid form.',
                'messageAlert' => 'danger',
                'resetPasswordForm' => $this->resetPasswordForm,
                'email' => $email,
                'code' => $code,
            ];
        }

        // form submitted, reset code in url, record found, form valid. Reset password.
        $newPassword = $this->resetPasswordForm->getData()['password'];
        $result = $this->loginAuthenticator->resetPassword($email, $newPassword, $code);

        // email password change
        $name = "Tata Member";
        $subject = "[NO REPLY] Your password has been changed";
        $message = "Dear member,<br /><br />";
        $message .= "Your password for Tata Steel Sailing has been successfully changed!<br /><br />";
        $message .= "If this wasn't you and you are unaware of this change, please contact the membership secretary immediately at membership@tatasteelsailing.org.uk.<br /><br />";
        $message .= "Regards,<br />";
        $message .= "Tata Steel Sailing.";
        $this->emailer->sendMail($email, $name, $subject, $message);

        // return success to view
        return [
            'message' => 'The password for ' . $email . ' has been reset.',
            'messageAlert' => 'success',
        ];
    }

    /**
     * Allows users to see their account details.
     */
    public function myAccountAction() {
        // redirect to login page if we're not logged in
        if (!$this->loginAuthenticator->hasIdentity()) {
            return $this->redirect()->toRoute('membership/login');
        }

        // get user identity
        $user = $this->loginAuthenticator->getIdentity()['identity'];

        // set up return array
        $returnArray = [];

        // check they have selected to reset profile picture
        if ($this->getRequest()->isPost()) {
            // Make certain to merge the $_FILES info!
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // save form data
            $this->profileImageUploadForm->setData($post);

            // check form validity
            if ($this->profileImageUploadForm->isValid()) {
                // get valid form data
                $data = $this->profileImageUploadForm->getData();

                // save to database
                $result = $this->databaseReader->uploadNewProfilePicture($data['profileimage'], $user['id']);

                // check success
                if ($result['code'] != $this->databaseReader::SUCCESS) {
                    $returnArray['success'] = false;
                    $returnArray['message'] = 'Unable to upload image. ' . $result['code'] . '.';
                    $returnArray['messageAlert'] = 'danger';
                } else {
                    $returnArray['success'] = true;
                    $returnArray['message'] = 'Profile picture successfully updated.';
                    $returnArray['messageAlert'] = 'success';

                    // save image to session
                    $newImage = 'data:image;base64,' . $result['image64'];  // new base64 encoded image
                    $user['profilepicture64'] = $newImage;
                    $this->loginAuthenticator->setProfilePicture($newImage);
                    $this->session->write([MembershipController::IDENTITY_SESSION_ID => $user]);
                }
            }
        }

        // finally add user and form(s) to return array
        $returnArray['user'] = $user;
        $returnArray['profileImageUploadForm'] = $this->profileImageUploadForm;

        // return view with user in it
        return $returnArray;
    }
}
