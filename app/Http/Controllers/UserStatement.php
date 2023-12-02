<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserStatement extends Controller
{
    public function expire_state(){
        return view('main.userStatement.expireState');
    }
    public function suspend_state(){
        return view('main.userStatement.suspendedState');
    }
}
