<?php

use Nishadil\SocialPostman\Queue\RetryStore;
use Nishadil\SocialPostman\Queue\RetryJob;
use Nishadil\SocialPostman\Core\Logger;

require __DIR__ . '/../../../vendor/autoload.php';

$payload = unserialize(base64_decode($argv[1]));

try {
    $provider = $payload['provider'];
    $data = $payload['data'];

    $provider->publish($data);
} catch (\Throwable $e) {
    $store = new RetryStore();

    $store->save(
        RetryJob::create(
            get_class($provider),
            $data,
            $e->getMessage()
        )
    );

    Logger::error('Background job failed', [
        'provider' => get_class($provider),
        'error' => $e->getMessage()
    ]);
}
