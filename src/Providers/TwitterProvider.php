<?php

namespace Nishadil\SocialPostman\Providers;

use Nishadil\SocialPostman\Contracts\SocialProviderInterface;
use Nishadil\SocialPostman\Core\HttpClient;

class TwitterProvider implements SocialProviderInterface
{
    protected HttpClient $http;
    protected string $token;

    public function __construct(array $config)
    {
        $this->token = $config['bearer_token'];
        $this->http = new HttpClient();
    }

    public function publish(array $data): bool
    {
        $response = $this->http->post(
            'https://api.x.com/2/tweets',
            [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ],
            ['text' => $data['message']]
        );

        return $response->ok();
    }
}
