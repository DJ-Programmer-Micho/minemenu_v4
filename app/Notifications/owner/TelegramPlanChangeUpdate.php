<?php

namespace App\Notifications\owner;

use App\Models\Plan;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPlanChangeUpdate extends Notification
{
    protected $r_id;
    protected $business_name;
    protected $name;
    protected $email;
    protected $phone;

    protected $email_verified;
    protected $phone_verified;
    protected $status;
    protected $expire_at;

    protected $new_plan;
    protected $action;
    protected $amount;
    protected $junk_data = [];
    protected $planNames = [];

    public function __construct($id, $business_name, $email, $name, $phone, $email_verified, $phone_verified, $status, $expire_at, $new_plan, $action, $amount, $junk_data)
    {
        $this->r_id = $id;
        $this->business_name = $business_name;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->email_verified = $email_verified;
        $this->phone_verified = $phone_verified;
        $this->status = $status;
        $this->expire_at = $expire_at;
        $this->new_plan = $new_plan;
        $this->action = $action;
        $this->amount = $amount;
        $this->junk_data = $junk_data;

        $this->email_verified = $this->email_verified == 0 ?  "DeActive" : "Active";
        $this->phone_verified = $this->phone_verified == 0 ?  "DeActive" : "Active";
        $this->status = $this->status == 0 ?  "DeActive" : "Active";
        $this->junk_data['email_verified_old'] = $this->junk_data['email_verified_old'] == 0 ?  "DeActive" : "Active";
        $this->junk_data['phone_verified_old'] = $this->junk_data['phone_verified_old'] == 0 ?  "DeActive" : "Active";
        $this->junk_data['status_old'] = $this->junk_data['status_old'] == 0 ?  "DeActive" : "Active";

        $plans = Plan::get();
        
        foreach ($plans as $plan) {
            $this->planNames[$plan->id] = $plan->name['en'] ?? 'Error';
        }
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

        $content = "*" . 'NEW USER REGISTERED' . "*\n" 
        . "*" .'Reg-ID: '. $registrationId . '-'. $this->r_id .'-' . $registration3Id . "*\n"
        . "*" .'Business Name: '. $this->business_name . "*\n"
        . "*" .'Regisered Name: '. $this->name . "*\n"
        . "*" .'EmailAddress: '. $this->email . "*\n"
        . "*" .'Phone Number: '. $this->phone . "*\n";

        if ($this->email_verified !== $this->junk_data['email_verified_old']) {
            $content .= "*" . 'Email Verification Changed: '. $this->junk_data['email_verified_old'] . ' ==> ' . $this->email_verified . "*\n";
        }

        if ($this->phone_verified !== $this->junk_data['phone_verified_old']) {
            $content .= "*" . 'Phone Verification Changed: '. $this->junk_data['phone_verified_old'] . ' ==> ' . $this->phone_verified . "*\n";
        }

        if ($this->status !== $this->junk_data['status_old']) {
            $content .= "*" . 'Email Address Changed: '. $this->junk_data['status_old'] . ' ==> ' . $this->status . "*\n";
        }
    
        if ($this->expire_at !== $this->junk_data['expire_at_old']) {
            $content .= "*" . 'Valid Date Changed: '. $this->junk_data['expire_at_old'] . ' ==> ' . $this->expire_at . "*\n";
        }
    
        if ($this->new_plan !== $this->junk_data['add_plan_id_old']) {
            $content .= "*" . 'Plan Changed: '.  $this->planNames[$this->junk_data['add_plan_id_old']] . ' ==> ' .  $this->planNames[$this->new_plan] . "*\n";
        }

        $content .= "*" . 'Type: '. $this->action . "*\n";

       return TelegramMessage::create()
       ->to(env('TELEGRAM_GROUP_ID_PLAN_REGISTER'))
       ->content($content)
       ->button('View Menu', $url);
    }

    // public function toArray($notifiable)
    // {
    //     return [
    //         'business_name' => $this->business_name,
    //         'name' => $this->name,
    //         'email' => $this->email,
    //         'phone' => $this->phone,
    //         'old_plan' => $this->old_plan,
    //         'new_plan' => $this->new_plan,
    //         'action' => $this->action,
    //     ];
    // }
}
