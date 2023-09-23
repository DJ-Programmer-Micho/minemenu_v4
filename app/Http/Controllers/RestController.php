<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{
    // PAGE VIEW
    public function dashboard(){
        return view('dashboard.rest.pages.dashboard.index');
    } // END FUNCTION (DASHBOARD)
    public function mainmenu(){
        return view('dashboard.rest.pages.menu.index');
    } // END FUNCTION (MENU)
    public function category(){
        return view('dashboard.rest.pages.category.index');
    } // END FUNCTION (CATEGORY)
    public function food(){
        return view('dashboard.rest.pages.food.index');
    } // END FUNCTION (FOOD)
    public function offer(){
        return view('dashboard.rest.pages.offer.index');
    } // END FUNCTION (OFFER)
    public function languageSetting(){
        return view('dashboard.rest.pages.setting.languageSetting');
    } // END FUNCTION (LANGUAGE-SETTING)
    public function nameSetting(){
        return view('dashboard.rest.pages.setting.nameSetting');
    } // END FUNCTION (NAME-SETTING)
    public function menuSetting(){
        return view('dashboard.rest.pages.setting.menuSetting');
    } // END FUNCTION (MENU-SETTING)
    public function startSetting(){
        return view('dashboard.rest.pages.setting.startSetting');
    } // END FUNCTION (START-SETTING)
    public function plan(){
        return view('dashboard.rest.pages.plan.index');
    } // END FUNCTION (START-SETTING)
    public function designUiUx(){
        return view('dashboard.rest.pages.design.designUiUx');
    } // END FUNCTION (DESIGN-UI-UX)
    public function designCustomize(){
        return view('dashboard.rest.pages.design.designCustomize');
    } // END FUNCTION (DESIGN-CUSTOMIZE)
    public function designQr(){
        return view('dashboard.rest.pages.design.designQr');
    } // END FUNCTION (DESIGN-QRCODE)
    public function supportVideo(){
        return view('dashboard.rest.pages.support.tutorial');
    } // END FUNCTION (SUPPORT-VIDEO)
    public function supportDocument(){
        return view('dashboard.rest.pages.support.document');
    } // END FUNCTION (SUPPORT-DOCUMENTS)
    public function supportContactUs(){
        return view('dashboard.rest.pages.support.contactUs');
    } // END FUNCTION (SUPPORT-CONTUCTUS)
    public function supportMenuFix(){
        return view('dashboard.rest.pages.support.menuFix');
    } // END FUNCTION (SUPPORT-MENUFIX)
    public function supportError(){
        return view('dashboard.rest.pages.support.error');
    } // END FUNCTION (SUPPORT-ERROR)
}
