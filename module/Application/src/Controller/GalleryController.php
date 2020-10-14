<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\AlbumReader;

class GalleryController extends AbstractActionController {
    /**
     * @var LoginForm
     */
    private $albumReader;

    public function __construct(AlbumReader $albumReader) {
        $this->albumReader = $albumReader;
    }

    public function indexAction() {
        // did we specify an album?
        $albums = $this->albumReader->getAlbumFiles();
        $album = $this->params()->fromRoute('album');
        if ($album == NULL) {
            // echo("no album specified.<br />");
            $view = new ViewModel([
                'albums' => $albums,
            ]);
        }

        return $view;
    }
}
