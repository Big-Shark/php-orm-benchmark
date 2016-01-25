<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter' => $_ENV['driver'],
                    'dsn' => $_ENV['driver'].':host='.$_ENV['host'].';port='.$_ENV['port'].';dbname='.$_ENV['database'],
                    'user' => $_ENV['username'],
                    'password' => $_ENV['password'],
                    'settings' => [
                        'charset' => 'utf8'
                    ]
                ]
            ]
        ]
    ]
];