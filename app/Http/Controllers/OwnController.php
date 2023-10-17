<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnController extends Controller
{
    // PAGE VIEW
    public function profile(){
        return view('dashboard.own.pages.profile.index');
    } // END FUNCTION (PROFILE)
    public function dashboardOwn(){
        return view('dashboard.own.pages.dashboard.index');
    } // END FUNCTION (DASHBOARD)

    public function userActivity(){
        return view('dashboard.own.pages.userActivity.index');
    } // END FUNCTION (USER ACTIVITY)
    public function userInformation(){
        return view('dashboard.own.pages.userInformation.index');
    } // END FUNCTION (USER DATA)
    public function userData(){
        return view('dashboard.own.pages.userData.index');
    } // END FUNCTION (USER DATA)
    
    public function planSetting(){
        return view('dashboard.own.pages.plan.planSetting');
    } // END FUNCTION (PLAN-SETTING)
    public function userPlanView(){
        return view('dashboard.own.pages.plan.planUserView');
    } // END FUNCTION (PLAN-VIEW)
    public function guestPlanView(){
        return view('dashboard.own.pages.plan.planGuestView');
    } // END FUNCTION (PLAN-VIEW)

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
