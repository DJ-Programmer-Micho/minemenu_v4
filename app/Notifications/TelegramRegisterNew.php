<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramRegisterNew extends Notification
{
    protected $r_id;
    protected $business_name;
    protected $name;
    protected $email;
    protected $phone;
    protected $country;
    protected $type;

    public function __construct($id, $business_name, $email, $name, $phone, $country, $type)
    {
        $this->r_id = $id;
        $this->business_name = $business_name;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $url = env('APP_URL').$this->business_name;
        $registrationId = "#R-" . rand(10, 99);
        $registration3Id = rand(100, 999);


       return TelegramMessage::create()
       ->to(env('TELEGRAM_GROUP_ID'))
       ->content("*" . 'NEW USER REGISTERED' . "*\n"
       . "*" .'Reg-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
       . "*" .'Business Name: '. $this->business_name . "*\n"
       . "*" .'Regisered Name: '. $this->name . "*\n"
       . "*" .'EmailAddress: '. $this->email . "*\n"
       . "*" .'Phone Number: '. $this->phone . "*\n"
       . "*" .'Country: '. $this->country . "*\n"
       . "*" .'Type: '. $this->type . "*\n"
       )->button('View Menu', $url);
    }

    public function toArray($notifiable)
    {
        return [
            'business_name' => $this->business_name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
        ];
    }
}
