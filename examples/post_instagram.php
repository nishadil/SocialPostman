<?php

require __DIR__ . '/../vendor/autoload.php';

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\InstagramProvider;

$postman = new SocialPostman();

$postman->registerProvider('instagram', new InstagramProvider([
    'access_token'       => 'INSTAGRAM_GRAPH_ACCESS_TOKEN',
    'instagram_user_id'  => 'INSTAGRAM_BUSINESS_USER_ID'
]));

$postman->post('instagram', [
    'message'   => 'Hello Instagram 📸 via SocialPostman',
    'image_url' => 'https://example.com/image.jpg'
], background: true);
