<?php

namespace App\Commands;

use App\Application;

use App\Database\SQLite;

use App\EventSender\EventSender;

use App\Models\Event;
use App\Telegram\TelegramApiImpl;

//use App\Models\EventDto;

class HandleEventsCommand extends Command

{

    protected Application $app;

    public function __construct(Application $app)

    {

        $this->app = $app;

    }

    public function run(array $options = []): void

    {

        $event = new Event(new SQLite($this->app));

        $events = $event->select();

        $eventSender = new EventSender(new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN')));    

        foreach ($events as $event) {

            if ($this->shouldEventBeRan($event)) {

                $eventSender->sendMessage($event['receiver_id'], $event['text']);

            }

        }

    }

    public function shouldEventBeRan(array $event): bool

    {
        $currentMinute = date("i");

        $currentHour = date("H");

        $currentDay = date("d");

        $currentMonth = date("m");

        $currentWeekday = date("w");

      //  echo $currentMonth . " " . $currentDay . " " . $currentWeekday ." ". $currentMinute ." ". $currentHour ."\n" ;
      //  echo $event['month'] . " " . $event['day'] . " " . $event['day_of_week']  ." ". $event['minute'] ." ". $event['hour'] ."" ;

        return ($event['minute'] == $currentMinute &&

            $event['hour'] == $currentHour &&

            $event['day'] == $currentDay &&

            $event['month'] == $currentMonth &&

            $event['day_of_week'] == $currentWeekday);
        // return true;
    }

}