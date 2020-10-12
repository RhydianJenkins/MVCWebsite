<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Laminas\Authentication\Storage\Session as SessionStorage;
use Application\Model\LoginAuthenticator;
use Laminas\Authentication\Adapter\AdapterInterface;

class LoginAuthenticatorFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authStorage = $container->get(SessionStorageFactory::class);
        $authAdapter = $container->get(DBAdapterFactory::class);
        return new LoginAuthenticator($authStorage, $authAdapter);
    }
}
