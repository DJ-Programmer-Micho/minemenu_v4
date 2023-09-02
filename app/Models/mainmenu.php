<?php

namespace App\Models;

use App\Models\User;
use App\Models\Mainmenu_Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mainmenu extends Model
{
    use HasFactory;
    protected $table = 'mainmenus';
    protected $fillable = [
        'user_id',
        'priority',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function translation()
    {
        return $this->hasOne(Mainmenu_Translator::class,'menu_id')->withDefault(); 
    }
}
