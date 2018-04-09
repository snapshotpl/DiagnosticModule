<?php

namespace Snapshotpl\DiagnosticModule\Reporter;

final class MicrotimeProvider implements TimeProvider
{
    public function getNow()
    {
        return microtime(true);
    }
}
