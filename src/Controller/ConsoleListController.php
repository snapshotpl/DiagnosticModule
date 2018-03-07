<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\View\Model\ConsoleModel;
use ZendDiagnostics\Result\Collection;
use ZendDiagnostics\Runner\Runner;

final class ConsoleListController extends AbstractConsoleController
{
    private $runner;

    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    public function indexAction()
    {
        $results = $this->runner->run();

        return new ConsoleModel([
            'results' => $results,
        ], [
            'errorLevel' => $this->getErrorLevel($results),
        ]);
    }

    public function getErrorLevel(Collection $results) : int
    {
        if ($results->getFailureCount() > 0) {
            return 1;
        }
        return 0;
    }
}
