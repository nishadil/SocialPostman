<?php

namespace Nishadil\SocialPostman\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nishadil\SocialPostman\SocialPostman;

class PublishSocialPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $provider;
    protected array $data;

    public function __construct(string $provider, array $data)
    {
        $this->provider = $provider;
        $this->data = $data;
    }

    public function handle(SocialPostman $postman): void
    {
        $postman->post($this->provider, $this->data, false);
    }
}
