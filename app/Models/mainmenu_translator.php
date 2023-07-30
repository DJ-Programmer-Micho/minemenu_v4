<?php

namespace App\Models;

use App\Models\Mainmenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mainmenu_Translator extends Model
{
    use HasFactory;
    protected $table = 'mainmenu_translators';
    protected $fillable = [
        'menu_id',
        'name',
        'locale',
    ];

    // Define the inverse relationship with the Setting model
    public function minemenu()
    {
        return $this->belongsTo(Mainmenu::class, 'menu_id')->withDefault();
    }
}
