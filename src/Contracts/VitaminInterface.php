<?php

declare(strict_types=1);

namespace TPG\Vitamin\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface VitaminInterface
{
    public function getViteAssets(string $jsPath = null): HtmlString;
    public function initializeInstallers(InputInterface $input, OutputInterface $output, string $nodeManager): void;
    public function setInstallers(Collection $installers): void;
    public function getInstallers(): Collection;
}
