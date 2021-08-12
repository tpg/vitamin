<?php

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NodeScriptInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $this->output->write('Installing scripts');

        $package = json_decode(
            file_get_contents(base_path('package.json')),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $package['scripts'] = $settings['scripts'];

        file_put_contents(
            base_path('package.json'),
            json_encode($package, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR)
        );

        $this->output->writeln('...[<info>✔</info>]');
    }
}
