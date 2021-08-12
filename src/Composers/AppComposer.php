<?php

namespace TPG\Vitamin\Composers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;

class AppComposer
{
    public function compose(View $view): void
    {
            $view->with('vitamin', $this->getViteAssets());
    }

    protected function getViteAssets(): HtmlString
    {
        $host = config('app.url');

        if ($this->devServerRunning()) {
            return new HtmlString(<<<HTML
                <script type="module" src="$host:3000/@vite/client"></script>
                <script type="module" src="$host:3000/resources/js/app.js"></script>
            HTML);
        }

        $manifest = json_decode(file_get_contents(
            public_path('build/manifest.json')
        ), true, 512, JSON_THROW_ON_ERROR);

        return new HtmlString(<<<HTML
            <script type="module" src="/build/{$manifest['resources/js/app.js']['file']}"></script>
            <script type="module" src="/build/{$manifest['resources/js/app.js']['css'][0]}"></script>
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
