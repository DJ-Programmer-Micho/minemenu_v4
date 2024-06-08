<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestRating extends Model
{
    use HasFactory;
    protected $table = 'rest_ratings';
    protected $fillable = [
        'customer_id', 
        'user_id', 
        'staff', 
        'service', 
        'environment', 
        'experience', 
        'cleaning', 
        'note'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
