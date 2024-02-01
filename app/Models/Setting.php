<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
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
        'telegram_notify',
        'telegram_notify_status',
        'cart_status',
        'background_img',
        'background_vid',
        'background_img_header',
        'background_img_avatar',
        'intro_page',
        'currency',
        'fees',
        'ui_ux',
        'ui_color',
        'user_ui_color',
    ];

    protected $casts = [
        'languages' => 'array',
        'ui_ux' => 'array',
        'user_ui_color' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function translations()
    {
        return $this->hasMany(Setting_Translation::class);
    }
}
