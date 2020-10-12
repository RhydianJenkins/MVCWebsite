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
use Application\Model\LoginAuthenticator;
use Laminas\Authentication\Result;
use Laminas\Session\Container;
use Laminas\Authentication\Storage\Session;

class MembershipController extends AbstractActionController {
    const IDENTITY_SESSION_ID = 'identity';
    const LOGGED_IN_SESSION_ID = 'loggedin';

    /**
     * @var LoginForm
     */
    private $loginForm;

    /**
     * @var LoginAuthenticator
     */
    private $loginAuthenticator;

    /**
     * The session.
     * @var Laminas\Authentication\Storage\Session
     */
    private $session;

    public function __construct(LoginForm $form, LoginAuthenticator $loginAuthenticator, Session $session) {
        $this->loginForm = $form;
        $this->loginAuthenticator = $loginAuthenticator;
        $this->session = $session;
    }

    public function indexAction() {
        // no session? return 'not logged in'
        if ($this->session == null) {
            return new ViewModel([
                'loggedin' => 'false',
            ]);
        }

        // get session data and populate view with it
        $sessionID = $this->session->read(MembershipController::IDENTITY_SESSION_ID);
        $sessionLoggedIn = $this->session->read(MembershipController::LOGGED_IN_SESSION_ID);
        $view = new ViewModel([
            'loggedin' => $sessionLoggedIn,
            'username' => $sessionID,
        ]);
        return $view;
    }

    public function loginAction() {
        // TODO, redirect away if we're already logged in

        // message to display
        $message = "";

        // check to see if usr/pass was POSTed, authenticate if so
        $username = $this->getRequest()->getPost()->toArray()['post']['username'];
        $password = $this->getRequest()->getPost()->toArray()['post']['password'];
        if ($username != null && $password != null) {
            // login attempt, authenticate
            $this->loginAuthenticator->setUsername($username);
            $this->loginAuthenticator->setPassword($password);
            $result = $this->loginAuthenticator->authenticate();
            switch ($result->getCode()) {
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
                    $this->session->write([MembershipController::IDENTITY_SESSION_ID => $username]);
                    $message = $result->getMessages()[0];
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
            'loginform' => $this->loginForm,
        ]);
        return $view;
    }

    /**
     * Clears session, logging out
     */
    public function logoutAction() {
        $this->session->clear();
        $this->session->write([MembershipController::IDENTITY_SESSION_ID => $username]);
        return new ViewModel([
            'loggedin' => false,
        ]);
        // TODO, change URI to remove the 'logout'?
    }
}
