<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Interop\Container\ContainerInterface;
use ZendDiagnostics\Runner\Runner;

final class HtmlListControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $runner = $container->get(Runner::class);

        return new HtmlListController($runner);
    }
}
