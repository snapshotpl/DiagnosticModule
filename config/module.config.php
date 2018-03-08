<?php
return [
    \Snapshotpl\DiagnosticModule\Module::class => [
        'config' => [],
        'reporters' => [
            Snapshotpl\DiagnosticModule\PsrLogReporter::class => [
                Psr\Log\LoggerInterface::class => Psr\Log\LoggerInterface::class,
                'level' => Psr\Log\LogLevel::INFO,
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'empty_checks_list' => [],
        ],
        'factories' => [
            ZendDiagnostics\Runner\Runner::class => Snapshotpl\DiagnosticModule\RunnerFactory::class,
            Snapshotpl\DiagnosticModule\PsrLogReporter::class => \Snapshotpl\DiagnosticModule\PsrLogReporterFactory::class,
        ],
        'aliases' => [
            ZendDiagnostics\Check\CheckCollectionInterface::class => 'empty_checks_list',
            ZendDiagnostics\Runner\Reporter\ReporterInterface::class => Snapshotpl\DiagnosticModule\PsrLogReporter::class,
        ],
    ],
];
