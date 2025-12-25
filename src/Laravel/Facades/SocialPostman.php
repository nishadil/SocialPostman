<?php

namespace Nishadil\SocialPostman\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class SocialPostman extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Nishadil\SocialPostman\SocialPostman::class;
    }
}
