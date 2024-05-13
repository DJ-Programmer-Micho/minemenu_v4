<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return view('main.home.index');
    } // END FUNCTION (HOME)

    public function documentation(){
        return view('main.documentation.index');
    } // END FUNCTION (PRICING)

    public function pricing(){
        return view('main.pricing.index');
    } // END FUNCTION (PRICING)

    public function contact(){
        return view('main.contact.index');
    } // END FUNCTION (CONTACT)

    public function privacy_policy(){
        return view('main.privacy_policy.index');
    } // END FUNCTION (CONTACT)
    
    public function term_condition(){
        return view('main.term_condition.index');
    } // END FUNCTION (CONTACT)

    public function test(){
        return view('main.home.test');
    } // END FUNCTION (CONTACT)
}
