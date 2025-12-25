<?php

namespace Nishadil\SocialPostman\Queue;

class RetryStore
{
    protected string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../storage/retry_jobs.json';

        if (!file_exists(dirname($this->file))) {
            mkdir(dirname($this->file), 0777, true);
        }

        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function all(): array
    {
        return json_decode(file_get_contents($this->file), true) ?? [];
    }

    public function save(array $job): void
    {
        $jobs = $this->all();
        $jobs[] = $job;
        file_put_contents($this->file, json_encode($jobs, JSON_PRETTY_PRINT));
    }

    public function overwrite(array $jobs): void
    {
        file_put_contents($this->file, json_encode($jobs, JSON_PRETTY_PRINT));
    }
}
