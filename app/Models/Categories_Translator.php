<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories_Translator extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'name',
        'locale',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class,'cat_id')->withDefault();
    }
}
