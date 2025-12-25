<?php

namespace Nishadil\SocialPostman\Providers;

use Nishadil\SocialPostman\Contracts\SocialProviderInterface;
use Nishadil\SocialPostman\Core\HttpClient;

class InstagramProvider implements SocialProviderInterface
{
    protected HttpClient $http;
    protected string $token;
    protected string $userId;

    public function __construct(array $config)
    {
        $this->token = $config['access_token'];
        $this->userId = $config['instagram_user_id'];
        $this->http = new HttpClient();
    }

    public function publish(array $data): bool
    {
        $create = $this->http->post(
            "https://graph.facebook.com/v19.0/{$this->userId}/media",
            ['Content-Type: application/x-www-form-urlencoded'],
            http_build_query([
                'image_url' => $data['image_url'],
                'caption' => $data['message'] ?? '',
                'access_token' => $this->token
            ])
        );

        if (!$create->ok()) {
            return false;
        }

        sleep(2);

        $id = $create->json()['id'] ?? null;
        if (!$id) {
            return false;
        }

        $publish = $this->http->post(
            "https://graph.facebook.com/v19.0/{$this->userId}/media_publish",
            ['Content-Type: application/x-www-form-urlencoded'],
            http_build_query([
                'creation_id' => $id,
                'access_token' => $this->token
            ])
        );

        return $publish->ok();
    }
}
