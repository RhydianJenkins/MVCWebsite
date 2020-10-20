<?php
namespace Application\Model;

use Laminas\Validator\Date;
use \Datetime;
use \DateTimeZone;

class ArticleReader {
    /**
     * The directory (from root) of the articles.
     */
    const ARTICLE_DIR = 'public/articles/';

    /**
     * Returns a array of articles.
     */
    public function getAllArticles($dir = self::ARTICLE_DIR) {
        $dateValiadtor = new Date();
        $articles = [];
        foreach(glob($dir . '/*.{pdf}', GLOB_BRACE) as $d) {
            // get article filename from path
            $filename = substr($d, strrpos($d, '/') + 1);

            // get date from front of article
            $dateString = explode('_', $filename, 2)[0];
            if ($dateValiadtor->isValid($dateString)) {
                $date = new DateTime($dateString, new DateTimeZone('GMT'));
                $title = explode('_', $filename, 2)[1]; // remove date from front of string
            } else {
                $date = null;
                $title = $filename;
            }

            // create pretty article title
            $title = preg_replace("/[^A-Za-z0-9-. ]/", '', $title);   // remove unwanted chars
            $title = preg_replace('/\\.[^.\\s]{3,4}$/', '', $title); // remove extension

            // add to array
            array_push($articles, [
                'filename' => $filename,
                'title' => $title,
                'path' => $dir,
                'date' => $date,
            ]);
        }

        // sort articles so newest first
        // articles with no date will go last
        usort($articles, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return $articles;
    }

    /**
     * Gets an article from a given name. The name will have come from route, so will no include file extension.
     */
    public function getArticleFromName($name) {
        // TODO
        var_dump($name);
    }
}
