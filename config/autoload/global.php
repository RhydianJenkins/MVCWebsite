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
    // Below settings should not be committed to version control (See README.md)
    'db' => [
        'adapters' => [
            'Application\DB\localDbAdapter' => [
                'driver' => 'Pdo',
                'dsn'    => '',
                'user' => '',
                'password' => '',
            ],
            'Application\DB\remoteDBAdapter' => [
                'driver' => 'Pdo',
                'dsn'    => '',
                'user' => '',
                'password' => '',
            ]
        ]
    ],
    'keystore' => [
        'api' => [
            'maps' => '',
            'weather' => '',
            'reCaptchaSite' => '',
            'reCaptchaSecret' => '',
        ],
    ],
];
