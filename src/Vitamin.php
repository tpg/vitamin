<?php

declare(strict_types=1);

namespace TPG\Vitamin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TPG\Vitamin\Contracts\VitaminInterface;

class Vitamin implements VitaminInterface
{
    protected string $jsPath = 'resources/js/app.js';

    protected Collection $installers;

    public function __construct()
    {
        $this->installers = collect();
    }

    public function initializeInstallers(InputInterface $input, OutputInterface $output): void
    {
        $this->installers = collect(config('vitamin.installers'))
            ->map(fn(string $installerClass) => new $installerClass($input, $output));
    }

    public function setInstallers(Collection $installers): void
    {
        $this->installers = $installers;
    }

    public function getInstallers(): Collection
    {
        return $this->installers;
    }

    public function getViteAssets(string $jsPath = null): HtmlString
    {
        $js = $jsPath ?: $this->jsPath;

        $host = config('app.url');
        $tls = Str::lower(Str::before($host, '://')) === 'https';

        $port = config('vitamin.port', 3000);

        if ($this->devServerRunning(Str::after($host, '://'), $port, $tls)) {
            return new HtmlString(<<<HTML
                <script type="module" src="$host:$port/@vite/client"></script>
                <script type="module" src="$host:$port/$js"></script>
            HTML);
        }

        $manifest = $this->getManifest();

        return new HtmlString(<<<HTML
            <script type="module" src="/build/{$manifest[$js]['file']}"></script>
            <link rel="stylesheet" href="/build/{$manifest[$js]['css'][0]}" />
        HTML);
    }

    protected function devServerRunning(string $host, int $port, bool $tls = false): bool
    {
        if (app()->environment('local')) {
            try {
                $schema = $tls ? 'https' : 'http';
                Http::withoutVerifying()->head("$schema://$host:$port/@vite/client");
                return true;
            } catch (\Exception) {}
        }

        return false;
    }

    protected function getManifest(): array
    {
        return json_decode(file_get_contents(
            public_path('build/manifest.json')
        ), true, 512, JSON_THROW_ON_ERROR);
    }
}
