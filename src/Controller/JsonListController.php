<?php

namespace Snapshotpl\DiagnosticModule\Controller;

use Snapshotpl\DiagnosticModule\ResultName;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZendDiagnostics\Result\Collection;
use ZendDiagnostics\Runner\Runner;

final class JsonListController extends AbstractActionController
{
    private $runner;
    private $resultName;

    public function __construct(Runner $runner, ResultName $resultName)
    {
        $this->runner = $runner;
        $this->resultName = $resultName;
    }


    public function indexAction()
    {
        $results = $this->runner->run();

        $jsonModel = $this->toArray($results);

        return new JsonModel($jsonModel);
    }

    private function toArray(Collection $results)
    {
        foreach ($results as $item) {
            $result = $results[$item];
            $data[$item->getLabel()] = array(
                'result' => $this->resultName->create($result),
                'message' => $result->getMessage(),
                'data' => $result->getData(),
            );
        }
        return array(
            'details' => $data,
            'success' => $results->getSuccessCount(),
            'warning' => $results->getWarningCount(),
            'failure' => $results->getFailureCount(),
            'skip' => $results->getSkipCount(),
            'unknown' => $results->getUnknownCount(),
            'passed' => $results->getFailureCount() === 0,
        );
    }
}
