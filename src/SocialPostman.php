<?php

namespace Nishadil\SocialPostman;

use Nishadil\SocialPostman\Queue\JobDispatcher;
use Nishadil\SocialPostman\Contracts\SocialProviderInterface;

class SocialPostman
{
    protected array $providers = [];

    public function registerProvider(string $name, SocialProviderInterface $provider): void
    {
        $this->providers[$name] = $provider;
    }

    public function post(string $provider, array $data, bool $background = false): bool
    {
        if (!isset($this->providers[$provider])) {
            throw new \RuntimeException("Provider not registered: {$provider}");
        }

        if ($background) {
            return (new JobDispatcher())->dispatch(
                $this->providers[$provider],
                $data
            );
        }

        return $this->providers[$provider]->publish($data);
    }
}
