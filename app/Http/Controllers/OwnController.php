<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnController extends Controller
{
    // PAGE VIEW
    public function profile(){
        return view('dashboard.own.pages.profile.index');
    } // END FUNCTION (PROFILE)
    public function dashboard(){
        return view('dashboard.own.pages.dashboard.index');
    } // END FUNCTION (DASHBOARD)
    public function mainmenu(){
        return view('dashboard.own.pages.menu.index');
    } // END FUNCTION (MENU)
    public function category(){
        return view('dashboard.own.pages.category.index');
    } // END FUNCTION (CATEGORY)
    public function food(){
        return view('dashboard.own.pages.food.index');
    } // END FUNCTION (FOOD)
    public function offer(){
        return view('dashboard.own.pages.offer.index');
    } // END FUNCTION (OFFER)
    public function languageSetting(){
        return view('dashboard.own.pages.setting.languageSetting');
    } // END FUNCTION (LANGUAGE-SETTING)
    public function nameSetting(){
        return view('dashboard.own.pages.setting.nameSetting');
    } // END FUNCTION (NAME-SETTING)
    public function menuSetting(){
        return view('dashboard.own.pages.setting.menuSetting');
    } // END FUNCTION (MENU-SETTING)
    public function startSetting(){
        return view('dashboard.own.pages.setting.startSetting');
    } // END FUNCTION (START-SETTING)
    public function plan(){
        return view('dashboard.own.pages.plan.index');
    } // END FUNCTION (START-SETTING)
    public function designUiUx(){
        return view('dashboard.own.pages.design.designUiUx');
    } // END FUNCTION (DESIGN-UI-UX)
    public function designCustomize(){
        return view('dashboard.own.pages.design.designCustomize');
    } // END FUNCTION (DESIGN-CUSTOMIZE)
    public function designQr(){
        return view('dashboard.own.pages.design.designQr');
    } // END FUNCTION (DESIGN-QRCODE)
    public function supportVideo(){
        return view('dashboard.own.pages.support.tutorial');
    } // END FUNCTION (SUPPORT-VIDEO)
    public function supportDocument(){
        return view('dashboard.own.pages.support.document');
    } // END FUNCTION (SUPPORT-DOCUMENTS)
    public function supportContactUs(){
        return view('dashboard.own.pages.support.contactUs');
    } // END FUNCTION (SUPPORT-CONTUCTUS)
    public function supportMenuFix(){
        return view('dashboard.own.pages.support.menuFix');
    } // END FUNCTION (SUPPORT-MENUFIX)
    public function supportError(){
        return view('dashboard.own.pages.support.error');
    } // END FUNCTION (SUPPORT-ERROR)
}
