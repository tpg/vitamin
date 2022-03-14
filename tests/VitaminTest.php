<?php

declare(strict_types=1);

namespace TPG\Tests;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use TPG\Vitamin\Vitamin;

class VitaminTest extends TestCase
{
    /**
     * @test
     **/
    public function it_will_return_dev_vite_assets(): void
    {
        $mock = \Mockery::mock(Vitamin::class);
        $mock->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('devServerRunning')
            ->once()
            ->andReturnTrue();

        $assets = $mock->getViteAssets('resources/js/app.js');

        $this->assertStringContainsString('<script type="module" src="http://localhost:3000/@vite/client"></script>', (string)$assets);
        $this->assertStringContainsString('<script type="module" src="http://localhost:3000/resources/js/app.js"></script>', (string)$assets);
    }

    /**
     * @test
     **/
    public function it_will_return_production_vite_assets(): void
    {
        $mock = \Mockery::mock(Vitamin::class);
        $mock->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('devServerRunning')
            ->once()
            ->andReturnFalse();

        $mock->shouldReceive('getManifest')
            ->once()
            ->andReturn([
                'resources/js/app.js' => [
                    'file' => 'app.js',
                    'css' => ['app.css'],
                ],
            ]);

        $assets = $mock->getViteAssets('resources/js/app.js');

        $this->assertStringContainsString('<script type="module" src="/build/app.js"></script>', (string)$assets);
        $this->assertStringContainsString('<link rel="stylesheet" href="/build/app.css" />', (string)$assets);
    }

    /**
     * @test
     **/
    public function it_can_initialize_default_installers(): void
    {
        $vitamin = new Vitamin();

        $this->assertCount(0, $vitamin->getInstallers());
        $vitamin->initializeInstallers(new ArrayInput([]), new ConsoleOutput(), 'yarn');

        $this->assertCount(count(config('vitamin.installers')), $vitamin->getInstallers());
    }
}
