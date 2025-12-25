<?php

namespace Nishadil\SocialPostman\Providers;

use Nishadil\SocialPostman\Contracts\SocialProviderInterface;
use Nishadil\SocialPostman\Core\HttpClient;
use Nishadil\SocialPostman\Core\Logger;

class FacebookProvider implements SocialProviderInterface
{
    protected HttpClient $http;
    protected string $token;
    protected string $pageId;

    public function __construct(array $config)
    {
        $this->token = $config['access_token'];
        $this->pageId = $config['page_id'];
        $this->http = new HttpClient();
    }

    public function publish(array $data): bool
    {
        $response = $this->http->post(
            "https://graph.facebook.com/v19.0/{$this->pageId}/feed",
            ['Content-Type: application/x-www-form-urlencoded'],
            http_build_query([
                'message' => $data['message'],
                'access_token' => $this->token
            ])
        );

        if (!$response->ok()) {
            Logger::error('Facebook post failed', $response->json());
            return false;
        }

        return true;
    }
}
