<?php

namespace Snapshotpl\DiagnosticModule\Reporter;

interface TimeProvider
{
    /**
     * @return float Current time in seconds
     */
    public function getNow();
}
