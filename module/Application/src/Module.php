<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Application\Model\MemberTable;
use Laminas\Session\SessionManager;
use Laminas\Authentication\Storage\Session;
use Laminas\Db\Adapter\Driver\DriverInterface;

class Module {
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\LoginAuthenticator::class => Factory\LoginAuthenticatorFactory::class,
                Model\User::class => function ($container) {
                    return new User();
                },
                Factory\SessionStorageFactory::class => function ($container) {
                    $sessionManager = new SessionManager();
                    return new Session('Laminas_Auth', 'session', $sessionManager);
                },
                Factory\DBAdapterFactory::class => function ($container) {
                    return $container->get('Application\DB\ReadWriteDBAdapter');
                    // return $container->get('Application\DB\ReadOnlyDBAdapter');
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\MembershipController::class => Factory\MembershipControllerFactory::class,
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController();
                },
                Controller\AboutController::class => function($container) {
                    return new Controller\AboutController();
                },
            ],
        ];
    }
}
