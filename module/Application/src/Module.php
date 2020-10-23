<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
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
                Model\Emailer::class => Factory\EmailerFactory::class,
                Model\LoginAuthenticator::class => Factory\LoginAuthenticatorFactory::class,
                Model\User::class => function ($container) {
                    return new User();
                },
                Model\AlbumReader::class => Factory\AlbumReaderFactory::class,
                Model\ArticleReader::class => Factory\ArticleReaderFactory::class,
                Model\WeatherReader::class => function ($container) {
                    $key = $container->get('config')['keystore']['api']['weather'];
                    return new Model\WeatherReader($key);
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
                Controller\NewsController::class => Factory\NewsControllerFactory::class,
                Controller\IndexController::class => function($container) {
                    $weatherReader = $container->get(Model\WeatherReader::class);
                    return new Controller\IndexController($weatherReader);
                },
                Controller\GalleryController::class => function($container) {
                    $albumReader = $container->get(Model\AlbumReader::class);
                    return new Controller\GalleryController($albumReader);
                },
                Controller\AboutController::class => function($container) {
                    return new Controller\AboutController();
                },
            ],
        ];
    }
}
