<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramFoodShort extends Notification
{
    protected $r_id;
    protected $cat_id;
    protected $food_name;
    protected $food_main_name;
    protected $cat_name;
    protected $status;
    protected $priority;
    protected $special;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_food_data;

    public function __construct($old_food_data, $id, $cat_id, $food_name, $status, $priority, $special, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->cat_id = $cat_id;
        $this->food_name = $food_name;
        $this->food_main_name = $food_name['en'] ?? 'unknown';
        $this->status = $status;
        $this->priority = $priority;
        $this->special = $special;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_food_data = $old_food_data;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->special = $this->special == 0 ?  "Non-Special" : "Special";
        $this->old_food_data['status'] = $this->old_food_data['status'] == 0 ?  "DeActive" : "Active";
        $this->old_food_data['special'] = $this->old_food_data['special'] == 0 ?  "Non-Special" : "Special";
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

        $content = "*" . 'FOOD UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Food-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Food Name: '. $this->food_main_name . "*\n"
        . "*" .'-----------------'."*\n";  

        if ($this->status !== $this->old_food_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_food_data['status'] . ' ➝ ' . $this->status . "*\n";
        }
        
        if ($this->priority !== $this->old_food_data['priority']) {
            $content .= "*" . 'Priority Changed: '. $this->old_food_data['priority'] . ' ➝ ' . $this->priority . "*\n";
        }
        
        if ($this->special !== $this->old_food_data['special']) {
            $content .= "*" . 'Special Changed: '. $this->old_food_data['special'] . ' ➝ ' . $this->special . "*\n";
        }

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
