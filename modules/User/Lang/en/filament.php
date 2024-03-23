<?php

declare(strict_types=1);

return [

    'manager' => [

        'user' => [

            'model'  => 'User',
            'plural' => 'Users',

            'inputs' => [
                'name' => [
                    'label' => 'Name',
                ],
                'email' => [
                    'label' => 'Email',
                ],
                'password' => [
                    'label' => 'Password',
                ],
                'account_status' => [
                    'label' => 'Account Status',
                ],
                'account_type' => [
                    'label' => 'Account Type',
                ],
                'roles' => [
                    'label' => 'Roles',
                ],
                'permissions' => [
                    'label' => 'Permissions',
                ],
                'sites' => [
                    'label' => 'Sites',
                ],
            ],

            'table' => [
                'th' => [
                    'name'              => 'Name',
                    'email'             => 'Email',
                    'account_status'    => 'Status',
                    'account_type'      => 'Type',
                    'roles'             => 'Roles',
                    'registration_date' => 'Registration date',
                    'last_login_date'   => 'Last login',
                ]
            ],
        ],


    ]
];
