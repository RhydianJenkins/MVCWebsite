<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'about' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/about',
                    'defaults' => [
                        'controller' => Controller\AboutController::class,
                        'action'     => 'about',
                    ],
                ],
            ],
            'membership' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/membership',
                    'defaults' => [
                        'controller' => Controller\MembershipController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login',
                            'defaults' => [
                                'action' => 'login',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/logout',
                            'defaults' => [
                                'action' => 'logout',
                            ],
                        ],
                    ],
                    'allmembers' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/allmembers',
                            'defaults' => [
                                'action' => 'viewAllMembers',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    // 'controllers' => [
    //     'factories' => [
    //         Controller\IndexController::class      => InvokableFactory::class,
    //         Controller\AboutController::class      => InvokableFactory::class,
    //         Controller\MembershipController::class => InvokableFactory::class,
    //     ],
    // ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'                     => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index'           => __DIR__ . '/../view/application/index/index.phtml',
            'application/about/about'           => __DIR__ . '/../view/application/about/about.phtml',
            'application/membership/index'      => __DIR__ . '/../view/application/membership/membership.phtml',
            'application/membership/login'      => __DIR__ . '/../view/application/membership/membership.phtml',
            'application/membership/logout'     => __DIR__ . '/../view/application/membership/membership.phtml',
            'error/404'                         => __DIR__ . '/../view/error/404.phtml',
            'error/index'                       => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
