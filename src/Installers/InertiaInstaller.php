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
            $this->stubPath('app.blade.php.stub') => resource_path('views/app.blade.php'),
            $this->stubPath('Welcome.vue.stub') => resource_path($this->fullPagesPath().'/Welcome.vue'),
            $this->stubPath('web.routes.php.stub') => base_path('routes/web.php'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing Inertia');

        $this->installMiddleware();
        $this->buildRoutes();
        $this->createPaths();

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
        $exec = $this->nodeManager('run');
        $this->runShellCommand($exec.' routes');
    }

    public function createPaths(): void
    {
        $paths = [
            $this->fullPagesPath(),
        ];

        foreach ($paths as $path) {
            $fullPath = base_path('resources/'.$path);
            if (! is_dir($fullPath)) {
                $this->makeDirectory($fullPath);
            }

            $this->output->write('.');
        }
    }

    protected function fullPagesPath(): string
    {
        return Arr::get($this->variables, '$JSPATH$').'/'.Arr::get($this->variables, '$PAGESPATH$');
    }
}
