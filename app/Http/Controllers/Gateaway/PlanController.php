<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{ 
    public function show(Plan $id){
        if (!$id->valid_date || $id->valid_date >= now()) {
            $plan = $id;
        } else {
            return 'HA Expire';
        }
        return view('main.plan.show',compact('plan'));
    }
}