<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

class ViewComposerInstaller extends AbstractInstaller
{

    protected function filesToCopy(): array
    {
        return [
            'AppComposer.php' => app_path('Http/Composers/AppComposer.php'),
        ];
    }

    public function handle(array $settings = []): void
    {
        $this->start('Installing the view composer...');

        $this->done();
    }
}
