<?php

declare(strict_types=1);

namespace TPG\Vitamin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use TPG\Vitamin\Contracts\VitaminInterface;
use TPG\Vitamin\Installers\AbstractInstaller;
use TPG\Vitamin\Installers\ComposerDependencyInstaller;
use TPG\Vitamin\Installers\ConfigInstaller;
use TPG\Vitamin\Installers\InertiaInstaller;
use TPG\Vitamin\Installers\JavaScriptInstaller;
use TPG\Vitamin\Installers\NodeDependencyInstaller;
use TPG\Vitamin\Installers\NodeScriptInstaller;
use TPG\Vitamin\Installers\TailwindInstaller;
use TPG\Vitamin\Installers\ViewComposerInstaller;
use TPG\Vitamin\Installers\VitaminConfigInstaller;

class InitCommand extends Command
{
    protected $signature = 'vitamin:init';

    protected $description = 'Initialize a new Vitamin project';

    public function handle(VitaminInterface $vitamin): int
    {
        $this->info('Running this command will overwrite some vital files that may cause an existing Laravel project to fail.');
        if ($this->confirm('Are you sure you want to continue?', false)) {
            return $this->install($vitamin);
        }

        $this->info('No changes have been made.');
        return 1;
    }

    protected function install(VitaminInterface $vitamin): int
    {
        $host = $this->getHost();
        $port = $this->getPort();
        $js = $this->getJsPath();
        $pages = $this->getPagesPath($js);

        $settings = [
            'variables' => [
                '$HOST$' => $host,
                '$PORT$' => $port,
                '$JSPATH$' => $js,
                '$PAGESPATH$' => $pages,
            ],
            'node' => [
                '@heroicons/vue',
                '@inertiajs/inertia',
                '@inertiajs/inertia-vue3',
                '@inertiajs/progress',
                '@vitejs/plugin-vue',
                '@vue/compiler-sfc',
                'autoprefixer@latest',
                'axios',
                'lodash',
                'postcss@latest',
                'tailwindcss@latest',
                'vite',
                'vue@next',
            ],
            'composer' => [
                'require' => [
                    'inertiajs/inertia-laravel',
                    'laravel/horizon',
                    'laravel/telescope',
                    'thepublicgood/deadbolt',
                    'thepublicgood/is-presentable',
                    'tightenco/ziggy',
                ],
                'dev' => [
                    'laravel/envoy',
                    'roave/security-advisories',
                ],
            ]
        ];

        if ($vitamin->getInstallers()->count() === 0) {
            $vitamin->initializeInstallers($this->input, $this->output);
        }

        collect($vitamin->getInstallers())
            ->each(fn (AbstractInstaller $installer) => $installer->run($settings));

        return 0;
    }

    protected function getHost(): string
    {
        return $this->ask('What hostname are you using in development? (e.g.: valet.test):');
    }

    protected function getPort(): int
    {
        return $this->ask('What port number should Vite use?', 3000);
    }

    protected function getJsPath(): string
    {
        return $this->stripSlashes(
            $this->ask('Where are your JS sources stored? (relative to resources directory)', 'js')
        );
    }

    protected function getPagesPath(string $jsPath): string
    {
        return $this->stripSlashes(
            $this->ask('Where are your Inertia Vue pages stored? (relative to resources directory)', $jsPath.'/Pages')
        );
    }

    protected function stripSlashes(string $path): string
    {
        if (Str::startsWith($path, '/')) {
            $path = Str::after($path, '/');
        }

        if (Str::endsWith($path, '/')) {
            $path = Str::beforeLast($path, '/');
        }

        return $path;
    }
}
