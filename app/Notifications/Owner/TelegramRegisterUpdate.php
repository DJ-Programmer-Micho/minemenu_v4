<?php

namespace App\Notifications\Owner;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramRegisterUpdate extends Notification
{
    protected $r_id;
    protected $business_name;
    protected $name;
    protected $email;
    protected $phone;
    protected $country;
    protected $type;
    protected $junk_data = [];

    public function __construct($id, $business_name, $email, $name, $phone, $country, $type, $junk_data)
    {
        $this->r_id = $id;
        $this->business_name = $business_name;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->type = $type;
        $this->junk_data = $junk_data;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // dd($this->junk_data);
        $url = env('APP_URL').$this->business_name;
        $registrationId = "#R-" . rand(10, 99);
        $registration3Id = rand(100, 999);

        $content = "*" . 'NEW USER REGISTERED' . "*\n" .
        "*" .'Reg-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n";

        if ($this->business_name !== $this->junk_data['old_add_businessname']) {
            $content .= "*" . 'Business Name Changed: '. $this->junk_data['old_add_businessname'] . ' ==> ' . $this->business_name . "*\n";
        }

        if ($this->name !== $this->junk_data['old_add_fullname']) {
            $content .= "*" . 'Registered Name Changed: '. $this->junk_data['old_add_fullname'] . ' ==> ' . $this->name . "*\n";
        }

        if ($this->email !== $this->junk_data['old_add_email']) {
            $content .= "*" . 'Email Address Changed: '. $this->junk_data['old_add_email'] . ' ==> ' . $this->email . "*\n";
        }
    
        if ($this->phone !== $this->junk_data['old_add_phone']) {
            $content .= "*" . 'Phone Number Changed: '. $this->junk_data['old_add_phone'] . ' ==> ' . $this->phone . "*\n";
        }
    
        if ($this->country !== $this->junk_data['old_add_country']) {
            $content .= "*" . 'Country Changed: '. $this->junk_data['old_add_country'] . ' ==> ' . $this->country . "*\n";
        }

        $content .= "*" . 'Type: '. $this->type . "*\n";

       return TelegramMessage::create()
       ->to(env('TELEGRAM_GROUP_ID'))
       ->content($content)
       ->button('View Menu', $url);
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
