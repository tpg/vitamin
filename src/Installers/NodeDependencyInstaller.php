<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Process\Process;

class NodeDependencyInstaller extends AbstractInstaller
{
    protected array $dependencies = [
        '@inertiajs/inertia@latest',
        '@inertiajs/inertia-vue3@latest',
        '@inertiajs/progress@latest',
        '@tailwindcss/typography@latest',
        '@vitejs/plugin-vue@latest',
        '@vue/compiler-sfc@latest',
        'autoprefixer@latest',
        'axios@latest',
        'lodash@latest',
        'postcss@latest',
        'tailwindcss@latest',
        'vite@latest',
        'vue@latest',
    ];

    public function handle(): void
    {
        $this->start('Installing node dependencies using '.$this->dependencyManager);

        $this->runShellCommand($this->getCommand());

        $this->done();
    }

    protected function getCommand(): string
    {
        $exec = $this->nodeManager('add');
        return $exec.' '.implode(' ', $this->dependencies);
    }
}
