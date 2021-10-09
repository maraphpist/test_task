<?php

return [
    'default_locale' => 'ru',
    'locales' => ['ru', 'en'],
    'adminWhiteIps' => [
        'white_list_enable' => env('ADMIN_WHITE_LIST_ENABLE', false),
        'white_list_access_by_token_enable' => env('ADMIN_WHITE_LIST_ACCESS_BY_TOKEN_ENABLE', false),
        'token' => env('ADMIN_WHITE_LIST_TOKEN', 'g9M5f3MGRQpB6vP3WSVaVVzemwYfqrpm'),
        'list' => [
            [
                'ip' => '188.0.151.149',
                'subnet' => null,
                'description' => 'IBEC Systems',
            ],
        ]
    ],
    'i18n_exporter' => [
        'enable' => false,
        'i18n_exporter_endpoint' => env('I18N_EXPORTER_ENDPOINT', 'http://127.0.0.1:4000'),
    ],
    'admin_prefix' => 'admin',

    'views' => [
        'defaults' => [
            'admin_navigation' => 'core::common.navigation',
            'admin_header_nav' => 'core::common.header_nav'
        ]
    ]

];
