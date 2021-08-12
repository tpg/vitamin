<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class TailwindInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing Tailwind');

        copy(__DIR__.'/../../stubs/app.css', resource_path('css/app.css'));
        $this->output->write('.');

        $process = Process::fromShellCommandline('npx tailwind init -p');
        $process->run();
        $this->output->write('.');

        $this->output->writeln('[<info>✔</info>]');
    }
}
