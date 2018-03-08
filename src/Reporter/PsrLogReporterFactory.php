<?php

namespace Snapshotpl\DiagnosticModule;

use Psr\Container\ContainerInterface;

final class PsrLogReporterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')[Module::class]['reporters'][PsrLogReporter::class];
        $logger = $container->get($config[\Psr\Log\LoggerInterface::class]);
        $level = $config['level'];

        return new PsrLogReporter($logger, $level);
    }
}
