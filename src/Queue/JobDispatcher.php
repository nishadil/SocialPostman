<?php

namespace Nishadil\SocialPostman\Queue;

use Nishadil\SocialPostman\Contracts\SocialProviderInterface;

class JobDispatcher
{
    public function dispatch(SocialProviderInterface $provider, array $data): bool
    {
        $payload = base64_encode(serialize([
            'provider' => $provider,
            'data' => $data
        ]));

        $command = sprintf(
            'php %s "%s" > /dev/null 2>&1 &',
            __DIR__ . '/BackgroundJob.php',
            $payload
        );

        exec($command);
        return true;
    }
}
