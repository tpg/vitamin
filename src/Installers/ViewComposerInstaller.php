<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewComposerInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing the view composer...');

        if (! is_dir($path = app_path('Http/Composers'))) {
            if (! mkdir($path) && ! is_dir($path)) {
                throw new \RuntimeException('Could not create directory '.$path);
            }
        }
        copy(__DIR__.'/../../stubs/AppComposer.php', app_path('Http/Composers/AppComposer.php'));

        $this->output->writeln('...[<info>✔</info>]');
    }
}
