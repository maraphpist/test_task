<?php

return [
    'sections' => [
        'manage' => [
            'title' => 'Администрирование',
            'items' => [
                [
                    'is_tree' => false,
                    'title' => 'Администраторы',
                    'route_name' => 'admin.admins',
                    'item_active_on' => 'admin/admins*',
                    'icon' => 'la la-users',
                    'roles' => [
                        'admin'
                    ]
                ]
            ],
            'roles' => [
                'admin'
            ]
        ],

        'contents' => [
            'title' => 'Контент',
            'for_super_user' => false,
            'items' => [
                [
                    'is_tree' => false,
                    'title' => 'Аудио файлы',
                    'route_name' => 'admin.audio',
                    'item_active_on' => 'admin/audio*',
                    'icon' => 'flaticon flaticon-file',
                    'roles' => [
                        'admin',
                        'manager'
                    ]
                ]
            ],
            'roles' => [
                'admin',
                'manager'
            ]
        ]
    ]
];
