<?php

namespace App\Notifications\Owner;

use App\Models\Plan;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPlanClicked extends Notification
{
    protected $v_id;
    protected $resturant_name;
    protected $name;
    protected $plan;
    protected $country;
    protected $tele_id;

    public function __construct($v_id, $resturant_name, $name, $plan, $country, $tele_id,)
    {
        $this->v_id = $v_id;
        $this->resturant_name = $resturant_name;
        $this->name = $name;
        $this->plan = $plan->name['en'];
        $this->country = $country;
        $this->tele_id = $tele_id;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $menu_url = env('APP_URL').$this->resturant_name;
        $registrationId = "#S-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'USER CHECKED PLAN' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Type: '. $this->v_id . "*\n"
        . "*" .'Business Name: '. $this->resturant_name . "*\n"
        . "*" .'Name: '. $this->name . "*\n"
        . "*" .'Country: '. $this->country . "*\n"
        . "*" .'Plan Clicked: '. $this->plan . "*\n";

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content($content);
    }

    // public function toArray($notifiable)
    // {
    //     return [
    //         'name' => $this->name,
    //         'email' => $this->email,
    //         'message' => $this->message,
    //     ];
    // }
}
