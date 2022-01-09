<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Process\Process;

class NodeDependencyInstaller extends AbstractInstaller
{
    public function handle(array $settings = []): void
    {
        $this->start('Installing node dependencies');

        $dependencies = $settings['node'] ?? [];

        $process = $this->getProcessRunner($dependencies);

        $process->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->done();
    }

    protected function getProcessRunner(array $dependencies = []): Process
    {
        return Process::fromShellCommandline('yarn add --dev '.implode(' ', $dependencies), timeout: 0);
    }
}
