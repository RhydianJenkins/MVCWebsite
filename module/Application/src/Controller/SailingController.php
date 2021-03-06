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
use Application\Model\DatabaseReader;

class SailingController extends AbstractActionController {
    /**
     * The model which reads results from the public directory.
     * @var Application\Model\ResultsReader
     */
    private $resultsReader;

    /**
     * The general purpose model which reads database entries.
     * @var Application\Model\DatabaseReader
     */
    private $dbReader;

    /**
     * Constructor.
     */
    public function __construct(ResultsReader $resultsReader, DatabaseReader $dbReader) {
        $this->resultsReader = $resultsReader;
        $this->dbReader = $dbReader;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function resultsAction() {
        // read all results from file
        $allResults = $this->resultsReader->getAllresults();
        $resultsArray = [
            'allResults' => $allResults,
            'selected' => false,
        ];

        // if we have a specified a result from route, add to view
        $yearFromRoute = $this->params()->fromRoute('year');
        $resultFromRoute = $this->params()->fromRoute('result');
        if ($yearFromRoute != NULL && $resultFromRoute != NULL) {
            $result = $this->resultsReader->getResult($resultFromRoute, $yearFromRoute);
            if ($result['found']) {
                $resultsArray['selected'] = true;
                $resultsArray['selectedTitle'] = $result['title'];
                $resultsArray['selectedPath'] = $result['path'];
                $resultsArray['content'] = $result['content'];
            }
        }

        // return view array
        return $resultsArray;
    }

    public function instructionsAction() {
        return new ViewModel();
    }

    public function pnAction() {
        $pn = $this->dbReader->readPN();
        if ($pn['code'] != $this->dbReader::SUCCESS) {
            return [
                'success' => false,
                'errorMsg' => $pn['code'],
            ];
        }
        return [
            'success' => true,
            'pnumbers' => iterator_to_array($pn['results'], true),
        ];
    }

    public function bookAction() {
        return new ViewModel([
            'message' => 'The club is closed during the current Welsh "Firebreak" lockdown.',
            'messageAlert' => 'danger',
        ]);
    }
}
