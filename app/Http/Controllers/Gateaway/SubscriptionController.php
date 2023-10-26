<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use App\Models\Gateaway\Payment;
use App\Http\Controllers\Controller;
use App\Models\Gateaway\Transaction;
use App\Services\PaymentServiceManager;


class SubscriptionController extends Controller
{
    public function subscribe() {

        // dd(request()->all());

        $form = request()->validate([
            'id' => 'required|numeric',
            'payment_method' => 'required|numeric',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ]);

        // dd($form);

        $id = request()->id;
        $payment_method  = request()->payment_method;

        $plan = Plan::findOrFail($id);
        $user = auth()->user();
        $currency = (stripos($user->profile->country,'iraq') !== false) ? 'IQD' : 'USD';
        $cost = ($currency == 'IQD') ? ($plan->cost * $plan->exchange_rate) : $plan->cost;
        $cost = (string) $cost;

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
        ]);

        // dd($currency,$transaction);

        
        if($payment_method == Payment::AREEBA_PAYMENT){
            $pay = PaymentServiceManager::getInstance()
            ->setUser(auth()->user())
            ->setIpAddress(request()->ip())
            ->setLanguage(app()->getLocale())
            ->setAmount($cost)
            ->setCurrency($currency)
            ->setTransactionId($transaction->id)
            ->setPaymentMethod(Payment::AREEBA_PAYMENT)
            ->send();
            return redirect()->away($pay);
        } elseif($payment_method == Payment::ZAINCASH_PAYMENT){
            $pay = PaymentServiceManager::getInstance()
            ->setLanguage(app()->getLocale())
            ->setAmount($plan->cost * $plan->exchange_rate)
            ->setOrderId($transaction->id)
            ->setPaymentMethod(Payment::ZAINCASH_PAYMENT)
            ->send();
            return redirect()->away($pay);
        }


    }
}
