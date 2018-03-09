<?php

namespace Snapshotpl\DiagnosticModule\Reporter;

interface TimeProvider
{
    /**
     * @return float Current time in miliseconds
     */
    public function getNow();
}
