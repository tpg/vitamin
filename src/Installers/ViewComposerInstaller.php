<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

class ViewComposerInstaller extends AbstractInstaller
{

    protected function filesToCopy(): array
    {
        return [
            $this->stubPath('AppComposer.php.stub') => app_path('Http/Composers/AppComposer.php'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing the view composer...');

        $this->done();
    }
}
