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

class AboutController extends AbstractActionController {
    /**
     * The private Google Maps API key.
     */
    private $mapApiKey;

    /**
     * Constructor.
     */
    public function __construct($mapAPIKey) {
        $this->mapApiKey = $mapAPIKey;
    }

    public function indexAction() {
        return new ViewModel([
            'mapApiKey' => $this->mapApiKey,
        ]);
    }

    public function teamAction() {
        return new ViewModel();
    }
}
