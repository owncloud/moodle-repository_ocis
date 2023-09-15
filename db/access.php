<?php
$capabilities = [
    // Ability to use the plugin.
    'repository/ocis:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => [
            'user' => CAP_ALLOW
        ]
    ],
];
