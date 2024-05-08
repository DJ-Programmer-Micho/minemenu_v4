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
    protected $location;
    protected $guestIdentifier;
    protected $deviceIdentifier;
    protected $tele_id;

    public function __construct($s_id, $resturant_name, $name, $email, $subject, $message, $phone, $location, $guestIdentifier, $deviceIdentifier, $tele_id)
    {
        $this->s_id = $s_id;
        $this->resturant_name = $resturant_name;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->phone = $phone;
        $this->message = $message;
        $this->location = $location;
        $this->guestIdentifier = $guestIdentifier;
        $this->deviceIdentifier = $deviceIdentifier;
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

        if ($this->location->ip != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'IP ADDRESS: ' . $this->location->ip . "*\n";
        }

        if ($this->location->countryName != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Country: ' . $this->location->countryName . "*\n";        
        }

        if ($this->location->countryCode != null) {
            $content .= "*" . 'Country Code: ' . $this->location->countryCode . "*\n";
        }

        if ($this->location->regionName != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Region Name: ' . $this->location->regionName . "*\n";
        }

        if ($this->location->regionCode != null) {
            $content .= "*" . 'Region Code: ' . $this->location->regionCode . "*\n";
        }

        if ($this->location->cityName != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'City Name: ' . $this->location->cityName . "*\n";;
        }

        if ($this->location->zipCode != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Zip Code: ' . $this->location->zipCode . "*\n";
        }
        
        if ($this->location->latitude != null) {
            $content .= "*" .'-----------------'."*\n"; 
            $content .= "*" . 'Latitude: ' . $this->location->latitude . "*\n";
        }

        if ($this->location->longitude != null) {
            $content .= "*" . 'Longtitude: ' . $this->location->longitude . "*\n";
        }
        
        if ($this->location->areaCode != null) {
            $content .= "*" .'-----------------'."*\n";
            $content .= "*" . 'Area Code: ' . $this->location->areaCode . "*\n";
        }

        if ($this->location->timezone != null) {
            $content .= "*" .'-----------------'."*\n";
            $content .= "*" . 'Time Zone: ' . $this->location->timezone . "*\n";
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
