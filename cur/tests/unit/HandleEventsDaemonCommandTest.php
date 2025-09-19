<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers EventDaemonCommand
 */
class HandleEventsDaemonCommandTest extends TestCase
{
    /**
     * @dataProvider getCurrentTimeDataProvider
     */
    public function testGetCurrentTime($expectedArray)
    {
        $handleEventsDaemonCommand = new \App\Commands\HandleEventsDaemonCommand(new \App\Application(dirname(__DIR__)));
        $result = $handleEventsDaemonCommand->getCurrentTime();
        $this->assertEquals($result, $expectedArray);
    }

    public static function getCurrentTimeDataProvider(): array
    {
        return [
            [
                [
                date("i"),
                date("H"),
                date("d"),
                date("m"),
                date("w")
                ]
            ],
        ];
    }
}
