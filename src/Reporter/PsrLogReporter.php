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

    function __construct(LoggerInterface $logger, $level)
    {
        $this->level = $level;
        $this->logger = $logger;
        $this->checks = new SplObjectStorage();
    }

    public function onStart(ArrayObject $checks, $runnerConfig)
    {
    }

    public function onBeforeRun(CheckInterface $check, $checkAlias = null)
    {
        $this->checks[$check] = [
            'time' => time(),
            'check' => $check,
        ];
    }

    public function onAfterRun(CheckInterface $check, ResultInterface $result, $checkAlias = null)
    {
        if (isset($this->checks[$check])) {
            $this->checks[$check]['time'] = time() - $this->checks[$check]['time'];
            $this->checks[$check]['result'] = $result;
            return;
        }
        throw new Exception('Check not started');
    }

    public function onFinish(Collection $results)
    {
        $checks = [];
        foreach ($this->checks as $check => $data) {
            /* @var $check CheckInterface */
            $checks[] = [
                'class' => get_class($check),
                'label' => $check->getLabel(),
                'result' => [
                    'message' => $data['result']->getMessage(),
                    'data' => $data['result']->getData(),
                    'time' => $data['time'],
                ],
            ];
        }

        $this->logger->log($this->level, 'Diagnostic finished', [
            'success' => $results->getSuccessCount(),
            'skip' => $results->getSkipCount(),
            'warning' => $results->getWarningCount(),
            'failure' => $results->getFailureCount(),
            'checks_durations' => $checks,
        ]);
    }

    public function onStop(Collection $results)
    {
    }
}
