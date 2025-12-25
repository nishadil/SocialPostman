<?php

require __DIR__ . '/../vendor/autoload.php';

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\TwitterProvider;

$postman = new SocialPostman();

$postman->registerProvider('twitter', new TwitterProvider([
    'bearer_token' => 'TWITTER_BEARER_TOKEN'
]));

$postman->post('twitter', [
    'message' => 'Hello X 👋 Posted using SocialPostman (PHP)'
], background: true);
