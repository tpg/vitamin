<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

class ComposerDependencyInstaller extends AbstractInstaller
{
    protected array $require = [
        'inertiajs/inertia-laravel',
        'tightenco/ziggy',
    ];

    protected array $dev = [
    ];

    public function handle(): void
    {
        $this->dependencies();
        $this->dependencies(dev: true);
    }

    protected function dependencies(bool $dev = false): void
    {
        $this->start('Installing '. ($dev ? 'dev ' : null) .'composer dependencies');

        $dependencies = $dev ? $this->dev : $this->require;

        $this->getProcessInstance($dependencies, $dev);

        $this->done();
    }

    protected function getProcessInstance(array $packages, bool $dev = false): void
    {
        $command = 'composer require';
        if ($dev) {
            $command .= ' --dev';
        }

        $this->runShellCommand($command. ' '.implode(' ', $packages));
    }
}
