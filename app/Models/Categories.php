<?php

namespace App\Models;

use App\Models\Mainmenu;
use App\Models\Categories_Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'user_id',
        'menu_id',
        'priority',
        'status',
        'img',
        'cover',
    ];
    // protected $with = ['mainmenu'];


    public function mainmenu()
    {
        return $this->belongsTo(Mainmenu::class, 'menu_id')->withDefault();
    }
    public function translation()
    {
        return $this->hasone(Categories_Translator::class,'cat_id')->withDefault(); 
    }
    public function food()
    {
        return $this->hasMany(Food::class,'cat_id');
    }
}
