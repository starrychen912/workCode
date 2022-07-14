<?php

return [
    'autoload' => false,
    'hooks' => [
        'sms_send' => [
            'alisms',
        ],
        'sms_notice' => [
            'alisms',
        ],
        'sms_check' => [
            'alisms',
        ],
        'ems_send' => [
            'faems',
        ],
        'ems_notice' => [
            'faems',
        ],
        'upgrade' => [
            'shopro',
        ],
        'app_init' => [
            'shopro',
        ],
    ],
    'route' => [],
    'priority' => [],
    'domain' => '',
];
