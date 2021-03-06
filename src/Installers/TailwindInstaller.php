<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;

class TailwindInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        return [
            $this->stubPath('app.css.stub') => resource_path('css/app.css'),
            $this->stubPath('postcss.config.js.stub') => base_path('postcss.config.js'),
            $this->stubPath('tailwind.config.js.stub') => base_path('tailwind.config.js'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing Tailwind');

        $this->done();
    }
}
