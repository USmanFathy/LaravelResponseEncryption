<?php

return [
    /*
     * Enable/disable encryption globally
     */
    'enabled' => env('RESPONSE_ENCRYPTION_ENABLED', true),

    /*
     * Content types to encrypt
     */
    'content_types' => [
        'application/json',
    ],

    /*
     * Routes to exclude from encryption
     * (supports wildcards *)
     */
    'except' => [
    ],
];