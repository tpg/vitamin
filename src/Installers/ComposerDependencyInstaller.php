<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

class ComposerDependencyInstaller extends AbstractInstaller
{
    protected array $require = [
        'inertiajs/inertia-laravel',
        'laravel/horizon',
        'laravel/telescope',
        'thepublicgood/is-presentable',
        'tightenco/ziggy',
    ];

    protected array $dev = [
        'laravel/envoy',
        'roave/security-advisories',
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
