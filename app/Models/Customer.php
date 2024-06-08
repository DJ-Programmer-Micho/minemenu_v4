<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'first_name', 
        'last_name', 
        'dob', 
        'phone',
    ];

    public function restRatings()
    {
        return $this->hasMany(RestRating::class);
    }

    public function foodRatings()
    {
        return $this->hasMany(FoodRating::class);
    }
}
