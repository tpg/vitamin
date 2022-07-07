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

        $ext = $this->option('ts') ? 'ts' : 'js';

        return [
            $this->stubPath('bootstrap.'.$ext) => resource_path($jsPath.'/bootstrap.'.$ext),
            $this->stubPath('Router.'.$ext) => resource_path($jsPath.'/Scripts/Routing/Router.'.$ext),
            $this->stubPath('app.'.$ext) => resource_path($jsPath.'/app.'.$ext),
        ];
    }

    protected function filesToRemove(): array
    {
        return [
            resource_path('js/app.js'),
            resource_path('js/bootstrap.js'),
            base_path('webpack.mix.js'),
        ];
    }

    public function handle(): void
    {
        $this->start($this->option('ts') ? 'Installing TS files' : 'Installing JS files');

        $this->done();
    }
}
