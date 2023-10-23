<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramFoodNew extends Notification
{
    protected $r_id;
    protected $food_name;
    protected $cat_id;
    protected $price;
    protected $old_price;
    protected $special;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;

    public function __construct($id, $food_name, $cat_id, $price, $old_price, $special, $img, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->food_name = $food_name;
        $this->cat_id = $cat_id;
        $this->price = $price ?? null;
        $this->old_price = $old_price ?? null;
        $this->special = $special;
        $this->img = $img;
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

        $content = "*" . 'NEW FOOD ADDED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Food-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Food Name: '. $this->food_name . "*\n";
        
        if ($this->price) {
            $content .= "*" .'Price: '. $this->price . "*\n";
            if ($this->old_price) {
                $content .= "*" .'Old Price: '. $this->old_price . "*\n";
            }
        } else {
            $content .= "*" .'Price: Options Type' . "*\n";
        }

        $content .= "*" .'Special: '. $this->special . "*\n" 
        . "*" .  $this->img . "*\n" ;

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
