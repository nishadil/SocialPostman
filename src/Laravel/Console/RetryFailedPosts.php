<?php

namespace Nishadil\SocialPostman\Laravel\Console;

use Illuminate\Console\Command;
use Nishadil\SocialPostman\Queue\RetryWorker;

class RetryFailedPosts extends Command
{
    protected $signature = 'socialpostman:retry';
    protected $description = 'Retry failed SocialPostman background jobs';

    public function handle(): int
    {
        (new RetryWorker())->run();

        $this->info('SocialPostman retry worker executed.');
        return self::SUCCESS;
    }
}
