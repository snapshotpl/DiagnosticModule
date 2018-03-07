<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Interop\Container\ContainerInterface;
use ZendDiagnostics\Runner\Runner;

final class ConsoleListControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $runner = $container->get(Runner::class);

        return new ConsoleListController($runner);
    }
}
