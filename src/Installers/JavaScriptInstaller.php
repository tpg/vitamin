<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;

class JavaScriptInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        $jsPath = Arr::get($this->settings, 'variables.$JSPATH$');

        return [
            'bootstrap.js' => resource_path($jsPath.'/bootstrap.js'),
            'router.js' => resource_path($jsPath.'/router.js'),
            'app.js' => resource_path($jsPath.'/app.js'),
        ];
    }

    protected function filesToRemove(): array
    {
        return [
            base_path('webpack.mix.js'),
        ];
    }

    public function handle(array $settings = []): void
    {
        $this->start('Installing JS files');

        $this->done();
    }
}
