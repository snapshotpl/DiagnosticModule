<?php

namespace Snapshotpl\DiagnosticModule;

final class ResultNameFactory
{
    public function __invoke(\Interop\Container\ContainerInterface $container)
    {
        $map = $container->get('config')['Snapshotpl']['DiagnosticModule']['result_name_map'];

        return new ResultName($map);
    }
}
