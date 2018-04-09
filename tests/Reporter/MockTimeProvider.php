<?php

namespace Snapshotpl\DiagnosticModule\Tests\Reporter;

use BadMethodCallException;
use Snapshotpl\DiagnosticModule\Reporter\TimeProvider;

final class MockTimeProvider implements TimeProvider
{
    private $i = 0;

    private $times;

    public function __construct(array $times)
    {
        $this->times = array_values($times);
    }


    public function getNow()
    {
        if (isset($this->times[$this->i])) {
            $time = $this->times[$this->i];
            $this->i++;
            return $time;
        }
        throw new BadMethodCallException("Time for $this->i call not defined");
    }
}
