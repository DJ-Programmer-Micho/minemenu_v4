<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramOfferDelete extends Notification
{
    protected $r_id;
    protected $food_main_name;
    protected $view_business_name;
    protected $telegram_channel_link;

    public function __construct($id, $food_name, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->food_main_name = $food_name;
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
        $registrationId = "#F-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'OFFER DELETED' . "*\n"
        . "*" .'-----------------'."*\n"  
        . "*" .'Offer-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Offer Name: '. $this->food_main_name . "*\n";

       return TelegramMessage::create()
       ->to($this->telegram_channel_link)
       ->content($content)
       ->button('View Menu', $menu_url);
    }

    public function toArray($notifiable)
    {

    }
}
