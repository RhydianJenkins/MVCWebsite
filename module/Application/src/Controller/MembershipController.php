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

class MembershipController extends AbstractActionController {
    private $table;

    /**
     * @var LoginForm
     */
    private $loginForm;

    /**
     * @var LoginAuthAdapter
     */
    private $LoginAdapter;

    public function __construct(MemberTable $table, LoginForm $form, LoginAuthAdapter $loginAdapter) {
        $this->table = $table;
        $this->loginForm = $form;
        $this->loginAdapter = $loginAdapter;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function loginAction() {
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
                    /** do stuff for nonexistent identity **/
                    echo("no such member");
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    /** do stuff for invalid credential **/
                    echo("invalid credentials");
                    break;
                case Result::SUCCESS:
                    /** do stuff for successful authentication **/
                    echo("successful authentication");
                    break;
                default:
                    /** do stuff for other failure **/
                    echo("other failure");
                    break;
            }
            echo("<pre>");var_dump($result);echo("</pre>");
        }

        // print login form
        $view = new ViewModel([
            'message' => $message,
            'loginform' => $this->loginForm,
        ]);
        return $view;
    }

    public function logoutAction() {
        $view = new ViewModel([
            'message' => 'You have selected log out',
        ]);
        return $view;
    }

    public function viewAllMembersAction() {
        $view = new ViewModel([
            'allmembers' => $this->table->fetchAll(),
        ]);
        return $view;
    }
}
