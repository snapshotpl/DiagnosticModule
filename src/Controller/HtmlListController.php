<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZendDiagnostics\Runner\Runner;

final class HtmlListController extends AbstractActionController
{
    private $runner;

    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }


    public function indexAction()
    {
        $results = $this->runner->run();

        return new ViewModel([
            'results' => $results,
        ]);
    }
}
