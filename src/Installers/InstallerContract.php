<?php

declare(strict_types=1);

namespace TPG\Vitamin\Installers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface InstallerContract
{
    public function __construct(InputInterface $input, OutputInterface $output, string $nodeManager = 'yarn');

    public function handle(): void;
}
