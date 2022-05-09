<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

abstract class AbstractInstaller implements InstallerContract
{
    protected array $variables = [];
    protected int $verbosity;

    public function __construct(
        protected InputInterface $input,
        protected OutputInterface $output,
        protected string $dependencyManager = 'yarn'
    )
    {
    }

    protected function filesToCopy(): array
    {
        return [];
    }

    protected function filesToRemove(): array
    {
        return [];
    }

    protected function copyFiles(): void
    {
        collect($this->filesToCopy())->each(function ($destination, $source) {

            $this->prepDestination($destination);

            $data = file_get_contents($source);

            foreach ($this->variables as $var => $value) {
                $data = str_replace($var, (string)$value, $data);
            }

            file_put_contents($destination, $data);
            $this->output->write('.');

        });
    }

    protected function stubPath(string $filename): string
    {
        return __DIR__.'/../../stubs/'.$filename;
    }

    protected function removeFiles(): void
    {
        collect($this->filesToRemove())->each(function ($file) {

            if (file_exists($file)) {
                unlink($file);
                $this->output->write('.');
            }

        });
    }

    protected function runArtisanCommand(string $command): void
    {
        $this->runShellCommand('php ./artisan '.$command);
    }

    protected function runShellCommand(string $command): void
    {
        $process = Process::fromShellCommandline($command, timeout: null);
        $process->mustRun(function ($type, $buffer) {

            $this->output->write('.');

            if ($this->verbosity > OutputInterface::VERBOSITY_VERBOSE) {
                $this->output->writeln('');
                $this->output->writeln('<info>'.$buffer.'</info>');
            }
        });
    }

    protected function insert(string $filename, array $lines, string $afterContains): void
    {
        $data = collect(File::lines($filename)->toArray());
        $index = $data->filter(fn ($line) => strstr($line, $afterContains))->keys()->first();

        $after = $data->splice($index + 1);

        $data = $data->concat([
            $lines,
            $after->toArray()
        ]);

        file_put_contents($filename, implode("\n", $data->flatten()->toArray()));
        $this->output->write('.');
    }

    protected function prepDestination(string $destination): void
    {
        $path = pathinfo($destination, PATHINFO_DIRNAME);

        if (! is_dir($path)) {
            $this->makeDirectory($path);
        }
    }

    protected function makeDirectory(string $path): void
    {
        if (! mkdir($path, recursive: true) && ! is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    protected function start(string $message): void
    {
        $this->output->write($message);
        $this->copyFiles();
        $this->removeFiles();
    }

    protected function done(): void
    {
        $this->output->writeln('[<info>✔</info>]');
    }

    public function run(array $variables = [], int $verbosity = OutputInterface::VERBOSITY_NORMAL): void
    {
        $this->variables = $variables;
        $this->verbosity = $verbosity;
        $this->handle();
    }

    protected function nodeManager(string $command = null): string
    {
        $commands = [
            'add' => [
                'yarn' => 'add -D',
                'npm' => 'install --save-dev',
            ],
            'run' => [
                'yarn' => '',
                'npm' => 'run',
            ]
        ];

        return $this->dependencyManager.' '.$commands[$command][$this->dependencyManager];
    }

    abstract public function handle(): void;
}
