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
use Application\Model\LoginAuthenticator;
use Laminas\Authentication\Result;
use Laminas\Session\Container;
use Laminas\Authentication\Storage\Session;
use Application\Model\User;

class MembershipController extends AbstractActionController {
    const IDENTITY_SESSION_ID = 'identity';

    /**
     * @var LoginForm
     */
    private $loginForm;

    /**
     * @var RegisterForm
     */
    private $registerForm;

    /**
     * @var LoginAuthenticator
     */
    private $loginAuthenticator;

    /**
     * The session.
     * @var Laminas\Authentication\Storage\Session
     */
    private $session;

    public function __construct(LoginForm $loginForm, RegisterForm $registerForm, LoginAuthenticator $loginAuthenticator, Session $session) {
        $this->loginForm = $loginForm;
        $this->registerForm = $registerForm;
        $this->loginAuthenticator = $loginAuthenticator;
        $this->session = $session;
    }

    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function loginAction() {
        // message and code to pass to view
        $message = "";
        $code = Result::FAILURE_UNCATEGORIZED;

        // check to see if usr/pass was POSTed, authenticate if so
        $username = $this->getRequest()->getPost()->toArray()['username'];
        $password = $this->getRequest()->getPost()->toArray()['password'];
        if ($username != null && $password != null) {
            // login attempt, authenticate
            $this->loginAuthenticator->setUsername($username);
            $this->loginAuthenticator->setPassword($password);
            $result = $this->loginAuthenticator->authenticate();
            $code = $result->getCode();
            switch ($code) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    // username not found
                    $message = $result->getMessages()[0];
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    // wrong password
                    $message = $result->getMessages()[0];
                    break;
                case Result::SUCCESS:
                    // success!
                    $this->session->write([MembershipController::IDENTITY_SESSION_ID => $result->getIdentity()]);
                    $message = $result->getMessages()[0];
                    return $this->redirect()->toRoute('membership');
                    break;
                default:
                    // other issue
                    $message = $result->getMessages()[0];
                    break;
            }
        }

        // print login form
        $view = new ViewModel([
            'message' => $message,
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
        $message = "";
        $formSubmitted = $this->getRequest()->isPost();

        // form not submitted?
        if (!$formSubmitted) {
            echo("Form not submitted");
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
                'registerform' => $this->registerForm,
            ];
        }

        // populate user object
        $data = $this->registerForm->getData();
        $user->exchangeArray($data);

        return [
            'message' => 'Valid form.',
            'registerform' => $this->registerForm,
        ];
        //return $this->redirect()->toRoute('membership');
    }
}
