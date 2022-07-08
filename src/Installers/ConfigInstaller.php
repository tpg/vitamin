<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        $ext = $this->option('ts') ? 'ts' : 'js';

        $files = [
            $this->stubPath('jsconfig.json') => base_path('jsconfig.json'),
            $this->stubPath('vite.config.'.$ext) => base_path('vite.config.'.$ext),
            $this->stubPath('LocalValetDriver.php') => base_path('LocalValetDriver.php'),
        ];

        if ($this->option('ts')) {
            $files[$this->stubPath('tsconfig.json')] = base_path('tsconfig.json');
        }

        return $files;
    }

    protected function filesToRemove(): array
    {
        return [
            base_path('vite.config.js'),
        ];
    }


    public function handle(): void
    {
        $this->start('Installing configs');

        $this->done();
    }
}
