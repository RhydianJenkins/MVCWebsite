<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\DatabaseReader;
use Laminas\Authentication\Adapter\AdapterInterface;

class DatabaseReaderFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authAdapter = $container->get(DBAdapterFactory::class);
        return new DatabaseReader($authAdapter);
    }
}
