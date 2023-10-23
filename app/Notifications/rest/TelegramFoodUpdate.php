<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramFoodUpdate extends Notification
{
    protected $r_id;
    protected $cat_id;
    protected $food_name;
    protected $food_main_name;
    protected $cat_name;
    protected $price;
    protected $old_price;
    protected $options;
    protected $sorm;
    protected $status;
    protected $priority;
    protected $special;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_food_data;
    protected $old_category_name;
    protected $new_category_name;

    public function __construct($old_food_data, $id, $cat_id, $food_name, $old_category_name, $new_category_name, $sorm, $status, $priority, $special, $price, $old_price, $options, $img, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->cat_id = $cat_id;
        $this->food_name = $food_name;
        $this->food_main_name = $food_name['en'] ?? 'unknown';
        $this->price = $price ?? null;
        $this->old_price = $old_price ?? null;
        $this->options = $options ?? null;
        $this->sorm = $sorm;
        $this->status = $status;
        $this->priority = $priority;
        $this->special = $special;
        $this->img = $img;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_food_data = $old_food_data;
        $this->old_category_name = $old_category_name;
        $this->new_category_name = $new_category_name;

        $this->sorm = $this->sorm == 0 ?  "Single" : "Multi";
        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->special = $this->special == 0 ?  "Non-Special" : "Special";
        $this->old_food_data['sorm'] = $this->old_food_data['sorm'] == 0 ?  "Single" : "Multi";
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

        foreach ($this->old_food_data['locales'] as $local){
            if($this->food_name[$local] !== $this->old_food_data['names'][$local]) {
                if($local == 'ar' || $local == 'ku') {
                    $content .= "*" . 'Food Name _ '. strtoupper($local) .' _ Changed: '. $this->old_food_data['names'][$local] . ' ⬅️ ' . $this->food_name[$local] . "*\n";
                } else {
                    $content .= "*" . 'Food Name _ '. strtoupper($local) .' _ Changed: '. $this->old_food_data['names'][$local] . ' ➡️ ' . $this->food_name[$local] . "*\n";
                }
            }
        }
        
        if ($this->old_category_name !== $this->new_category_name) {
            $content .= "*" . 'Category Group Changed: '. $this->old_category_name . ' ➡️ ' . $this->new_category_name . "*\n";
        }

        if ($this->status !== $this->old_food_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_food_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        
        if ($this->priority !== $this->old_food_data['priority']) {
            $content .= "*" . 'Priority Changed: '. $this->old_food_data['priority'] . ' ➡️ ' . $this->priority . "*\n";
        }
        
        if ($this->sorm !== $this->old_food_data['sorm']) {
            $content .= "*" . 'Price Type Changed: '. $this->old_food_data['sorm'] . ' ➡️ ' . $this->sorm . "*\n";
        }

        if ($this->special !== $this->old_food_data['special']) {
            $content .= "*" . 'Special Changed: '. $this->old_food_data['special'] . ' ➡️ ' . $this->special . "*\n";
        }

        if($this->sorm == "Single") {
            if ($this->price !== $this->old_food_data['price']) {
                $content .= "*" . 'Price Changed: '. $this->old_food_data['price'] . ' ➡️ ' . $this->price . "*\n";
            }
            if ($this->old_price !== $this->old_food_data['oldPrice']) {
                $content .= "*" . 'Old Price Changed: '. $this->old_food_data['oldPrice'] . ' ➡️ ' . $this->old_price . "*\n";
            }
        } else {
            foreach ($this->old_food_data['options'] as $locale => $oldPriceArray) {
                foreach ($oldPriceArray as $index => $oldPrice) {
                    $newPrice = $this->options[$locale][$index]['value'];
            
                    if ($oldPrice['value'] !== $newPrice) {
                        $content .= "*" . 'Price for ' . strtoupper($locale) . ' - ' . $this->options[$locale][$index]['key'] . ' Changed: ' . $oldPrice['value'] . ' ➡️ ' . $newPrice . "*\n";
                    }
                }
            }
        }

        if ($this->img !== $this->old_food_data['img']) {
            $content .= "*" . 'Image Changed To: '. $this->img . "*\n";
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
