<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsTracker extends Model
{
    use HasFactory;
    protected $table = 'ads_trackers';
    protected $fillable = [
        'name',
        'redirect_url',
        'ip_Address',
        'device_identifier',
        'visit_date',
        'visit_time',
    ];
}
