<?php

declare(strict_types=1);

namespace TPG\Vitamin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

class Vitamin
{
    protected string $jsPath = 'resources/js/app.js';

    public function getViteAssets(string $jsPath = null): HtmlString
    {
        $js = $jsPath ?: $this->jsPath;

        $host = config('app.url');

        if ($this->devServerRunning()) {
            return new HtmlString(<<<HTML
                <script type="module" src="$host:3000/@vite/client"></script>
                <script type="module" src="$host:3000/$js"></script>
            HTML);
        }

        $manifest = json_decode(file_get_contents(
            public_path('build/manifest.json')
        ), true, 512, JSON_THROW_ON_ERROR);

        return new HtmlString(<<<HTML
            <script type="module" src="/build/{$manifest[$js]['file']}"></script>
            <link rel="stylesheet" href="/build/{$manifest[$js]['css'][0]}" />
        HTML);
    }

    protected function devServerRunning(): bool
    {
        if (app()->environment('local')) {
            try {
                Http::get('http://localhost:3000');
                return true;
            } catch (\Exception) {}
        }

        return false;
    }
}
