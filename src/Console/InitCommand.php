<?php

declare(strict_types=1);

namespace TPG\Vitamin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
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

    protected array $installers = [
        VitaminConfigInstaller::class,
        ConfigInstaller::class,
        NodeDependencyInstaller::class,
        NodeScriptInstaller::class,
        JavaScriptInstaller::class,
        TailwindInstaller::class,
        ComposerDependencyInstaller::class,
        InertiaInstaller::class,
//        ViewComposerInstaller::class,
    ];

    public function handle(): int
    {
        $this->info('Running this command will overwrite some vital files that may cause an existing Laravel project to fail.');
        if ($this->confirm('Are you sure you want to continue?', false)) {
            return $this->install();
        }

        $this->info('No changes have been made.');
        return 0;
    }

    protected function install(): int
    {

        $host = $this->getHost();
        $js = $this->getJsPath();
        $pages = $this->getPagesPath($js);

        $settings = [
            'variables' => [
                '$HOST$' => $host,
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
                'autoprefixer',
                'axios',
                'lodash',
                'postcss',
                'tailwindcss',
                'vite',
                'vue@next',
            ],
            'scripts' => [
                'dev' => 'vite serve --host='.$host,
                'production' => 'vite build',
                'prod' => 'yarn production',
                'routes' => 'php ./artisan ziggy:generate resources/js/routes.js',
                'horizon' => 'php ./artisan horizon',
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

        collect($this->installers)
            ->each(fn (string $installer) =>
            (new $installer($this->input, $this->output))
                ->handle($settings));

        return 0;
    }

    protected function getHost(): string
    {
        return $this->ask('What hostname are you using in development? (e.g.: valet.test): ');
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
