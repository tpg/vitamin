<?php

declare(strict_types=1);

namespace TPG\Tests;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use TPG\Vitamin\Contracts\VitaminInterface;
use TPG\Vitamin\Installers\AbstractInstaller;

class InstallerTest extends TestCase
{
    /**
     * @test
     **/
    public function it_will_copy_the_specified_files(): void
    {
        $installer = $this->installer();

        touch(__DIR__.'/source1');
        touch(__DIR__.'/source2');

        $installer->run();

        self::assertFileExists(__DIR__.'/target1');
        self::assertFileExists(__DIR__.'/target2');

        foreach(['source1', 'source2', 'target1', 'target2'] as $file) {
            unlink(__DIR__.'/'.$file);
        }
    }

    protected function installer(): AbstractInstaller
    {
        return new class (new ArrayInput([]), new NullOutput()) extends AbstractInstaller
        {
            protected function filesToCopy(): array
            {
                return [
                    __DIR__.'/source1' => __DIR__.'/target1',
                    __DIR__.'/source2' => __DIR__.'/target2',
                ];
            }

            public function filesToRemove(): array
            {
                return [
                    __DIR__.'remove',
                ];
            }

            public function handle(): void
            {
                $this->start('Start');
            }
        };
    }
}
