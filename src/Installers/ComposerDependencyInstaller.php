<?php

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ComposerDependencyInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing composer dependencies');

        $this->getProcessInstance(Arr::get($settings, 'composer.require'))->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->output->writeln('[<info>✔</info>]');
        $this->output->write('Installing composer dev dependencies');

        $this->getProcessInstance(Arr::get($settings, 'composer.dev'), true)->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->output->writeln('[<info>✔</info>]');
    }

    protected function getProcessInstance(array $packages, bool $dev = false): Process
    {
        $command = 'composer require';
        if ($dev) {
            $command .= '--dev';
        }
        return Process::fromShellCommandline($command.' '.implode(' ', $packages));
    }
}
