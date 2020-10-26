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
use Application\Model\WeatherReader;

class JoinUsController extends AbstractActionController {
    /**
     * Constructor.
     */
    public function __construct() {
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function groupAction() {
        return new ViewModel();
    }

    public function membershipAction() {
        return new ViewModel();
    }

    public function openAction() {
        return new ViewModel();
    }
}
