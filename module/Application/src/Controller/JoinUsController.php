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
use Application\Model\Emailer;
use Application\Model\MembershipApplicationManager;
use Application\Model\MembershipApplication;
use Application\Form\MembershipForm;
use Application\Form\GroupMembershipForm;
use Laminas\Form\Element;

class JoinUsController extends AbstractActionController {
    /**
     * Email client used to send emails.
     */
    private $emailer;

    /**
     * Application module that will handle writing to the database.
     */
    private $applicationManager;

    /**
     * Forms.
     */
    private $membershipForm;
    private $groupMembershipForm;

    /**
     * Constructor.
     */
    public function __construct(Emailer $emailer, MembershipApplicationManager $manager, MembershipForm $membershipForm, GroupMembershipForm $groupMembershipForm) {
        $this->emailer = $emailer;
        $this->applicationManager = $manager;
        $this->membershipForm = $membershipForm;
        $this->groupMembershipForm = $groupMembershipForm;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function groupAction() {
        // if no post (form not submitted), just return form in view
        if (empty($this->getRequest()->getPost()->toArray())) {
            return ['groupMembershipForm' => $this->groupMembershipForm];
        }

        // check form is valid
        $application = new GroupMembershipApplication();
        $this->groupMembershipForm->setInputFilter($application->getInputFilter());
        $this->groupMembershipForm->setData($this->getRequest()->getPost());
        if (!$this->groupMembershipForm->isValid()) {
            return [
                'message' => 'Invalid Form',
                'messageAlert' => 'danger',
                'membershipForm' => $this->groupMembershipForm,
            ];
        }

        // grab valid form data
        $application->exchangeArray($this->groupMembershipForm->getData());

        var_dump($application->toString());

        // return success message
        return [
            'message' => 'Group membership application form submitted succssfully.',
            'messageAlert' => 'success',
        ];
    }

    public function membershipAction() {
        // if no post (form not submitted), just return form in view
        if (empty($this->getRequest()->getPost()->toArray())) {
            return ['membershipForm' => $this->membershipForm];
        }

        // check form is valid
        $application = new MembershipApplication();
        $this->membershipForm->setInputFilter($application->getInputFilter());
        $this->membershipForm->setData($this->getRequest()->getPost());
        if (!$this->membershipForm->isValid()) {
            return [
                'message' => 'Invalid Form',
                'messageAlert' => 'danger',
                'membershipForm' => $this->membershipForm,
            ];
        }

        // grab valid form data
        $application->exchangeArray($this->membershipForm->getData());

        var_dump($application->toString());

        // return success message
        return [
            'message' => 'Membership application form submitted succssfully.',
            'messageAlert' => 'success',
        ];
    }

    public function openAction() {
        return new ViewModel();
    }

    /**
     * Ajax action that returns the dynamic additional leaders group membership form field
     */
    public function newLeaderAction() {
        return "";  // TODO
    }
}
