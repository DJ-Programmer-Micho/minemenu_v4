<?php

namespace App\Notifications\Rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramCategoryDelete extends Notification
{
    protected $r_id;
    protected $name;
    protected $telegram_channel_link;
    protected $view_business_name;

    public function __construct($id, $name, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->name = $name;
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
        $category_url = env('APP_URL').$this->view_business_name.'/cat/'.$this->r_id;
        $registrationId = "#C-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'CATEGORY DELETED' . "*\n"
        . "*" .'-----------------'."*\n"  
        . "*" .'Cat-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Category Name: '. $this->name . "*\n";

       return TelegramMessage::create()
       ->to($this->telegram_channel_link)
       ->content($content)
       ->button('View Menu', $menu_url)
       ->button('View Category', $category_url);
    }

    public function toArray($notifiable)
    {

    }
}
