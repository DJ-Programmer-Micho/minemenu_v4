<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramCategoryUpdateStatus extends Notification
{
    protected $r_id;
    protected $names;
    protected $main_names;
    protected $menu_name;
    protected $status;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_category_data;

    public function __construct($old_category_data, $id, $names, $status, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->names = $names;
        $this->main_names = $names['en'] ?? 'unknown';
        $this->status = $status;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_category_data = $old_category_data;
        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_category_data['status'] = $this->old_category_data['status'] == 0 ?  "DeActive" : "Active";
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

        $content = "*" . 'CATEGORY UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Cat-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Category Name: '. $this->main_names . "*\n"
        . "*" .'-----------------'."*\n";

        if ($this->status !== $this->old_category_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_category_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        


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
