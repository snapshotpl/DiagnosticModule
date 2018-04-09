<?php

namespace Snapshotpl\DiagnosticModule\Reporter;

use ArrayObject;
use Exception;
use Psr\Log\LoggerInterface;
use SplObjectStorage;
use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\Collection;
use ZendDiagnostics\Result\ResultInterface;
use ZendDiagnostics\Runner\Reporter\ReporterInterface;

final class PsrLogReporter implements ReporterInterface
{
    private $logger;
    private $checks;
    private $level;
    private $timeProvider;

    function __construct(LoggerInterface $logger, $level, TimeProvider $timeProvider)
    {
        $this->level = $level;
        $this->logger = $logger;
        $this->checks = new SplObjectStorage();
        $this->timeProvider = $timeProvider;
    }

    public function onStart(ArrayObject $checks, $runnerConfig)
    {
    }

    public function onBeforeRun(CheckInterface $check, $checkAlias = null)
    {
        $this->checks[$check] = [
            'time' => $this->timeProvider->getNow(),
            'check' => $check,
        ];
    }

    public function onAfterRun(CheckInterface $check, ResultInterface $result, $checkAlias = null)
    {
        if (isset($this->checks[$check])) {
            $data = $this->checks[$check];
            $data['time'] = round($this->timeProvider->getNow() - $this->checks[$check]['time'], 4);
            $data['result'] = $result;

            $this->checks[$check] = $data;
            return;
        }
        throw new Exception('Check not started');
    }

    public function onFinish(Collection $results)
    {
        $checks = [];
        foreach ($this->checks as $check) {
            $checkData = $this->checks[$check];
            $checks[$check->getLabel()] = [
                'class' => get_class($check),
                'result' => get_class($checkData['result']),
                'message' => $checkData['result']->getMessage(),
                'data' => $checkData['result']->getData(),
                'time' => $checkData['time'],
            ];
        }

        $this->logger->log($this->level, 'Diagnostic checked', [
            'success' => $results->getSuccessCount(),
            'skip' => $results->getSkipCount(),
            'warning' => $results->getWarningCount(),
            'failure' => $results->getFailureCount(),
            'details' => $checks,
        ]);
    }

    public function onStop(Collection $results)
    {
    }
}
