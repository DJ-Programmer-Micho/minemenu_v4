<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function subscribe($plan_id, $exp){

        if($plan_id){
            $plan = Plan::findOrFail($plan_id);
            $this->subscription()->updateOrCreate(
                 ['user_id'=>$this->id,'status'=>'1']
                ,[
                'status' => '1',
                'plan_id' => $plan_id,
                'start_at' => now(),
                'expire_at' => !$exp ? now()->addDays($plan->duration) : $exp,
            ]);
        }else{
            $this->subscription()->create([
                'status' => 1,
            ]);
        }

    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class,'user_id')->where('status',1);
    }
}
