<?php

require __DIR__ . '/../vendor/autoload.php';

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\FacebookProvider;

$postman = new SocialPostman();
$postman->registerProvider('facebook', new FacebookProvider([
    'access_token' => 'YOUR_FACEBOOK_ACCESS_TOKEN',
]));

$postman->post('facebook', [
    'message' => 'Hello World from SocialPostman 🚀',
    'image' => __DIR__ . '/image.png'
], background: true);
