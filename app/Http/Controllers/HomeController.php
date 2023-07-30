<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return view('main.home.index');
    } // END FUNCTION (HOME)

    public function pricing(){
        return view('main.pricing.index');
    } // END FUNCTION (PRICING)

    public function contact(){
        return view('main.contact.index');
    } // END FUNCTION (CONTACT)

    public function test(){
        return view('main.home.test');
    } // END FUNCTION (CONTACT)
}
