<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'address',
        'phone',
        'brand_type',
        'country',
        'state',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
