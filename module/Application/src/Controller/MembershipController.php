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
use Application\Model\LoginAuthAdapter;
use Laminas\Authentication\Result;
use Laminas\Session\Container;
use Laminas\Authentication\Storage\Session;

class MembershipController extends AbstractActionController {
    const IDENTITY_SESSION_ID = 'identity';

    private $table;

    /**
     * @var LoginForm
     */
    private $loginForm;

    /**
     * @var LoginAuthAdapter
     */
    private $LoginAdapter;

    /**
     * The session.
     * @var Laminas\Authentication\Storage\Session
     */
    private $session;

    public function __construct(MemberTable $table, LoginForm $form, LoginAuthAdapter $loginAdapter, Session $session) {
        $this->table = $table;
        $this->loginForm = $form;
        $this->loginAdapter = $loginAdapter;
        $this->session = $session;
    }

    public function indexAction() {
        if ($this->session == null) {
            return new ViewModel([
                'loggedin' => 'false',
            ]);
        }

        // we're logged in, return a view model with a username from session
        $view = new ViewModel([
            'loggedin' => 'true',
            'username' => $this->session->read(MembershipController::IDENTITY_SESSION_ID),
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
            $this->loginAdapter->setUsername($username);
            $this->loginAdapter->setPassword($password);
            $result = $this->loginAdapter->authenticate();
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
     * Clear session in LoginAuthAdapter and redirect to index.
     */
    public function logoutAction() {
        $this->session->clear();
        return new ViewModel([
            'loggedin' => false,
        ]);
        // TODO, change URI to remove the 'logout'?
    }

    public function viewAllMembersAction() {
        $view = new ViewModel([
            'allmembers' => $this->table->fetchAll(),
        ]);
        return $view;
    }
}
