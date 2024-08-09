<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Eagerness
    |--------------------------------------------------------------------------
    |
    | This value is the default eagerness for the prerender and prefetch rules.
    | You can set it to 'eager', 'moderate' or 'conservative'.
    |
    */

    'default_eagerness' => 'moderate',

    /*
    |--------------------------------------------------------------------------
    | Prerender Rules
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom prerender rules for the application.
    |
    */

    'prerender' => [
//        [
//            'source' => 'list',
//            'urls' => ['page-1', 'page-2'],
//            'eagerness' => 'moderate',
//        ],
//        // parameter usage example
//        [
//            ['href_matches' => '/page-3/*'],
//            ['not' => ['href_matches' => '/page-3/*/*']],
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefetch Rules
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom prefetch rules for the application.
    |
    */

    'prefetch' => [
//        [
//            'urls' => ['page-4'],
//            'referrer_policy' => 'no-referrer',
//            'eagerness' => 'moderate',
//        ],
    ],

];
