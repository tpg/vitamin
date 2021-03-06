<?php

declare(strict_types=1);

namespace TPG\Vitamin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TPG\Vitamin\Console\InitCommand;
use TPG\Vitamin\Console\ViteServeCommand;
use TPG\Vitamin\Contracts\VitaminInterface;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InitCommand::class,
                ViteServeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/vitamin.php' => config_path('vitamin.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/vitamin.php', 'vitamin'
        );

        $this->app->singleton(VitaminInterface::class, Vitamin::class);

        View::composer('app', config('vitamin.composer'));
    }
}
