<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

class ComposerDependencyInstaller extends AbstractInstaller
{
    public function handle(): void
    {
        $this->dependencies();
        $this->dependencies(true);

        $this->start('Installing composer dev dependencies');

        $this->getProcessInstance(Arr::get($this->settings, 'composer.dev'), true)->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->done();
    }

    protected function dependencies(bool $dev = false): void
    {
        $this->start('Installing '. ($dev ? 'dev ' : null) .'composer dependencies');

        $dependencies = Arr::get($this->settings, $dev ? 'composer.dev' : 'composer.require');

        $this->getProcessInstance($dependencies, $dev)->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->done();
    }

    protected function getProcessInstance(array $packages, bool $dev = false): Process
    {
        $command = 'composer require';
        if ($dev) {
            $command .= '--dev';
        }
        return Process::fromShellCommandline($command.' '.implode(' ', $packages), timeout: 0);
    }
}
