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
        $albumFromRoute = $this->params()->fromRoute('album');
        $albums = $this->albumReader->getAlbumFiles();
        $viewArray = [];
        $images = [];

        // if we have a specified album from route
        if ($albumFromRoute != NULL) {
            $images = $this->albumReader->readAlbumImages($albumFromRoute);
        }

        // add imagesFound
        $viewArray['imagesFound'] = !empty($images);

        // add albums
        $viewArray['albums'] = $albums;

        // add images, if they exist
        if (!empty($images)) {
            $viewArray['images'] = $images;
            $viewArray['albumName'] = $albumFromRoute;
        }

        // build and return view
        return new ViewModel($viewArray);
    }
}
