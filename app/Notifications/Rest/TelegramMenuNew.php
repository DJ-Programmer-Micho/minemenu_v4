<?php

namespace App\Notifications\Rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramMenuNew extends Notification
{
    protected $r_id;
    protected $menu_name;
    protected $telegram_channel_link;
    protected $view_business_name;

    public function __construct($id, $menu_name, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->menu_name = $menu_name;
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
        $registrationId = "#M-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'NEW MENU ADDED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Menu-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Menu Name: '. $this->menu_name . "*\n";

       return TelegramMessage::create()
        ->to($this->telegram_channel_link)
        ->content($content)
        ->button('View Menu', $menu_url);
    }

    public function toArray($notifiable)
    {

    }
}
