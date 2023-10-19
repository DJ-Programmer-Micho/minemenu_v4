<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramContactUs extends Notification
{
    protected $name;
    protected $email;
    protected $message;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
       return TelegramMessage::create()
           ->to(env('TELEGRAM_GROUP_ID'))
           ->content("*" . $this->name . "*\n" . $this->email)
           ->button('View Menu', 'http://127.0.0.1:8000/pricing');
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
