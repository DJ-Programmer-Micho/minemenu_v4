<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPlanChangeNew extends Notification
{
    protected $r_id;
    protected $business_name;
    protected $name;
    protected $email;
    protected $phone;
    protected $old_plan;
    protected $new_plan;
    protected $action;
    protected $amount;

    public function __construct($id, $business_name, $email, $name, $phone, $old_plan, $new_plan, $action, $amount)
    {
        $this->business_name = $business_name;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->old_plan = $old_plan;
        $this->new_plan = $new_plan;
        $this->action = $action;
        $this->amount = $amount;
        $this->r_id = $id;
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
       ->to(env('TELEGRAM_GROUP_ID_PLAN_REGISTER'))
       ->content("*" . 'REGISTER UPDATED' . "*\n"
       . "*" .'Reg-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
       . "*" .'Business Name: '. $this->business_name . "*\n"
       . "*" .'Regisered Name: '. $this->name . "*\n"
       . "*" .'EmailAddress: '. $this->email . "*\n"
       . "*" .'Phone Number: '. $this->phone . "*\n"
       . "*" .'Old Plan: '. $this->old_plan . "*\n"
       . "*" .'New Plan: '. $this->new_plan . "*\n"
       . "*" .'Action: '. $this->action . "*\n"
       . "*" .'Amount: '. $this->amount . "*\n"
       )->button('View Menu', $url);
    }

    public function toArray($notifiable)
    {
        return [
            'business_name' => $this->business_name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'old_plan' => $this->old_plan,
            'new_plan' => $this->new_plan,
            'action' => $this->action,
        ];
    }
}
