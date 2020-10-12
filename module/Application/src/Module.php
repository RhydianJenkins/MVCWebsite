<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Application\Model\MemberTable;

class Module {
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\MemberTable::class => function($container) {
                    $tableGateway = $container->get(Model\MemberTableGateway::class);
                    return new Model\MemberTable($tableGateway);
                },
                Model\MemberTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Member());
                    return new TableGateway('members', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                // Controller\MembershipController::class => function($container) {
                //     return new Controller\MembershipController(
                //         $container->get(MemberTable::class),
                //         $formManager->get(LoginForm::class)
                //     );
                // },
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
