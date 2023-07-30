<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return view('main.home.index');
    } // END FUNCTION

    public function pricing(){
        return redirect('pricing');
    } // END FUNCTION

    public function contact(){
        return redirect('contact');
    } // END FUNCTION
}
