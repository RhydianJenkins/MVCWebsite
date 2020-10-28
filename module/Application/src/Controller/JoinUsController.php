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

    /**
     * Constructor.
     */
    public function __construct(Emailer $emailer, MembershipApplicationManager $manager, MembershipForm $membershipForm) {
        $this->emailer = $emailer;
        $this->applicationManager = $manager;
        $this->membershipForm = $membershipForm;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function groupAction() {
        return new ViewModel();
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

        // echo("<pre>");
        // var_dump($application->toString());
        // echo("</pre>");

        // return success message
        return [
            'message' => 'Membership application form submitted succssfully.',
            'messageAlert' => 'success',
        ];
    }

    public function openAction() {
        return new ViewModel();
    }
}
