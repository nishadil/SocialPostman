<?php

return [

    'queue' => env('SOCIALPOSTMAN_QUEUE', true),

    'providers' => [

        'facebook' => [
            'access_token' => env('FACEBOOK_ACCESS_TOKEN'),
            'page_id' => env('FACEBOOK_PAGE_ID'),
        ],

        'instagram' => [
            'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),
            'instagram_user_id' => env('INSTAGRAM_USER_ID'),
        ],

        'linkedin' => [
            'access_token' => env('LINKEDIN_ACCESS_TOKEN'),
            'author' => env('LINKEDIN_AUTHOR_URN'),
        ],

        'twitter' => [
            'bearer_token' => env('TWITTER_BEARER_TOKEN'),
        ],
    ],
];
