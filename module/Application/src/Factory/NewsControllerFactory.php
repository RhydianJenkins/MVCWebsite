<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Authentication\Adapter\AdapterInterface;
use Application\Model\ArticleReader;
use Application\Controller\NewsController;

class NewsControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $articleReader = $container->get(ArticleReader::class);
        return new NewsController($articleReader);
    }
}
