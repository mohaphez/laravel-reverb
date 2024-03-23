<?php

declare(strict_types=1);

return [
    'account_status' => [
        'free'       => 'Free',
        'limited'    => 'Limited',
        'banned'     => 'Banned',
        'removed'    => 'Removed',
        'classified' => 'Classified',

        'colors' => [
            'free'       => 'success',
            'limited'    => 'warning',
            'banned'     => 'danger',
            'removed'    => '',
            'classified' => 'info',
        ],
    ],

    'account_type' => [
        'member'       => 'User',
        'manager'      => 'Manager',
        'system'       => 'System',
        'sudo'         => 'Sudo',
        'parcel_owner' => 'Parcel Owner',

        'colors' => [
            'member'       => 'warning',
            'manager'      => 'success',
            'system'       => 'primary',
            'sudo'         => 'danger',
            'parcel_owner' => ''
        ],
    ],
];
