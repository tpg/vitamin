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
        return [
            $this->stubPath('jsconfig.json.stub') => base_path('jsconfig.json'),
            $this->stubPath('vite.config.js.stub') => base_path('vite.config.js'),
            $this->stubPath('LocalValetDriver.php.stub') => base_path('LocalValetDriver.php'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing configs');

        $this->done();
    }
}
