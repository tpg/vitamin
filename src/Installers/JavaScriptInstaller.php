<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

class JavaScriptInstaller extends AbstractInstaller
{
    protected function filesToCopy(): array
    {
        $jsPath = Arr::get($this->variables, '$JSPATH$');

        return [
            $this->stubPath('bootstrap.js.stub') => resource_path($jsPath.'/bootstrap.js'),
            $this->stubPath('Router.js.stub') => resource_path($jsPath.'/Scripts/Routing/Router.js'),
            $this->stubPath('app.js.stub') => resource_path($jsPath.'/app.js'),
        ];
    }

    protected function filesToRemove(): array
    {
        return [
            base_path('webpack.mix.js'),
        ];
    }

    public function handle(): void
    {
        $this->start('Installing JS files');

        $this->done();
    }
}
