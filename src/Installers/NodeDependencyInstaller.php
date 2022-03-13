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
        'vite',
        'vue@next',
    ];

    public function handle(): void
    {
        $this->start('Installing node dependencies');

        $process = $this->getProcessRunner($this->dependencies);

        $process->run(function (string $type, string $buffer) {
            $this->output->write('.');
        });

        $this->done();
    }

    protected function getProcessRunner(array $dependencies = []): Process
    {
        return Process::fromShellCommandline('yarn add '.implode(' ', $dependencies).' -D', timeout: 0);
    }
}
