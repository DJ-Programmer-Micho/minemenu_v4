<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_Translator extends Model
{
    use HasFactory;

    protected $table = 'offer_translators';
    protected $fillable = [
        'name',
        'description',
        'offer_id',
        'lang',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class,'offer_id')->withDefault();
    }
}
