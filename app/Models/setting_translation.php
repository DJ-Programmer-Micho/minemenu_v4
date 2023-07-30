<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting_translation extends Model
{
    use HasFactory;

    protected $table = 'setting_translations';
    protected $fillable = [
        'rest_name',
        'address',
        'locale',
    ];

    // Define the inverse relationship with the Setting model
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
