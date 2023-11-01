<?php

namespace App\Notifications\Rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramFoodDelete extends Notification
{
    protected $r_id;
    protected $food_main_name;
    protected $cat_id;
    protected $view_business_name;
    protected $telegram_channel_link;

    public function __construct($id, $cat_id, $food_name, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->food_main_name = $food_name;
        $this->cat_id = $cat_id;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $menu_url = env('APP_URL').$this->view_business_name;
        $food_url = env('APP_URL').$this->view_business_name.'/cat/'.$this->cat_id.'/'.$this->r_id;
        $registrationId = "#F-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'FOOD DELETED' . "*\n"
        . "*" .'-----------------'."*\n"  
        . "*" .'Food-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Food Name: '. $this->food_main_name . "*\n";

       return TelegramMessage::create()
       ->to($this->telegram_channel_link)
       ->content($content)
       ->button('View Menu', $menu_url)
       ->button('View Food', $food_url);
    }

    public function toArray($notifiable)
    {

    }
}
