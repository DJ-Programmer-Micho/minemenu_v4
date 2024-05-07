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
    protected $ipAddress;
    protected $guestIdentifier;
    protected $deviceIdentifier;
    protected $country;
    protected $ohNo;
    protected $tele_id;

    public function __construct($s_id, $resturant_name, $name, $email, $subject, $message, $phone, $ipAddress, $guestIdentifier, $deviceIdentifier, $country, $ohNo, $tele_id)
    {
        $this->s_id = $s_id;
        $this->resturant_name = $resturant_name;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->phone = $phone;
        $this->message = $message;
        $this->ipAddress = $ipAddress;
        $this->guestIdentifier = $guestIdentifier;
        $this->deviceIdentifier = $deviceIdentifier;
        $this->country = $country;
        $this->ohNo = $ohNo;
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
        . "*" .'M-ID: '. $registrationId . '-'. $this->s_id .'-' . $registration3Id . "*\n"
        . "*" .'Business Name: '. $this->resturant_name . "*\n"
        . "*" .'Name: '. $this->name ."*\n"
        . "*" .'Email Address: '. $this->email . "*\n"
        . "*" .'Phone Number: '. $this->phone . "*\n"
        . "*" .'Subject: '. $this->subject . "*\n"
        . "*" .'Message: '. $this->message . "*\n";

        if ($this->guestIdentifier != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'IP ADDRESS: ' . $this->ipAddress . "*\n";
        }
        if ($this->guestIdentifier != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Country: ' . $this->country . "*\n";
        }
        if ($this->guestIdentifier != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Guest Identifier: ' . $this->guestIdentifier . "*\n";
        }
        
        if ($this->deviceIdentifier != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Device Identifier: ' . $this->deviceIdentifier . "*\n";
        }
        
        if ($this->ohNo != null) {
            $content .= "*" .'-----------------'."*\n";
            $content .= "*" . 'Error ' . $this->ohNo . "*\n";
        }

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
