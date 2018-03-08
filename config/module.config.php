<?php

return [
    Snapshotpl\DiagnosticModule\Module::class => [
        'config' => [],
        'reporters' => [
            Snapshotpl\DiagnosticModule\PsrLogReporter::class => [
                Psr\Log\LoggerInterface::class => Psr\Log\LoggerInterface::class,
                'level' => Psr\Log\LogLevel::INFO,
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            ZendDiagnostics\Runner\Runner::class => Snapshotpl\DiagnosticModule\RunnerFactory::class,
            Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter::class => Snapshotpl\DiagnosticModule\Reporter\PsrLogReporterFactory::class,
        ],
        'aliases' => [
            ZendDiagnostics\Runner\Reporter\ReporterInterface::class => Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter::class,
        ],
    ],
];
