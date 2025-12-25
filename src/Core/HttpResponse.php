<?php

namespace Nishadil\SocialPostman\Core;

class HttpResponse
{
    public function __construct(
        public int $status,
        public ?string $body,
        public ?string $error
    ) {}

    public function ok(): bool
    {
        return $this->status >= 200 && $this->status < 300;
    }

    public function json(): array
    {
        return json_decode($this->body ?? '', true) ?? [];
    }
}
