<?php

namespace App\Models\Gateaway;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected  $fillable = [
        'subscription_id',
        'user_id',
        'plan_id',
        'card_data',
        'transactions_data',
        'result',
    ];

    protected $casts = [
        'transactions_data' => 'array',
        'card_data' => 'array',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
