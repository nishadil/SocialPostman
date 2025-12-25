<?php

namespace Nishadil\SocialPostman\Laravel;

use Illuminate\Support\ServiceProvider;
use Nishadil\SocialPostman\SocialPostman;

class SocialPostmanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/socialpostman.php',
            'socialpostman'
        );

        $this->app->singleton(SocialPostman::class, function () {
            return new SocialPostman();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/socialpostman.php' => config_path('socialpostman.php'),
        ], 'socialpostman-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\RetryFailedPosts::class,
            ]);
        }
    }
}
