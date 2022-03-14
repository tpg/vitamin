<?php

declare(strict_types=1);

namespace TPG\Vitamin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use TPG\Vitamin\Contracts\VitaminInterface;

class ViteServeCommand extends Command
{
    protected $signature = 'vitamin:serve {--port=} {--host=} {--https}';

    protected $description = 'Start the Vite development server';

    public function handle(VitaminInterface $vitamin): int
    {
        $exec = 'npx vite serve';
        $params = [
            '--host' => $this->host(),
            '--port' => $this->option('port') ?? config('vitamin.port'),
            '--strictPort' => true,
            '--https' => $this->option('https') ?? false,
        ];

        $execParams = collect($params)->map(function ($value, $key) {
            if (is_bool($value) && $value) {
                return $key;
            }

            return $key.'='.$value;
        });

        $command = $exec.' '.$execParams->implode(' ');

        $process = Process::fromShellCommandline($command, timeout: 0);
        $process->setTty(Process::isTtySupported())->run(function ($state, $output) {
            $this->getOutput()->write($output);
        });

        return self::SUCCESS;
    }

    protected function host(): string
    {
        $url = config('app.url');
        return $this->option('host') ?? Str::after($url, '://');
    }
}
