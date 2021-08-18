<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

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
        $this->output->write('.');

        $this->buildRoutes();
        $this->output->write('.');

        $this->output->writeln('[<info>✔</info>]');
    }

    protected function installMiddleware(): void
    {
        $process = Process::fromShellCommandline('php ./artisan inertia:middleware');
        $process->run();
    }

    protected function buildRoutes(): void
    {
        $process = Process::fromShellCommandline('yarn routes');
        $process->run();
    }
}
