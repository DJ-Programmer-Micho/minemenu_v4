<?php

namespace App\Notifications\Owner;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramContactUs extends Notification
{
    protected $s_id;
    protected $resturant_name;
    protected $name;
    protected $email;
    protected $subject;
    protected $message;
    protected $phone;
    protected $tele_id;

    public function __construct($s_id, $resturant_name, $name, $email, $subject, $message, $phone, $tele_id,)
    {
        $this->s_id = $s_id;
        $this->resturant_name = $resturant_name;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->phone = $phone;
        $this->message = $message;
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

        $content = "*" . 'NEW SUPPORT MESSAGE' . "*\n"
        . "*" .'-----------------'."*\n" 
        . "*" .'Cat-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
        . "*" .'Business Name: '. $this->resturant_name . "*\n"
        . "*" .'Name: '. $this->name . "*\n"
        . "*" .'Email Address: '. $this->email . "*\n"
        . "*" .'Phone Number: '. $this->phone . "*\n"
        . "*" .'Subject: '. $this->subject . "*\n"
        . "*" .'Message: '. $this->message . "*\n";

       return TelegramMessage::create()
       ->to($this->tele_id)
       ->content($content)
       ->button('View Menu', $menu_url);
    }

    public function toArray($notifiable)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];
    }
}
