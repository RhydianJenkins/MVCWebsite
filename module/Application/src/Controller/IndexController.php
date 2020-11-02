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
use Application\Model\WeatherReader;

class IndexController extends AbstractActionController {
    /**
     * Model which reads weather from API.
     */
    private $weatherReader;

    /**
     * The private Google Maps API key.
     */
    private $mapAPIKey;

    /**
     * Constructor.
     */
    public function __construct(WeatherReader $weatherReader, $mapAPIKey) {
        $this->weatherReader = $weatherReader;
        $this->mapApiKey = $mapAPIKey;
    }

    public function indexAction() {
        $weather = $this->weatherReader->getWeather();
        if ($weather != null) {
            $viewArray = [
                'weatherOk' => true,
                'weather' => $weather,
                'mapApiKey' => $this->mapApiKey,
            ];
        } else {
            $viewArray = [
                'weatherOk' => false,
                'mapApiKey' => $this->mapApiKey,
            ];
        }
        return new ViewModel($viewArray);
    }

    public function termsAndConditionsAction() {
        return new ViewModel();
    }
}
