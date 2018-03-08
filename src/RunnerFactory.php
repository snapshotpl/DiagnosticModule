<?php

namespace Snapshotpl\DiagnosticModule;

use Interop\Container\ContainerInterface;
use ZendDiagnostics\Check\CheckCollectionInterface;
use ZendDiagnostics\Runner\Reporter\ReporterInterface;
use ZendDiagnostics\Runner\Runner;

final class RunnerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')[Module::class];

        $checks = $container->has(CheckCollectionInterface::class) ? $container->get(CheckCollectionInterface::class) : null;
        $reporter = $container->has(ReporterInterface::class) ? $container->get(ReporterInterface::class) : null;

        return new Runner($config['config'], $checks, $reporter);
    }
}
