<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JavaScriptInstaller implements InstallerContract
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    public function handle(array $settings = []): void
    {
        $files = [
            'bootstrap.js',
            'router.js',
            'app.js',
        ];

        $remove = [
            'webpack.mix.js',
        ];

        $this->output->write('Installing JS files');
        collect($files)->each(function ($file) use ($settings) {
            $data = file_get_contents(__DIR__.'/../../stubs/'.$file);

            foreach ($settings['variables'] as $var => $value) {
                $data = str_replace($var, $value, $data);
            }

            file_put_contents(base_path('resources/js/'.$file), $data);
            $this->output->write('.');
        });

        collect($remove)->each(function ($file) {
            if (file_exists(base_path($file))) {
                unlink(base_path($file));
                $this->output->write('.');
            }
        });

        $this->output->writeln('[<info>✔</info>]');

    }
}
