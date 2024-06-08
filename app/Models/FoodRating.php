<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRating extends Model
{
    use HasFactory;
    protected $table = 'food_ratings';
    protected $fillable = ['customer_id', 'food_id', 'rating'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
