<?php

return [
    Snapshotpl\DiagnosticModule\Module::class => [
        'config' => [],
        'reporters' => [
            Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter::class => [
                Psr\Log\LoggerInterface::class => Psr\Log\LoggerInterface::class,
                'level' => Psr\Log\LogLevel::INFO,
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            ZendDiagnostics\Runner\Runner::class => Snapshotpl\DiagnosticModule\RunnerFactory::class,
            Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter::class => Snapshotpl\DiagnosticModule\Reporter\PsrLogReporterFactory::class,
            Snapshotpl\DiagnosticModule\Reporter\MicrotimeProvider::class => Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            ZendDiagnostics\Runner\Reporter\ReporterInterface::class => Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter::class,
            Snapshotpl\DiagnosticModule\Reporter\TimeProvider::class => Snapshotpl\DiagnosticModule\Reporter\MicrotimeProvider::class,
        ],
    ],
];
