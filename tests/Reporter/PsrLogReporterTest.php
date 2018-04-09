<?php

namespace Snapshotpl\DiagnosticModule\Tests\Reporter;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Snapshotpl\DiagnosticModule\Reporter\PsrLogReporter;
use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\Collection;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

class PsrLogReporterTest extends TestCase
{
    public function testLogResultAfterRun()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('log')->willReturnCallback(function($level, $message, $context) {
            $this->assertSame(LogLevel::INFO, $level);
            $this->assertSame([
                'success' => 1,
                'skip' => 0,
                'warning' => 0,
                'failure' => 1,
                'details' => [
                    'Check label' => [
                        'class' => 'Mock_Implementation',
                        'result' => 'ZendDiagnostics\Result\Success',
                        'message' => 'Result message',
                        'data' => 'Result data',
                        'time' => 1.5,
                    ],
                    'Check label failed' => [
                        'class' => 'Mock_Implementation2',
                        'result' => 'ZendDiagnostics\Result\Failure',
                        'message' => 'Result message failed',
                        'data' => 'Result data failed',
                        'time' => 0.5,
                    ],
                ],
            ], $context);
        });

        $timeProvider = new MockTimeProvider(['before run time' => 5, 'after run time' => 6.5, 'before run time failed' => 6, 'after run time failed' => 6.5,]);

        $reporter = new PsrLogReporter($logger, LogLevel::INFO, $timeProvider);

        $successResult = new Success('Result message', 'Result data');

        $check = $this->getMockBuilder(CheckInterface::class)->setMockClassName('Mock_Implementation')->getMock();
        $check->method('getLabel')->willReturn('Check label');

        $reporter->onBeforeRun($check);
        $reporter->onAfterRun($check, $successResult);

        $failureResult = new Failure('Result message failed', 'Result data failed');

        $checkFailed = $this->getMockBuilder(CheckInterface::class)->setMockClassName('Mock_Implementation2')->getMock();
        $checkFailed->method('getLabel')->willReturn('Check label failed');

        $reporter->onBeforeRun($checkFailed);
        $reporter->onAfterRun($checkFailed, $failureResult);

        $collection = new Collection();
        $collection[$check] = $successResult;
        $collection[$checkFailed] = $failureResult;

        $reporter->onFinish($collection);
    }

    public function testLogSmallTimeAfterRun()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('log')->willReturnCallback(function($level, $message, $context) {
            $this->assertSame(LogLevel::INFO, $level);
            $this->assertSame([
                'success' => 1,
                'skip' => 0,
                'warning' => 0,
                'failure' => 0,
                'details' => [
                    'Check label' => [
                        'class' => 'Mock_Implementation',
                        'result' => 'ZendDiagnostics\Result\Success',
                        'message' => 'Result message',
                        'data' => 'Result data',
                        'time' => 0.0,
                    ],
                ],
            ], $context);
        });

        $timeProvider = new MockTimeProvider(['before run time' => 0, 'after run time' => 2.0027160644531e-5]);

        $reporter = new PsrLogReporter($logger, LogLevel::INFO, $timeProvider);

        $successResult = new Success('Result message', 'Result data');

        $check = $this->getMockBuilder(CheckInterface::class)->setMockClassName('Mock_Implementation')->getMock();
        $check->method('getLabel')->willReturn('Check label');

        $reporter->onBeforeRun($check);
        $reporter->onAfterRun($check, $successResult);

        $collection = new Collection();
        $collection[$check] = $successResult;

        $reporter->onFinish($collection);
    }
}
