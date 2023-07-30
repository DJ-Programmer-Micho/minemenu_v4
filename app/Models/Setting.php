<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_lang',
        'languages',
        'phone',
        'wifi',
        'facebook',
        'instagram',
        'website',
        'telegram',
        'snapchat',
        'note',
        'map',
        'tiktok',
        'background_img',
        'background_vid',
        'intro_page',
        'currency',
        'fees',
    ];

    protected $casts = [
        'languages' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function translations()
    {
        return $this->hasMany(SettingTranslation::class);
    }
}
