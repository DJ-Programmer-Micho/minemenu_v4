<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUsers extends Model
{
    use HasFactory;
    protected $table = 'top_users';
    protected $fillable = [
        'menus_id',
    ];

    protected $casts = [
        'menus_id' => 'array',
    ];
}
