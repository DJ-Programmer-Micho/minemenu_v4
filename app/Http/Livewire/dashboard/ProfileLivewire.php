<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\User;
use App\Models\Plan;
use App\Models\Tracker;
use Livewire\Component;
// use Livewire\WithPagination;
use App\Models\Categories;
use App\Models\TrackFoods;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class ProfileLivewire extends Component
{
    public $glang;
    public $filteredLocales;
    public $profile = [];

    public $old_pass;
    public $new_pass;
    public $confirm_pass;
    public $successMessage;

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');

        if (Auth::check()) {
            // dd(auth()->user()->profile);
            $this->profile['avatar'] = app('cloudfront') . (auth()->user()->settings->background_img_avatar ?? 'mine-setting/user.png');
            $this->profile['restName'] = auth()->user()->name;
            $this->profile['name'] = auth()->user()->profile->fullname;
            $this->profile['email'] = auth()->user()->email;
            $this->profile['phone'] = auth()->user()->profile->phone;
            $this->profile['country'] = auth()->user()->profile->country;
            $this->profile['create'] = auth()->user()->subscription->start_at;
            $this->profile['expire'] = auth()->user()->subscription->expire_at;
            $this->profile['plan_id'] = auth()->user()->subscription->plan_id;
            $plan_name = Plan::where('id',  auth()->user()->subscription->plan_id)
            ->first();

            $this->profile['plan_name'] = $plan_name->name[$this->glang];
        }
    }

    protected function rules()
    {
        $rules = [];
        $rules['old_pass'] = ['required'];
        $rules['new_pass'] = ['required'];
        $rules['confirm_pass'] = ['required'];
        return $rules;
    }
    public function changePassword()
    {
        $validatedData = $this->validate();

        $userValidate = auth()->user();
        if(Hash::check($validatedData['old_pass'], $userValidate->password)){
            if($validatedData['new_pass'] == $validatedData['confirm_pass']){
                $new_password = Hash::make($validatedData['new_pass']);
                User::where('id', $userValidate->id)->update([
                    'password' => $new_password,
                ]);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Password Updated')]);
                $this->reset(['old_pass', 'new_pass', 'confirm_pass']);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('The New Password is not matching the Confirm Password')]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('The Old Password is not correct')]);
        }
    }
    

    public function render()
    {
        return view('dashboard.livewire.profile-view',[
            'profile' => $this->profile
        ]);
    }
}