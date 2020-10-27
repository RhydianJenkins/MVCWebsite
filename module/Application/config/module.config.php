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
use Laminas\Authentication\AuthenticationService;
use Application\Factory\LoginAuthenticatorFactory;

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
            'terms-and-conditions' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/terms-and-conditions',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'terms-and-conditions',
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
                'may_terminate' => true,
                'child_routes' => [
                    'club' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/club',
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'team' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/team',
                            'defaults' => [
                                'action' => 'team',
                            ],
                        ],
                    ],
                ],
            ],
            'gallery' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/gallery[/:album]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\GalleryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'news' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/news[/:article]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\NewsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'calendar' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/calendar',
                    'defaults' => [
                        'controller' => Controller\CalendarController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'training' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/training',
                    'defaults' => [
                        'controller' => Controller\TrainingController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'sailing' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/sailing',
                            'defaults' => [
                                'action' => 'sailing',
                            ],
                        ],
                    ],
                    'windsurfing' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/windsurfing',
                            'defaults' => [
                                'action' => 'windsurfing',
                            ],
                        ],
                    ],
                    'racing' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/racing',
                            'defaults' => [
                                'action' => 'racing',
                            ],
                        ],
                    ],
                    'powerboat' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/powerboat',
                            'defaults' => [
                                'action' => 'powerboat',
                            ],
                        ],
                    ],
                ],
            ],
            'sailing' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/sailing',
                    'defaults' => [
                        'controller' => Controller\SailingController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'results' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/results[/:year/:result]',
                            'defaults' => [
                                'action' => 'results',
                            ],
                        ],
                    ],
                    'instructions' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/instructions',
                            'defaults' => [
                                'action' => 'instructions',
                            ],
                        ],
                    ],
                ],
            ],
            'join' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/join',
                    'defaults' => [
                        'controller' => Controller\JoinUsController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'open' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/open-series',
                            'defaults' => [
                                'action' => 'open',
                            ],
                        ],
                    ],
                    'membership' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/membership',
                            'defaults' => [
                                'action' => 'membership',
                            ],
                        ],
                    ],
                    'group' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/group',
                            'defaults' => [
                                'action' => 'group',
                            ],
                        ],
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
                    'register' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/register',
                            'defaults' => [
                                'action' => 'register',
                            ],
                        ],
                    ],
                    'reset' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/reset[/:resetcode]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9]+',
                                'action'     => '[a-zA-Z][a-zA-Z0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'reset',
                            ],
                        ],
                    ],
                    'my_account' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/my-account',
                            'defaults' => [
                                'action' => 'my-account',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Application\Db\ReadOnlyDBAdapter' => Laminas\Db\Adapter\Driver\DriverInterface::class,
            'Application\DB\ReadWriteDBAdapter' => Laminas\Db\Adapter\Driver\DriverInterface::class,
            AuthenticationService::class => LoginAuthenticatorFactory::class,
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
            'application/about/about'           => __DIR__ . '/../view/application/about/index.phtml',
            'application/membership/logout'     => __DIR__ . '/../view/application/membership/index.phtml',
            'error/404'                         => __DIR__ . '/../view/error/404.phtml',
            'error/index'                       => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
