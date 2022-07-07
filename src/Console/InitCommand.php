<?php

declare(strict_types=1);

namespace TPG\Vitamin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use TPG\Vitamin\Contracts\VitaminInterface;
use TPG\Vitamin\Installers\AbstractInstaller;

class InitCommand extends Command
{
    protected $signature = 'vitamin:init {--ts} {--host=} {--manager=} {--y|force}';

    protected $description = 'Initialize a new Vitamin project';

    public function handle(VitaminInterface $vitamin): int
    {
        $vitamin->ts($this->option('ts'));

        if ($this->confirmed()) {
            return $this->install($vitamin);
        }

        $this->info('No changes have been made.');
        return 1;
    }

    protected function confirmed(): bool
    {
        if ($this->option('force')) {
            return true;
        }

        $this->info('Running this command will overwrite some vital files that may cause an existing Laravel project to fail.');
        return $this->confirm('Are you sure you want to continue?', false);
    }

    protected function install(VitaminInterface $vitamin): int
    {
        $host = $this->getHost();
        $port = config('vitamin.port');
        $js = $this->getJsPath();
        $pages = $this->getPagesPath($js);
        $manager = $this->getNodeDependencyManager();

        $variables = [
            '$HOST$' => $host,
            '$PORT$' => $port,
            '$JSPATH$' => $js,
            '$PAGESPATH$' => $pages,
        ];

        if ($vitamin->getInstallers()->count() === 0) {
            $vitamin->initializeInstallers($this->input, $this->output, $manager);
        }

        collect($vitamin->getInstallers())
            ->each(fn (AbstractInstaller $installer) => $installer->run($variables, $this->verbosity, ['ts' => $vitamin->ts]));

        return 0;
    }

    protected function getHost(): string
    {
        return $this->option('host') ?? $this->ask('What hostname are you using in development? (e.g.: valet.test):');
    }

    protected function getJsPath(): string
    {
        return 'js';
//        return $this->stripSlashes(
//            $this->ask('Where are your JS sources stored? (relative to resources directory)', 'js')
//        );
    }

    protected function getPagesPath(string $jsPath): string
    {
        return  $this->getJsPath().'/Pages';
//        return $this->stripSlashes(
//            $this->ask('Where are your Inertia Vue pages stored? (relative to resources directory)', $jsPath.'/Pages')
//        );
    }

    protected function getNodeDependencyManager(): string
    {
        $manager = $this->option('manager');

        return match($manager) {
            'yarn' => 'yarn',
            'npm' => 'npm',
            default => $this->choice('Which Node dependency manager do you use?', ['npm', 'yarn'], 'yarn'),
        };
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
