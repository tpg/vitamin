<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

class NodeScriptInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        return [
            'package.json' => base_path('package.json'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing scripts');

        $this->done();
    }
}
