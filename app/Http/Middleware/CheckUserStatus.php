<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // dd('Inside middleware', Route::currentRouteName());
            if ($user->status == 0) {
                Auth::logout();
                return redirect('/login')->with('alert', 'This is an alert message.');
            }

            if (Route::currentRouteName() !== 'plan' && $user->subscription->expire_at <= now()) {
                return redirect()->route('plan');
            }

            if ($user->email_verified === null || $user->email_verified === 0) {
                // Auth::logout();
                return redirect()->route('goEmailOTP', ['email' => $user->email]);
            }

            if ($user->phone_verified === null || $user->phone_verified === 0) {
                // Auth::logout();
                return redirect()->route('goOTP', ['id' => $user->id, 'phone' => $user->profile->phone]);
            }
        }

        return $next($request);
    }
}
