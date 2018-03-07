<?php
return [
    'Snapshotpl' => [
        'DiagnosticModule' => [
            'config' => [],
            'result_name_map' => [],
            'checks' => [],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Snapshotpl_DiagnosticModule_Checks_From_Config' => Snapshotpl\DiagnosticModule\ChecksFactory::class,
            ZendDiagnostics\Runner\Runner::class => Snapshotpl\DiagnosticModule\RunnerFactory::class,
        ],
        'aliases' => [
            ZendDiagnostics\Check\CheckCollectionInterface::class => 'Snapshotpl_DiagnosticModule_Checks_From_Config',
        ],
    ],
    'controllers' => [
        'factories' => [
            Snapshotpl\DiagnosticModule\Controller\ConsoleListController::class => Snapshotpl\DiagnosticModule\Controller\ConsoleListControllerFactory::class,
            Snapshotpl\DiagnosticModule\Controller\HtmlListController::class => Snapshotpl\DiagnosticModule\Controller\HtmlListControllerFactory::class,
            Snapshotpl\DiagnosticModule\Controller\JsonListController::class => Snapshotpl\DiagnosticModule\Controller\JsonListControllerFactory::class,
        ],
    ],
    'view_manager' => array(
        'template_map' => array(
            'zf-tool/diagnostics/run' => __DIR__ . '/../view/diagnostics/run.phtml',
        )
    ),
    'router' => [
        'routes' => [
            'snapshotpl-diagnosticmodule-html' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/diagnostics.html',
                    'defaults' => ['controller' => Snapshotpl\DiagnosticModule\Controller\HtmlListController::class,
                        'action' => 'run'
                    ]
                ]
            ],
            'snapshotpl-diagnosticmodule-json' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/diagnostics.json',
                    'defaults' => [
                        'controller' => Snapshotpl\DiagnosticModule\Controller\HtmlListController::class,
                        'action' => 'run',
                    ],
                ],
            ],
        ],
    ],
];
