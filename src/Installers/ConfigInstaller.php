<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigInstaller implements InstallerContract
{
    public function __construct(public InputInterface $input, public OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $files = [
            'jsconfig.json',
            'vite.config.js',
            'LocalValetDriver.php',
        ];

        $this->output->write('Installing configs');
        collect($files)->each(function ($file) use ($settings) {
            $data = file_get_contents(__DIR__.'/../../stubs/'.$file);

            foreach ($settings['variables'] as $var => $value) {
                $data = str_replace($var, $value, $data);
            }

            file_put_contents(base_path($file), $data);
            $this->output->write('.');
        });

        $this->output->writeln('[<info>✔</info>]');
    }
}
