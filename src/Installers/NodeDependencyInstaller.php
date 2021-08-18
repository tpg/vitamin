<?php

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class NodeDependencyInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $dependencies = $settings['node'] ?? [];

        $process = $this->getProcessRunner($dependencies);

        $this->output->write('Installing node dependencies');
        $process->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->output->writeln('[<info>✔</info>]');
    }

    protected function getProcessRunner(array $dependencies = []): Process
    {
        return Process::fromShellCommandline('yarn add --dev '.implode(' ', $dependencies));
    }
}
