<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestController extends Controller
{
    public function dashboard(){
        return view('dashboard.rest.pages.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function mainmenu(){
        return view('dashboard.rest.pages.menu.index');
    } // END FUNCTION (DASHBOARD)

    public function category(){
        return view('dashboard.rest.pages.category.index');
    } // END FUNCTION (DASHBOARD)
    public function food(){
        return view('dashboard.rest.pages.food.index');
    } // END FUNCTION (DASHBOARD)
    public function menuSetting(){
        return view('dashboard.rest.pages.setting.menuSetting');
    } // END FUNCTION (DASHBOARD)
    public function startSetting(){
        return view('dashboard.rest.pages.setting.startSetting');
    } // END FUNCTION (DASHBOARD)
    public function languageSetting(){
        return view('dashboard.rest.pages.setting.languageSetting');
    } // END FUNCTION (DASHBOARD)
}
