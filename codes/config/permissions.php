<?php

/**
 * List permission keys for this guard.
 * Roles will be set by default during first time
 * the permission key is being added
 * via console acl syncer
 *
 * Syntax
 * 'permission.key.name' => [
 *     'description' => 'Permission Key Description',
 *     'roles' => ['Defaut Role1', ...]
 * ]
 *
 * '.self' for only own entities can read/modify
 */

return [

    'guard:admin' => [

        'admin' => [
            'name' => 'Full Admin Access',
            'description' => 'Allow full control in admin panel',
            'roles' => ['Admin'],
        ],

        'admin.users' => [
            'name' => 'Users Management Section',
            'description' => '',
            'roles' => [],
        ],
        'admin.users.admins' => [
            'name' => 'Users Management Admins',
            'description' => '',
            'roles' => [],
        ],
        'admin.users.users' => [
            'name' => 'Users Management Users',
            'description' => '',
            'roles' => [],
        ],
        'admin.users.roles' => [
            'name' => 'Users Management Roles',
            'description' => '',
            'roles' => [],
        ],

        'admin.dashboard.widgets.total-admins' => [
            'name' => 'Dashboard Widget: Total Admins',
            'description' => '',
            'roles' => [],
        ],
        'admin.dashboard.widgets.total-users' => [
            'name' => 'Dashboard Widget: Total Users',
            'description' => '',
            'roles' => [],
        ],

        'admin.common' => [
            'name' => 'Common Section Management',
            'description' => '',
            'roles' => [],
        ],

        'admin.common.faqs' => [
            'name' => 'F.A.Q. Management',
            'description' => '',
            'roles' => [],
        ],

        'admin.common.contact-messages' => [
            'name' => 'Contact Messages Management',
            'description' => '',
            'roles' => [],
        ],
    ],

    'guard:web' => [],

    'guard:api' => [

    ],

];