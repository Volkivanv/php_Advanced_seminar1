<?php

use App\Application;
use App\Commands\TgMessagesCommand;
use PHPUnit\Framework\TestCase;
use App\Telegram\TelegramApiImpl;

/**
 * @covers TgMessagesCommand
 */

final class TgMessagesCommandTest extends TestCase
{
    private TelegramApiImpl $telegramApiImpl;
    protected function setUp(): void    
    {
        $this->telegramApiImpl = $this->createMock(TelegramApiImpl::class);
    }
    /**
     * @dataProvider getMessageDataProvider
     */
    public function testRunCorrect(array $options = [], array $expectedArray)
    {

       // $command = new TgMessagesCommand(new Application());

       // die(var_dump($command->run($options)));
       // $command->run($options);

        $mock = $this->getMockBuilder(TelegramApiImpl::class)
            ->setMethods(['getMessage'])
            ->disableOriginalConstructor()
            ->getMock();
        

        $this->assertEquals($expectedArray, $mock->getMessage(0));

   
    }

    public static function getMessageDataProvider(): array
    {


            return [
            [
                [],
                []
            ],

        ];
    
    }
}
