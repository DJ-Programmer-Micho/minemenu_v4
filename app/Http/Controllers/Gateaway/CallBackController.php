<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\PlanChange;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Gateaway\Transaction;

class CallBackController extends Controller
{
    public function areebaCallBack(){
        $data = [
            "result" => "OK",
            "uuid" => "fb47ff137684df861dc4",
            "merchantTransactionId" => "da358214-adc7-4e1c-9f08-a0a99d473ed0",
            "purchaseId" => "20231012-fb47ff137684df861dc4",
            "transactionType" => "DEBIT",
            "paymentMethod" => "Creditcard",
            "amount" => "50.00",
            "currency" => "USD",
            "customer" => [
                "firstName" => "Michel Shabo",
                "lastName" => "N/A",
                "company" => "minemenu",
                "ipAddress" => "127.0.0.1",
            ],
            "returnData" => [
                "_TYPE" => "cardData",
                "type" => "mastercard",
                "cardHolder" => "areeba",
                "expiryMonth" => "05",
                "expiryYear" => "2026",
                "binDigits" => "51234500",
                "firstSixDigits" => "512345",
                "lastFourDigits" => "0008",
                "fingerprint" => "/9NMen+1D5cGfQUB5NHb+mDrnqCBeL86wdGbuzCf7avMpvlMZEBJr1xBrZyAPTH02cJ6+Yz3O61kN+5MugQjNQ",
                "threeDSecure" => "OPTIONAL",
                "eci" => "02",
                "binBrand" => "MASTERCARD",
                "binBank" => "Afriland First Bank",
                "binType" => "CREDIT",
                "binLevel" => "STANDARD",
                "binCountry" => "LR",
            ],
        ];
        $Transaction = Transaction::findOrFail($data['merchantTransactionId']);
        $plan = Plan::find($Transaction->plan_id);
        // dd($Transaction);
        $Transaction->update([
            'transactions_data'=> $data,
            'result' => $data['result'],
            'card_data' => $data['returnData'],
        ]);
        if($data['result']){
            if($data['result'] == "OK" ){
            $temp = Subscription::where('user_id', $Transaction->user_id)->first();
            $old_plan = $temp->plan_id ?? 1;
            
            if ($temp) {
                Subscription::where('user_id', $Transaction->user_id)->update([
                    'plan_id' => $plan->id,
                    'start_at' => now(),
                    'expire_at' => now()->addDays($plan->duration),
                    'renew_at' => now()->addDays($plan->duration),
                    'status' => 1,
                ]);
            } else {
                Subscription::Create([
                    'user_id' => $Transaction->user_id,
                    'plan_id' => $plan->id,
                    'start_at' => now(),
                    'expire_at' => now()->addDays($plan->duration),
                    'renew_at' => now()->addDays($plan->duration),
                    'status' => 1,
                ]);
            }
            if (Subscription::where('user_id', $Transaction->user_id)->exists()) {
                $subscription = Subscription::where('user_id', $Transaction->user_id)->first();
                $Transaction->update([
                    'subscription_id' => $subscription->id,
                ]);
            }
            PlanChange::Create([
                'user_id' => $Transaction->user_id,
                'old_plan_id' => $old_plan,
                'new_plan_id' => $Transaction->plan_id,
                'action' => 'Visa/Master',
                'change_date' => now(),
            ]);
            }
        }
        

        return  response('OK',200);
    }


    public function zainCashCallBack(){
        if (request()->has('token')){
            $result= JWT::decode(request('token'), new Key(env('ZIANCASH_SECRET_KEY'), 'HS256'));
            $data= (array) $result;
            // dd($data);
            $Transaction = Transaction::findOrFail($data['orderid']);
            $plan = Plan::find($Transaction->plan_id);
    
            $Transaction->update([
                'transactions_data'=> $data,
                'result' => $data['status'],
                'card_data' => ['number' => $data['msisdn'] ?? $data['id']],
            ]);
            //And to check for status of the transaction, use $result['status'], like this:
            if ($data['status']=='success'){



                $temp = Subscription::where('user_id', $Transaction->user_id)->first();
                $old_plan = $temp->plan_id ?? 1;
                
                if ($temp) {
                    Subscription::where('user_id', $Transaction->user_id)->update([
                        'plan_id' => $plan->id,
                        'start_at' => now(),
                        'expire_at' => now()->addDays($plan->duration),
                        'renew_at' => now()->addDays($plan->duration),
                        'status' => 1,
                    ]);
                } else {
                    Subscription::Create([
                        'user_id' => $Transaction->user_id,
                        'plan_id' => $plan->id,
                        'start_at' => now(),
                        'expire_at' => now()->addDays($plan->duration),
                        'renew_at' => now()->addDays($plan->duration),
                        'status' => 1,
                    ]);
                }
                if (Subscription::where('user_id', $Transaction->user_id)->exists()) {
                    $subscription = Subscription::where('user_id', $Transaction->user_id)->first();
                    $Transaction->update([
                        'subscription_id' => $subscription->id,
                    ]);
                }
                PlanChange::Create([
                    'user_id' => $Transaction->user_id,
                    'old_plan_id' => $old_plan,
                    'new_plan_id' => $Transaction->plan_id,
                    'action' => 'Zain Cash',
                    'change_date' => now(),
                ]);
                return redirect('/payment/success');

            }



            if ($data['status']=='failed'){
                $reason=$data['msg'];
                Log::info($reason);
                return redirect('/payment/error');
            }
        }else{
            //Cancelled transaction (if he clicked "Cancel and go back"
            return redirect('/plans');
        }

    }

}
