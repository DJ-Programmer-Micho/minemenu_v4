<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\Food_Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;

    protected $casts = [
        'options'=>'array',
    ];

    protected $table = 'food';
    protected $fillable = [
        'name',
        'description',
        'img',
        'status',
        'special',
        'sorm',
        'price',
        'old_price',
        'cat_id',
        'priority',
        'user_id',
        'options',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class,'cat_id')->withDefault();;
    }

    public function translation()
    {
        return $this->hasOne(Food_Translator::class,'food_id')->withDefault();
    }
    public function foodRatings()
{
    return $this->hasMany(FoodRating::class, 'food_id');
}

}
