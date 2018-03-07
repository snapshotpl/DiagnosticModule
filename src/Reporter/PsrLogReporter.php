<?php

namespace Snapshotpl\DiagnosticModule;

use ArrayObject;
use Psr\Log\LoggerInterface;
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
        $this->checks[$check] = time();
    }

    public function onAfterRun(CheckInterface $check, ResultInterface $result, $checkAlias = null)
    {
        $this->checks[$check] = time() - $this->checks[$check];
    }

    public function onFinish(Collection $results)
    {
        $checks = [];
        foreach ($this->checks as $check => $time) {
            $checks[] = [
                'class' => get_class($check),
                'label' => $check->getLabel(),
                'time' => $time,
            ];
        }

        $this->logger->log($this->level, 'Diagnostic finished', [
            'success' => $results->getSuccessCount(),
            'skip' => $results->getSkipCount(),
            'warning' => $results->getWarningCount(),
            'failure' => $results->getFailureCount(),
        ]);
    }

    public function onStop(Collection $results)
    {
    }
}
