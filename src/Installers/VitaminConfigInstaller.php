<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

class VitaminConfigInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        return [
            '../config/vitamin.php' => config_path('vitamin.php'),
        ];
    }

    public function handle(array $settings = []): void
    {
        $this->start('Installing Vitamin configuration');

        $this->done();

    }
}
