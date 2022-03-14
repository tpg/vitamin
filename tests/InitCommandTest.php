<?php

declare(strict_types=1);

namespace TPG\Tests;

use TPG\Vitamin\Console\InitCommand;
use TPG\Vitamin\Contracts\VitaminInterface;
use TPG\Vitamin\Installers\AbstractInstaller;
use TPG\Vitamin\Installers\VitaminConfigInstaller;

class InitCommandTest extends TestCase
{
    /**
     * @test
     **/
    public function it_will_not_make_changes_if_cancelled(): void
    {
        $this->artisan(InitCommand::class)
            ->expectsConfirmation('Are you sure you want to continue?', 'no')
            ->assertExitCode(1);
    }

    /**
     * @test
     **/
    public function it_will_ask_a_series_of_questions_before_running(): void
    {
        /** @var VitaminInterface $vitamin */
        $vitamin = app(VitaminInterface::class);

        $mock = \Mockery::mock(AbstractInstaller::class);

        $mock->shouldReceive('run')->times(3);

        $vitamin->setInstallers(collect([
            $mock,
            $mock,
            $mock,
        ]));

        $this->artisan(InitCommand::class)
            ->expectsConfirmation('Are you sure you want to continue?', 'yes')
            ->expectsQuestion('What hostname are you using in development? (e.g.: valet.test):', 'vitamin.test')
            ->expectsQuestion('Where are your JS sources stored? (relative to resources directory)', 'js')
            ->expectsQuestion('Where are your Inertia Vue pages stored? (relative to resources directory)', 'js/Pages')
            ->expectsChoice('Which Node dependency manager do you use?', 'yarn', ['yarn', 'npm'])
            ->assertExitCode(0);
    }
}
