<?php

namespace Nishadil\SocialPostman\Queue;

class RetryJob
{
    public static function create(
        string $provider,
        array $data,
        string $error,
        int $attempts = 1
    ): array {
        return [
            'id' => uniqid('job_', true),
            'provider' => $provider,
            'data' => $data,
            'error' => $error,
            'attempts' => $attempts,
            'created_at' => time(),
            'next_retry_at' => time() + self::backoff($attempts)
        ];
    }

    protected static function backoff(int $attempt): int
    {
        return min(300, $attempt * 30);
    }
}
