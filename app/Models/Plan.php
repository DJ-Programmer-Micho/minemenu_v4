<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [ 
        "name",
        "description", // Design for Menu
        "description_rest", // Design for Dashboard
        "description_onpay", // Design for After Selecting Plan
        "cost",
        "duration",
        "exchange_rate",
        "priority",
        "status",
        "valid_date",
    ];


    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'description_rest' => 'array',
        'description_onpay' => 'array',
    ];
}
