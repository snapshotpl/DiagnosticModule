<?php

namespace Snapshotpl\DiagnosticModule\Reporter;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Snapshotpl\DiagnosticModule\Module;

final class PsrLogReporterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')[Module::class]['reporters'][PsrLogReporter::class];

        $logger = $container->get($config[LoggerInterface::class]);
        $level = $config['level'];

        return new PsrLogReporter($logger, $level);
    }
}
