<?php

declare(strict_types=1);

namespace TPG\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \TPG\Vitamin\ServiceProvider::class,
        ];
    }
}
