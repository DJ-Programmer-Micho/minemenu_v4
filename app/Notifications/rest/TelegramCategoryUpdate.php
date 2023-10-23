<?php

namespace App\Notifications\rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramCategoryUpdate extends Notification
{
    protected $r_id;
    protected $names;
    protected $main_names; //Static to get EN Only
    protected $menu_name;
    protected $status;
    protected $priority;
    protected $img;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_category_data;
    protected $old_menu_name;
    protected $new_menu_name;

    public function __construct($old_category_data, $id, $names, $status, $priority, $img, $telegram_channel_link, $view_business_name, $old_menu_name, $new_menu_name)
    {
        $this->r_id = $id;
        $this->names = $names;
        $this->main_names = $names['en'] ?? 'unknown';
        $this->status = $status;
        $this->priority = $priority;
        $this->img = $img;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_category_data = $old_category_data;
        $this->old_menu_name = $old_menu_name;
        $this->new_menu_name = $new_menu_name;

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

        foreach ($this->old_category_data['locales'] as $local){
            if($this->names[$local] !== $this->old_category_data['names'][$local]) {
                if($local == 'ar' || $local == 'ku') {
                    $content .= "*" . 'Category Name _ '. strtoupper($local) .' _ Changed: '. $this->old_category_data['names'][$local] . ' ⬅️ ' . $this->old_category_data[$local] . "*\n";
                } else {
                    $content .= "*" . 'Category Name _ '. strtoupper($local) .' _ Changed: '. $this->old_category_data['names'][$local] . ' ➡️ ' . $this->names[$local] . "*\n";
                }
            }
        }

        if ($this->old_menu_name !== $this->new_menu_name) {
            $content .= "*" . 'Menu Group Changed: '. $this->old_menu_name . ' ➡️ ' . $this->new_menu_name . "*\n";
        }

        if ($this->status !== $this->old_category_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_category_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        
        if ($this->priority !== $this->old_category_data['priority']) {
            $content .= "*" . 'Priority Changed: '. $this->old_category_data['priority'] . ' ➡️ ' . $this->priority . "*\n";
        }

        if ($this->img !== $this->old_category_data['img']) {
            $content .= "*" . 'Image Changed To: '. $this->img . "*\n";
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
