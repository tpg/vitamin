<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class VitaminConfigInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing Vitamin configuration');

        copy(__DIR__.'/../../config/vitamin.php', config_path('vitamin.php'));

        $this->output->writeln('... [<info>✔</info>]');

    }
}
