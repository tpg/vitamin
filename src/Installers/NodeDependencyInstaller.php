<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Process\Process;

class NodeDependencyInstaller extends AbstractInstaller
{
    protected array $dependencies = [
        '@heroicons/vue',
        '@inertiajs/inertia',
        '@inertiajs/inertia-vue3',
        '@inertiajs/progress',
        '@tailwindcss/typography',
        '@vitejs/plugin-vue',
        '@vue/compiler-sfc',
        'autoprefixer@latest',
        'axios',
        'lodash',
        'postcss@latest',
        'tailwindcss@latest',
        'vite@^2.9.0',
        'vue',
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
