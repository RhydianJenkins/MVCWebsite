<?php
namespace Application\Model;

class ResultsReader {
    /**
     * The directory (from root) of the articles.
     */
    const RESULTS_DIR = 'public/results/';

    /**
     * Returns an array of articles.
     */
    public function getAllresults($dir = self::RESULTS_DIR) {
        // TODO
    }

    /**
     * Gets a result from a given name. The name will have come from route, so will not include file extension.
     */
    public function getResultFromName($searchname, $dir = self::RESULTS_DIR) {
        // TODO

        // no result with that name found, return false
        return ['found' => false];
    }
}
