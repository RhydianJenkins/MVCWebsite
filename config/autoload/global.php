<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    // 'db' => [
    //     'driver' => 'Pdo',
    //     'dsn'    => 'mysql:dbname=tata_steel_membership;host=localhost;charset=utf8',
    // ],
    'db' => [
        'adapters' => [
            'Application\DB\ReadOnlyDBAdapter' => [
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=tata_steel_membership;host=localhost;charset=utf8',
            ],
        ],
    ],
    'session_manager' => [
        'config' => [
            'class' => Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'MVCWebsite',
            ],
        ],
        'storage' => Session\Storage\SessionArrayStorage::class,
        'validators' => [
            Session\Validator\RemoteAddr::class,
            Session\Validator\HttpUserAgent::class,
        ],
    ],
];
