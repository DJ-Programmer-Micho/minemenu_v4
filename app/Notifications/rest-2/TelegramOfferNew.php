<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramOfferNew extends Notification
{
    protected $r_id;
    protected $offer_name;
    protected $price;
    protected $old_price;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;

    public function __construct($id, $offer_name, $price, $old_price, $img, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->offer_name = $offer_name;
        $this->price = $price ?? "none";
        $this->old_price = $old_price ?? "none";
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
        $offer_url = env('APP_URL').$this->view_business_name.'/offer/' . $this->r_id;
        $registrationId = "#O-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'NEW FOOD ADDED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Offer-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Offer Name: '. $this->offer_name . "*\n"
        . "*" .'-----------------'."*\n" ;
        
        if ($this->price) {
            $content .= "*" .'Price: '. $this->price . "*\n";
            if ($this->old_price) {
                $content .= "*" .'Old Price: '. $this->old_price . "*\n";
            }
        } else {
            $content .= "*" .'Price: Options Type' . "*\n";
        }

        $content .= "*" .  $this->img . "*\n" ;

       return TelegramMessage::create()
       ->to($this->telegram_channel_link)
       ->content($content)
       ->button('View Menu', $menu_url)
       ->button('View Offer', $offer_url);
    }

    public function toArray($notifiable)
    {

    }
}
