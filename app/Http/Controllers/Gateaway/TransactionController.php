<?php

namespace App\Http\Controllers\Gateaway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function success(){
        return view('main.Transactions.success');
    }

    public function cancel(){
        return view('main.Transactions.cancel');
    }

    public function pageError(){
        return view('main.Transactions.error');
    }
}
