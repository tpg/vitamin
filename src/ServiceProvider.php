<?php

declare(strict_types=1);

namespace TPG\Vitamin;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TPG\Vitamin\Composers\AppComposer;
use TPG\Vitamin\Console\InitCommand;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole() && ! file_exists(base_path('vite.config.js'))) {
            $this->commands([
                InitCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        View::composer('app', AppComposer::class);
//        Blade::directive('vitamin', function (string $jsPath = null) {
//            return (new Vitamin())->getViteAssets($jsPath);
//        });
    }
}
