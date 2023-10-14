<?php

namespace App\Models\Gateaway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    const  AREEBA_PAYMENT = 1;
    const  ZAINCASH_PAYMENT = 2;
}
