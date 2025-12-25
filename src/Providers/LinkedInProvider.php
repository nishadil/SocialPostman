<?php

namespace Nishadil\SocialPostman\Providers;

use Nishadil\SocialPostman\Contracts\SocialProviderInterface;
use Nishadil\SocialPostman\Core\HttpClient;

class LinkedInProvider implements SocialProviderInterface
{
    protected HttpClient $http;
    protected string $token;
    protected string $author;

    public function __construct(array $config)
    {
        $this->token = $config['access_token'];
        $this->author = $config['author'];
        $this->http = new HttpClient();
    }

    public function publish(array $data): bool
    {
        $response = $this->http->post(
            'https://api.linkedin.com/v2/ugcPosts',
            [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json',
                'X-Restli-Protocol-Version: 2.0.0'
            ],
            [
                'author' => $this->author,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => ['text' => $data['message']],
                        'shareMediaCategory' => 'NONE'
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ]
        );

        return $response->ok();
    }
}
