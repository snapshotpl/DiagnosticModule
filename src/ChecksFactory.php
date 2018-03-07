<?php

namespace Snapshotpl\DiagnosticModule;

use Interop\Container\ContainerInterface;
use InvalidArgumentException;
use UnexpectedValueException;
use ZendDiagnostics\Check\CheckInterface;

final class ChecksFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $checks = $container->get('config')['Snapshotpl']['DiagnosticModule']['checks'];

        foreach ($checks as $alias => $serviceName) {
            if (!$container->has($serviceName)) {
                throw new InvalidArgumentException(sprintf('Check with %s name does not exist', $serviceName));
            }
            $check = $container->get($serviceName);

            if (!$check instanceof CheckInterface) {
                throw new UnexpectedValueException(sprintf('Check with %s name is not %s', $serviceName, CheckInterface::class));
            }
            $checks[$alias] = $check;
        }

        return $checks;
    }
}
