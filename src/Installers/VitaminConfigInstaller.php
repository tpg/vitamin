<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class   VitaminConfigInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        return [
            __DIR__.'/../../config/vitamin.php' => config_path('vitamin.php'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing Vitamin configuration');

        if ($this->option('ts')) {
            $config = str_replace('\'ts\' => false', '\'ts\' => true', file_get_contents(config_path('vitamin.php')));
            file_put_contents(config_path('vitamin.php'), $config);
        }

        $this->updateEnv();

        $this->done();
    }

    protected function updateEnv(): void
    {
        $url = 'http://'.Arr::get($this->variables, '$HOST$');

        $env = preg_replace(
            '/^APP_URL\=(?:.+)$/m',
            'APP_URL='.$url,
            file_get_contents(base_path('.env'))
        );

        file_put_contents(base_path('.env'), $env);

        $this->output->write('.');
    }
}
