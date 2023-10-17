<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanChange extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'plan_changes';
    protected $fillable = [
        'user_id',
        'old_plan_id',
        'new_plan_id',
        'action',
        'change_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

