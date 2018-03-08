<?php

namespace Snapshotpl\DiagnosticModule;

final class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
