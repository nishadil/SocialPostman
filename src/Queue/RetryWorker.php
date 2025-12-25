<?php

namespace Nishadil\SocialPostman\Queue;

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Core\Logger;

class RetryWorker
{
    protected int $maxAttempts = 5;

    public function run(): void
    {
        $store = new RetryStore();
        $jobs = $store->all();
        $remaining = [];

        foreach ($jobs as $job) {
            if ($job['attempts'] >= $this->maxAttempts) {
                Logger::error('Retry limit exceeded', $job);
                continue;
            }

            if (time() < $job['next_retry_at']) {
                $remaining[] = $job;
                continue;
            }

            try {
                $postman = new SocialPostman();
                $postman->post(
                    $job['provider'],
                    $job['data'],
                    false
                );

                Logger::info('Retry succeeded', $job);
            } catch (\Throwable $e) {
                $job['attempts']++;
                $job['error'] = $e->getMessage();
                $job['next_retry_at'] = time() + ($job['attempts'] * 30);

                $remaining[] = $job;
                Logger::error('Retry failed', $job);
            }
        }

        $store->overwrite($remaining);
    }
}
