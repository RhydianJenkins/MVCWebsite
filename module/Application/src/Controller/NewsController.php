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
use Application\Model\ArticleReader;

class NewsController extends AbstractActionController {
    /**
     * The model which reads articles from the public directory.
     * @var Application\Model\ArticleReader
     */
    private $articleReader;

    /**
     * Constructor.
     */
    public function __construct(ArticleReader $articleReader) {
        $this->articleReader = $articleReader;
    }

    public function indexAction() {
        // init some variables
        $articleFromRoute = $this->params()->fromRoute('article');
        $articles = $this->articleReader->getAllArticles();
        $viewArray = [];

        // add all articles
        $viewArray['articles'] = $articles;

        // if we have not specified an article from route
        if ($articleFromRoute == NULL) {
            $viewArray['selected'] = false;
            return new ViewModel($viewArray);
        }

        // article selected, go fetch it
        $selectedArticle = $this->articleReader->getArticleFromName($articleFromRoute);

        // did we find the article?
        if ($selectedArticle['found']) {
            $viewArray['selected'] = true;
            $viewArray['selectedArticle'] = $selectedArticle;
        }

        // return constructed view from array
        return new ViewModel($viewArray);
    }
}
