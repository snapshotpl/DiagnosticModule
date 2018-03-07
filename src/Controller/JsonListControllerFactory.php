<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Interop\Container\ContainerInterface;
use Snapshotpl\DiagnosticModule\ResultName;
use ZendDiagnostics\Runner\Runner;

final class JsonListControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $runner = $container->get(Runner::class);
        $resultName = $container->get(ResultName::class);

        return new JsonListController($runner, $resultName);
    }
}
