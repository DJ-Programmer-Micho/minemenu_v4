<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackFoods extends Model
{
    use HasFactory;

    protected $table = 'clicks';
    protected $fillable = [
        'guest_identifier', 
        'category_id',      
        'food_id',          
        'business_name_id',
    ];
}
