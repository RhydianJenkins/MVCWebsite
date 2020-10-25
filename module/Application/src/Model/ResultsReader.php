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
        $filteredInputName = $this->filterName($name);
        foreach($results as $result) {
            $filteredResultName = $this->filterName($result);    // capitalise letters
            if (strcmp($filteredResultName, $filteredInputName)) {
                $path = $dir . '/' . $year . '/' . $result;
                $returnArray['title'] = $filteredResultName;
                $returnArray['path'] = $dir . '/' . $year . '/' . $result;
                $returnArray['found'] = true;
                $returnArray['content'] = $this->clean(file_get_contents($returnArray['path']));
                //$returnArray['content'] = file_get_contents($returnArray['path']);
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
     * Cleans a given file and returns the cleaned html
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

        // remove the script and style elements
        $this->removeElement('script', $doc);
        $this->removeElement('style', $doc);
        $this->removeElement('class', $doc);
        $this->generateStyle($doc);

        // remove inline styles
        $cleanHtml = $doc->saveHtml();
        $cleanHtml = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $cleanHtml);

        // Return cleaned html
        return $cleanHtml;
    }

    /**
     * Removes the string $tag element from the DOMDocument $doc
     */
    private function removeElement($tag, $doc) {
        $nodeList = $doc->getElementsByTagName($tag);
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
            $node = $nodeList->item($nodeIdx);
            $node->parentNode->removeChild($node);
        }
    }

    private function generateStyle($doc) {
        $headers = $doc->getElementsByTagName('h3');
        for ($i = 0; $i < $headers->length; $i ++) {
            $headers[$i]->setAttribute('color', 'red');
        }
    }
}
