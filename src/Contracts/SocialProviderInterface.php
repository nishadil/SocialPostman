<?php

namespace Nishadil\SocialPostman\Contracts;

interface SocialProviderInterface
{
    public function publish(array $data): bool;
}
