<?php

namespace Snapshotpl\DiagnosticModule;

use ZendDiagnostics\Result\FailureInterface;
use ZendDiagnostics\Result\ResultInterface;
use ZendDiagnostics\Result\SkipInterface;
use ZendDiagnostics\Result\SuccessInterface;
use ZendDiagnostics\Result\WarningInterface;

final class ResultName
{
    const RESULT_SUCCESS = 'success';
    const RESULT_WARNING = 'warning';
    const RESULT_FAILURE = 'failure';
    const RESULT_SKIP = 'skip';
    const RESULT_UNKNOWN = 'unknown';

    private $map = [
        SuccessInterface::class => self::RESULT_SUCCESS,
        WarningInterface::class => self::RESULT_WARNING,
        FailureInterface::class => self::RESULT_FAILURE,
        SkipInterface::class => self::RESULT_SKIP,
    ];

    public function __construct(array $map = [])
    {
        if (!empty($map)) {
            $this->map = array_merge($this->map, $map);
        }
    }

    public function create(ResultInterface $result) : string
    {
        foreach ($this->map as $interface => $name) {
            if ($result instanceof $interface) {
                return $name;
            }
        }

        return self::RESULT_UNKNOWN;
    }
}
