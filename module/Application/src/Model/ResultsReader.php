<?php
namespace Application\Model;

class ResultsReader {
    /**
     * The directory (from root) of the articles.
     */
    const RESULTS_DIR = 'public/results';

    /**
     * Returns an array of articles.
     */
    public function getAllresults($dir = self::RESULTS_DIR) {
        $years = array_diff(scandir($dir), array('.', '..', 'README.md'));
        foreach($years as $year) {
            $allFiles = scandir($dir . '/' . $year);
            $filteredFiles = array_diff($allFiles, array('.', '..'));
            $filteredFiles = array_values($filteredFiles);
            $results[$year] = [];
            foreach($filteredFiles as $file) {
                $title = pathinfo($file, PATHINFO_FILENAME);    // remove extension
                $title = str_replace('_', ' ', $title);  // replace undescores with spaces
                $result = [
                    'year' => $year,
                    'filename' => $file,
                    'title' => $title,
                ];
                array_push($results[$year], $result);
            }
        }

        $results = array_reverse($results, true);
        return $results;
    }

    /**
     * Gets a result from a given name. The name will have come from route, so will not include file extension.
     */
    public function getResult($name, $year, $dir = self::RESULTS_DIR) {
        $results = array_diff(scandir($dir . '/' . $year), array('.', '..'));
        $returnArray = ['found' => false];
        $filteredInputName = $this->filterName($name);   // make name pretty
        foreach($results as $result) {
            $filteredResultName = $this->filterName($result);   // make name pretty
            if (strcmp($filteredResultName, $filteredInputName)) {
                $path = $dir . '/' . $year . '/' . $result;
                $returnArray['title'] = $filteredResultName;
                $returnArray['path'] = $dir . '/' . $year . '/' . $result;
                $returnArray['found'] = true;
                $returnArray['content'] = $this->clean(file_get_contents($returnArray['path']));
            }
        }
        return $returnArray;
    }

    private function filterName($unfiltered) {
        $filtered = ucwords($unfiltered);    // capitalise letters
        $filtered = str_replace('_', ' ', $filtered); // remove underscores
        $filtered = pathinfo($filtered, PATHINFO_FILENAME); // remove extension
        return $filtered;
    }

    /**
     * Cleans and returns a given file by removing inline styling, classes etx, before adding custom styles.
     */
    private function clean($html) {
        // create a new DomDocument object
        $doc = new \DOMDocument();

        // load the HTML into the DomDocument object (this would be your source HTML)
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $doc->formatOutput = true;
        $doc->preserveWhitespace = false;
        libxml_use_internal_errors(false);

        // remove some tags
        $this->removeElement('header', $doc);
        $this->removeElement('script', $doc);
        $this->removeElement('style', $doc);
        $this->removeElement('meta', $doc);
        $this->removeElement('footer', $doc);

        // remove inline styles
        $cleanHtml = $doc->saveHtml();
        $cleanHtml = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $cleanHtml);
        $cleanHtml = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $cleanHtml);
        $cleanHtml = preg_replace('/(<[^>]+) cellspacing=".*?"/i', '$1', $cleanHtml);
        $cleanHtml = preg_replace('/(<[^>]+) cellpadding=".*?"/i', '$1', $cleanHtml);
        $cleanHtml = preg_replace('/(<[^>]+) border=".*?"/i', '$1', $cleanHtml);
        $doc->loadHTML($cleanHtml);

        // add custom styles
        $this->generateStyle($doc);
        $cleanHtml = $doc->saveHtml();

        // Return cleaned html
        return $cleanHtml;
    }

    /**
     * Removes the string $tag element from the DOMDocument $doc
     */
    private function removeElement($tag, \DOMDocument $doc) {
        $nodeList = $doc->getElementsByTagName($tag);
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
            $node = $nodeList->item($nodeIdx);
            $node->parentNode->removeChild($node);
        }
    }

    private function generateStyle($doc) {
        // grab elements
        $h1 = $doc->getElementsByTagName('h1');
        $h2 = $doc->getElementsByTagName('h2');
        $h3 = $doc->getElementsByTagName('h3');
        $tables = $doc->getElementsByTagName('table');
        $cells = $doc->getElementsByTagName('td');
        $headers = $doc->getElementsByTagName('th');

        // h3 page-header text-center pt-5 pb-1
        for ($i = 0; $i < $h3->length; $i ++) {
            $h3[$i]->setAttribute('class', 'pt-5 pb-1');
        }

        // table table-striped table-hover table-responsive 
        for ($i = 0; $i < $tables->length; $i ++) {
            //$tables[$i]->setAttribute('class', 'd-inline justify-content-center border-bottom-table table table-bordered table-striped table-hover table-responsive');
            $tables[$i]->setAttribute('class', 'table border-bottom-table table-bordered table-striped table-hover table-responsive');
        }

        // td p-2
        for ($i = 0; $i < $headers->length; $i ++) {
            $headers[$i]->setAttribute('class', 'primary-color p-2');
        }
    }
}
