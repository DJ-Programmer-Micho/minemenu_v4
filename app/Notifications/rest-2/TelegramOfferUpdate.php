<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramOfferUpdate extends Notification
{
    protected $r_id;
    protected $offer_name;
    protected $names;
    protected $price;
    protected $old_price;
    protected $status;
    protected $priority;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_offer_data;

    public function __construct($old_offer_data, $id, $offer_name, $price, $old_price, $status, $priority, $img, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->offer_name = $offer_name['en'] ?? 'unknown';
        $this->names = $offer_name; 
        $this->price = $price ?? "none";
        $this->old_price = $old_price ?? "none";
        $this->status = $status;
        $this->priority = $priority;
        $this->img = $img;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_offer_data = $old_offer_data;

        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_offer_data['status'] = $this->old_offer_data['status'] == 0 ?  "DeActive" : "Active";
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

        $content = "*" . 'OFFER UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Offer-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Offer Name: '. $this->offer_name . "*\n"
        . "*" .'-----------------'."*\n" ;
        
        foreach ($this->old_offer_data['locales'] as $local){
            if($this->names[$local] !== $this->old_offer_data['names'][$local]) {
                if($local == 'ar' || $local == 'ku') {
                    $content .= "*" . 'Offer Name _ '. strtoupper($local) .' _ Changed: '. $this->old_offer_data['names'][$local] . ' ⬅️ ' . $this->names[$local] . "*\n";
                } else {
                    $content .= "*" . 'Offer Name _ '. strtoupper($local) .' _ Changed: '. $this->old_offer_data['names'][$local] . ' ➡️ ' . $this->names[$local] . "*\n";
                }
            }
        }

        if ($this->status !== $this->old_offer_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_offer_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        
        if ($this->priority !== $this->old_offer_data['priority']) {
            $content .= "*" . 'Priority Changed: '. $this->old_offer_data['priority'] . ' ➡️ ' . $this->priority . "*\n";
        }

        if ($this->price !== $this->old_offer_data['price']) {
            $content .= "*" . 'Price Changed: '. $this->old_offer_data['price'] . ' ➡️ ' . $this->price . "*\n";
        }
        if ($this->old_price !== $this->old_offer_data['oldPrice']) {
            $content .= "*" . 'Old Price Changed: '. $this->old_offer_data['oldPrice'] . ' ➡️ ' . $this->old_price . "*\n";
        }

        if ($this->img !== $this->old_offer_data['img']) {
            $content .= "*" . 'Image Changed To: '. $this->img . "*\n";
        }

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
