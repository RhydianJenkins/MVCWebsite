<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\ResultsReader;
use Application\Controller\SailingController;

class SailingControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $resultsReader = $container->get(ResultsReader::class);
        return new SailingController($resultsReader);
    }
}