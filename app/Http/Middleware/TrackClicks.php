<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\TrackFoods;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackClicks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type): Response
    {
        // Extract the 'business_name' parameter from the route
        $businessName = $request->route('business_name');
        $cat_id = $request->route('food') ?? null;
        $food_id = $request->route('detail') ?? null;
        // dd($businessName,$cat_id,$food_id);
        $clickedId = $request->route($type);

        if ($businessName && $clickedId) {
            // Generate a unique identifier for the guest based on IP
            $guestIdentifier = md5($_SERVER['REMOTE_ADDR'] . $businessName);

            $existingClick = TrackFoods::where('guest_identifier', $guestIdentifier)
                ->where($type.'_id', $clickedId)
                ->where('category_id', $cat_id)
                ->where('food_id', $food_id)
                ->first();

            if (!$existingClick) {
                TrackFoods::create([
                    'guest_identifier' => $guestIdentifier,
                    'category_id' => $cat_id,
                    'food_id' => $food_id,
                    $type.'_id' => $clickedId,
                    'business_name' => $businessName,
                ]);
            }
        }

        return $next($request);
    }
}
