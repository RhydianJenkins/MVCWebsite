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
use Application\Model\ResultsReader;

class SailingController extends AbstractActionController {
    /**
     * The model which reads results from the public directory.
     * @var Application\Model\ResultsReader
     */
    private $resultsReader;

    /**
     * Constructor.
     */
    public function __construct(ResultsReader $resultsReader) {
        $this->resultsReader = $resultsReader;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function resultsAction() {
        return new ViewModel();
    }
}
