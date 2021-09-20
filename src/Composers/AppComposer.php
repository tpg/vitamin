<?php

declare(strict_types=1);

namespace TPG\Vitamin\Composers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use TPG\Vitamin\Vitamin;

class AppComposer
{
    protected string $jsPath = 'resources/js/app.js';

    public function compose(View $view): void
    {
            $view->with('vitamin', (new Vitamin())->getViteAssets($this->jsPath));
    }
}
