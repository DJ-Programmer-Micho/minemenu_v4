<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\PlanChange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gateaway\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function success(){
        return view('main.Transactions.success');
        // if(Auth::user()){
        //     $tempUser = Auth::user();
        //     $userId = $tempUser->id;
        //     $transactionStatus = Transaction::where('user_id', $userId)->where('created_at', today())->first() ?? null;
        //     if($transactionStatus) {

        //         PlanChange::Create([
        //             'user_id' => $userId,
        //             'old_plan_id' => $tempUser->subscription->plan_id,
        //             'new_plan_id' => $transactionStatus->plan_id,
        //             'action' => 'Payed',
        //             'change_date' => now(),
        //         ]);

        //         return view('main.Transactions.success');
        //     }
        // } else {
        //     return view('main.Transactions.error');
        // }
    }

    public function cancel(){
        return view('main.Transactions.cancel');
    }

    public function pageError(){
        return view('main.Transactions.error');
    }
}
