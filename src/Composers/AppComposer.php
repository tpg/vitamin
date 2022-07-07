<?php

declare(strict_types=1);

namespace TPG\Vitamin\Composers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use TPG\Vitamin\Vitamin;

class AppComposer
{
    protected string $jsPath = 'resources/js';

    public function compose(View $view): void
    {
            $view->with('vitamin', (new Vitamin())->getViteAssets($this->jsPath()));
    }

    protected function jsPath(): string
    {
        $file = config('vitamin.ts') ? 'app.ts' : 'app.js';

        return $this->jsPath.'/'.$file;
    }
}
