<?php

use TPG\Vitamin\Installers\ComposerDependencyInstaller;
use TPG\Vitamin\Installers\ConfigInstaller;
use TPG\Vitamin\Installers\InertiaInstaller;
use TPG\Vitamin\Installers\JavaScriptInstaller;
use TPG\Vitamin\Installers\NodeDependencyInstaller;
use TPG\Vitamin\Installers\NodeScriptInstaller;
use TPG\Vitamin\Installers\TailwindInstaller;
use TPG\Vitamin\Installers\VitaminConfigInstaller;

return [
    /*
     * The port number vite should run on.
     */
    'port' => 3000,

    /*
     * The view composer class to use
     */
    'composer' => \TPG\Vitamin\Composers\AppComposer::class,

    /*
     * Installers are run in the order they are specified.
     */
    'installers' => [
        VitaminConfigInstaller::class,
        ConfigInstaller::class,
        NodeScriptInstaller::class,
        NodeDependencyInstaller::class,
        JavaScriptInstaller::class,
        TailwindInstaller::class,
        ComposerDependencyInstaller::class,
        InertiaInstaller::class,
    ]
];
