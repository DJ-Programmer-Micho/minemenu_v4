<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{ 
    public function show(Plan $id){
        $plan = $id;
        return view('main.plan.show',compact('plan'));
    }
}