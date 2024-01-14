<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $table = 'ads';
    protected $fillable = [
        'name',
        'redirect_url',
        'qr_code',
        'scans',
        'status',
        'vision',
    ];

}
