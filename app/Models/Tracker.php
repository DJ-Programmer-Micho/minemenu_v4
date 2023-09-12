<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip',
        'visit_date',
        'visit_time',
        'business_name', // Add the 'business_name' field
    ];

    public static function trackVisit()
    {
        $ip = md5(Request::ip() . Request::userAgent());
        $visitDate = now()->format('Y-m-d');
        $businessName = Request::route('business_name'); // Get the 'business_name' from the route

        // Check if the visitor is unique for the day within the specific business
        $existingVisit = static::where('ip', $ip)
            ->where('visit_date', $visitDate)
            ->where('business_name', $businessName)
            ->first();

        if (!$existingVisit) {
            // Create a new visit record
            static::create([
                'session_id' => session()->getId(),
                'ip' => $ip,
                'visit_date' => $visitDate,
                'visit_time' => now()->format('H:i:s'),
                'business_name' => $businessName,
            ]);
        }
    }
}
