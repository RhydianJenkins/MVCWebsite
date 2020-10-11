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

class MembershipController extends AbstractActionController {
    private $table;

    public function __construct(MemberTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function loginAction() {
        $view = new ViewModel([
            'message' => 'You have selected log in',
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
