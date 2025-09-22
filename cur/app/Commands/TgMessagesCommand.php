<?php 

namespace App\Commands;

use App\Application;
use App\Cache\Redis;
use App\Telegram\TelegramApiImpl;   
use Predis\Client;



class TgMessagesCommand extends Command
{

    protected Application $app;
    private int $offset;
    private array|null $oldMessages;

    private Redis $redis;

    public function __construct(public Application $inApp)
    {
        $this->app = $inApp;
        $this->offset = 0;
        $this->oldMessages = [];

        $client = new Client([
            'schema' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
        ]);

        $this->redis = new Redis($client);
    }

    function run(array $options = []): void
    {
        $tgApi = new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN'));
      //  echo json_encode($tgApi->getMessage(0));
        echo json_encode($this->receiveNewMessages());
    }

    // public function handle(): void
    // {
    //     $messages = $this->receiveNewMessages();

    //     foreach ($messages as $userId => $userMessages)
    //     {
    //         $answerMessage = $this->handleMessagesAndReturnAnswer($userMessages);

    //         $this->eventSender->sendMessage($userId, $answerMessage);
    //     }
    // }

    private function receiveNewMessages(): array
    {
        $this->offset = $this->redis->get('tg_messages:offset', 0);

        $result = $this->getTelegramApi()->getMessage($this->offset);

        $this->redis->set('tg_messages:offset', $result['offset'] ?? 0);

        $this->oldMessages = json_decode($this->redis->get('tg_messages:old_messages'));

        $messages = [];

        foreach ($result['result'] ?? [] as $chatId => $newMessage)
        {
            if (isset($this->oldMessages[$chatId])){

                $this->oldMessages[$chatId] = [...$this->oldMessages[$chatId], ...$newMessage];

            } else {
                $this->oldMessages[$chatId] = $newMessage;
            }
        }

        $this->redis->set('tg_messages:old_messages', json_encode($this->oldMessages));

        return $messages;

    }

    protected function getTelegramApi()
    {
        return new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN'));
    }
    
}
