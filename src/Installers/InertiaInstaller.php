<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class InertiaInstaller extends AbstractInstaller
{
    protected function filesToRemove(): array
    {
        return [
            resource_path('views/welcome.blade.php'),
        ];
    }

    protected function filesToCopy(): array
    {
        return [
            $this->stubPath('app.blade.php') => resource_path('views/app.blade.php'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing Inertia');

        $this->installMiddleware();
        $this->buildRoutes();
        $this->createPaths($this->settings);

        $this->done();
    }

    protected function installMiddleware(): void
    {
        $this->runArtisanCommand('inertia:middleware');

        $this->insert(app_path('Http/Kernel.php'), [
            str_repeat(' ', 12).'\App\Http\Middleware\HandleInertiaRequests::class',
        ], 'SubstituteBindings::class');
    }

    protected function buildRoutes(): void
    {
        $this->runShellCommand('yarn routes');
    }

    public function createPaths(array $settings): void
    {
        $paths = [
            Arr::get($settings, 'variables.$PAGESPATH$'),
        ];

        foreach ($paths as $path) {
            $fullPath = base_path('resources/'.$path);
            if (! is_dir($fullPath)) {
                $this->makeDirectory($fullPath);
            }

            $this->output->write('.');
        }
    }
}
