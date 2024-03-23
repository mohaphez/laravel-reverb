<?php

declare(strict_types=1);

return [
    'shield_resource' => [
        'should_register_navigation' => false,
        'slug'                       => sha1(str()->random(5)),
        'navigation_sort'            => -1,
        'navigation_badge'           => true,
        'navigation_group'           => false,
        'is_globally_searchable'     => false,
        'show_model_path'            => true,
    ],

    'auth_provider_model' => [
        'fqcn' => env('FILAMENT_SHIELD_USER_MODEL', 'App\\Models\\User'),
    ],

    'super_admin' => [
        'enabled'         => true,
        'name'            => 'sudo',
        'define_via_gate' => false,
        'intercept_gate'  => 'before',
        // after
    ],

    'filament_user' => [
        'enabled' => false,
        'name'    => 'filament_user',
    ],

    'permission_prefixes' => [
        'resource' => [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ],

        'page'   => 'page',
        'widget' => 'widget',
    ],

    'entities' => [
        'pages'              => true,
        'widgets'            => true,
        'resources'          => true,
        'custom_permissions' => true,
    ],

    'generator' => [
        'option' => 'policies_and_permissions',
    ],

    'exclude' => [
        'enabled' => true,

        'pages' => [
            'Dashboard',
        ],

        'widgets' => [
            'AccountWidget',
            'FilamentInfoWidget',
        ],

        'resources' => [],
    ],

    'register_role_policy' => false,

];
