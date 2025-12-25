<?php

require __DIR__ . '/../vendor/autoload.php';

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\LinkedInProvider;

$postman = new SocialPostman();

$postman->registerProvider('linkedin', new LinkedInProvider([
    'access_token' => 'LINKEDIN_ACCESS_TOKEN',
    'author'       => 'urn:li:person:XXXXXXXX'
    // OR: urn:li:organization:YYYYYYYY
]));

$postman->post('linkedin', [
    'message' => '🚀 Posting to LinkedIn using SocialPostman (PHP)'
], background: true);
