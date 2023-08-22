<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index($business_name){

        $user = User::where('name', $business_name)->first();

        if (!$user) {
            return response('User not found', 404);
        }

        // Get the user ID
        $userId = $user->id;

        return "User ID for business_name '{$business_name}': {$userId}";
    }
}
