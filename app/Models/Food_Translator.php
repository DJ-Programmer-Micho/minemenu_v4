<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food_Translator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'food_id',
        'locale',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class,'food_id')->withDefault();
    }
}
