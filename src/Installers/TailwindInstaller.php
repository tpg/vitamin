<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;

class TailwindInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        return [
            'app.css' => resource_path('css/app.css'),
            'postcss.config.js' => base_path('postcss.config.js'),
            'tailwind.config.js' => base_path('tailwind.config.js'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing Tailwind');

        $this->done();
    }
}
