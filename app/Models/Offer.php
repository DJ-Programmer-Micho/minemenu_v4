<?php

namespace App\Models;

use App\Models\Offer_Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'img',
        'status',
        'price',
        'old_price',
        'priority',
    ];

    public function translation()
    {
        return $this->hasOne(Offer_Translator::class,'offer_id')->withDefault();
    }
}
