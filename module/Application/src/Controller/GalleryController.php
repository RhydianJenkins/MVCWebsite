<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class GalleryController extends AbstractActionController {
    public function indexAction() {
        $album = $this->params()->fromRoute('album');
        return new ViewModel();
    }
}
