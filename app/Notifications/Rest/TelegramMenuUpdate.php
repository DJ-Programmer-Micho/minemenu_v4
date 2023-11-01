<?php

namespace App\Notifications\Rest;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramMenuUpdate extends Notification
{
    protected $r_id;
    protected $main_names;
    protected $names;
    protected $status;
    protected $priority;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $old_menu_data;

    public function __construct($old_menu_data, $id, $names, $status, $priority, $telegram_channel_link, $view_business_name)
    {
        $this->r_id = $id;
        $this->names = $names;
        $this->main_names = $names['en'] ?? 'unknown';
        $this->status = $status;
        $this->priority = $priority;
        $this->telegram_channel_link = $telegram_channel_link;
        $this->view_business_name = $view_business_name;
        $this->old_menu_data = $old_menu_data;


        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->old_menu_data['status'] = $this->old_menu_data['status'] == 0 ?  "DeActive" : "Active";
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

        $content = "*" . 'MENU UPDATED' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Menu-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'MENU Main Name: '. $this->main_names . "*\n"
        . "*" .'-----------------'."*\n";

        foreach ($this->old_menu_data['locales'] as $local){
            if($this->names[$local] !== $this->old_menu_data['names'][$local]) {
                if($local == 'ar' || $local == 'ku') {
                    $content .= "*" . 'Food Name _ '. strtoupper($local) .' _ Changed: '. $this->old_menu_data['names'][$local] . ' ⬅️ ' . $this->names[$local] . "*\n";
                } else {
                    $content .= "*" . 'Menu Name _ '. strtoupper($local) .' _ Changed: '. $this->old_menu_data['names'][$local] . ' ➡️ ' . $this->names[$local] . "*\n";
                }
            }
        }

        if ($this->status !== $this->old_menu_data['status']) {
            $content .= "*" . 'Status Changed: '. $this->old_menu_data['status'] . ' ➡️ ' . $this->status . "*\n";
        }
        
        if ($this->priority !== $this->old_menu_data['priority']) {
            $content .= "*" . 'Priority Changed: '. $this->old_menu_data['priority'] . ' ➡️ ' . $this->priority . "*\n";
        }

       return TelegramMessage::create()
        ->to($this->telegram_channel_link)
        ->content($content)
        ->button('View Menu', $menu_url);
    }

    public function toArray($notifiable)
    {

    }
}
