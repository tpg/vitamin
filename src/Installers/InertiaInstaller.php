<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InertiaInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing Inertia');

        if (file_exists($welcome = resource_path('views/welcome.blade.php'))) {
            unlink($welcome);
            $this->output->write('.');
        }

        copy(__DIR__.'/../../stubs/app.blade.php', resource_path('views').'/app.blade.php');
        $this->output->write('.');

        $this->installMiddleware();
        $this->buildRoutes();
        $this->createPaths($settings);

        $this->output->writeln('[<info>✔</info>]');
    }

    protected function installMiddleware(): void
    {
        $process = Process::fromShellCommandline('php ./artisan inertia:middleware');
        $process->run();
        $this->output->write('.');

        $lines = collect(File::lines(app_path('Http/Kernel.php'))->toArray());
        $index = $lines->filter(fn ($line) => strstr($line, 'SubstituteBindings::class'))->keys()->first();
        $after = $lines->splice($index + 1);

        $lines->push(str_repeat(' ', 12).'\App\Http\Middleware\HandleInertiaRequests::class,');
        $lines = $lines->concat($after);

        file_put_contents(app_path('Http/Kernel.php'), implode("\n", $lines->toArray()));
        $this->output->write('.');
    }

    protected function buildRoutes(): void
    {
        $process = Process::fromShellCommandline('yarn routes');
        $process->run();
        $this->output->write('.');
    }

    public function createPaths(array $settings): void
    {
        $paths = [
            Arr::get($settings, 'variables.$PAGESPATH$'),
        ];

        foreach ($paths as $path) {
            $fullPath = base_path('resources/'.$path);
            if (! is_dir($fullPath)) {
                if (! mkdir($fullPath) && ! is_dir($fullPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $fullPath));
                }
            }

            $this->output->write('.');
        }
    }
}
