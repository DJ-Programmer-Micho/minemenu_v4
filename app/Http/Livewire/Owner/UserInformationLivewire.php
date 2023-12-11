<?php
 
namespace App\Http\Livewire\Owner;

use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
use App\Models\Setting;
use Livewire\Component;
use App\Models\PlanChange;
use App\Models\Subscription;
use Livewire\WithPagination;
use App\Exports\UsersDataExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\owner\TelegramRegisterNew;
use App\Notifications\owner\TelegramRegisterUpdate;
use App\Notifications\owner\TelegramPlanChangeNew;
use App\Notifications\owner\TelegramPlanChangeUpdate;
 
class UserInformationLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $glang;
    public $filteredLocales;
    public $defualt_img;
    public $defualt_link;
    public $general_link;
    // Filters
    public $countryFilter = null;
    public $planFilter = null;
    public $searchFilter = null;
    public $dateRange = null;
    public $planSelect = null;
    //Form Data
    public $r_id;
    public $add_plan_id;
    public $add_fullname;
    public $add_businessname;
    public $add_email;
    public $add_password;
    public $add_country;
    public $add_state;
    public $add_phone;
    public $add_address;
    public $add_type = [];
    public $add_language = [];
    public $tele_id;
    //data
    public $brand_type = [
        'Restaurant',
        'Cafe',
        'Hotel',
        'Spa',
        'Resurt',
        'Food Truck',
        'Other',
    ];
    public $languages = [
        'en',
        'ar',
        'ku',
        'de',
        'it',
        'fr',
        'es',
    ];

    protected $listeners = [
        'dateRangeSelected' => 'applyDateRangeFilter',
        'updateCroppedAvatarImg' => 'handleCroppedImage',
    ];

    public function export($planFilter_send,$searchFilter_send,$dateRange_send,$countryFilter_send){
        return Excel::download(new UsersDataExport($planFilter_send,$searchFilter_send,$dateRange_send,$countryFilter_send), 'usersData.xlsx');
    }

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->defualt_img = app('no_uknown_user');
        $this->defualt_link = app('cloudfront');
        $this->general_link = env('APP_URL');
        $this->tele_id = env('TELEGRAM_GROUP_ID');
        $this->planSelect = $this->planSelectFilter();

    }
    //NEW
    public function resetFilter(){
        $this->planFilter = '';
        $this->searchFilter = '';
        $this->dateRange = '';
        $this->countryFilter = '';
    } // END OF FUNCTION RESETING FILTER

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

    private function planSelectFilter(){
        return Plan::get();
    }

    public $countUsers;
    private function userInformationGet()
    {
        if (Auth::check()) {
            try {
                $userInformationGetQuery = User::with(['profile', 'settings','subscription'])
                ->where('role', 3)
                ->orderBy('created_at', 'DESC');

                // Apply filters
                if ($this->planFilter != '') {
                    $userInformationGetQuery->whereHas('subscription', function ($query) {
                        $query->where('plan_id', $this->planFilter);
                    });
                }

                if ($this->countryFilter != '') {
                    $userInformationGetQuery->whereHas('profile', function ($query) {
                        $query->where('country', $this->countryFilter);
                    });
                }
    
                if ($this->searchFilter != '') {
                    // Apply category filter to user->name
                    $userInformationGetQuery->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->searchFilter . '%')
                            ->orWhereHas('profile', function ($subquery) {
                                $subquery->where('fullName', 'like', '%' . $this->searchFilter . '%');
                            })->orWhereHas('profile', function ($subquery) {
                                $subquery->where('country', 'like', '%' . $this->searchFilter . '%');
                            })->orWhereHas('profile', function ($subquery) {
                                $subquery->where('address', 'like', '%' . $this->searchFilter . '%');
                            });
                    });
                }
    
                if ($this->dateRange) {
                    list($startDate, $endDate) = explode(' - ', $this->dateRange);
                    $userInformationGetQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                $this->countUsers = $userInformationGetQuery->count();
                $finalSummry = $userInformationGetQuery->paginate(5);    
                // dd($finalSummry);
                return $finalSummry;
            } catch (\Exception $e) {
                // Handle exceptions here
            }
        }
    }
    public function checkDashboard($url)
    {
        $tempUser = User::where('id', $url)->first();
        $this->emit('clicked', $tempUser->name, 'aaaaaaaaa');
    }

    //Add User
    public $objectName;
    public $tempImg;
    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/menu/1' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $this->tempImg = $base64data;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }
    public function addRegister(){
        try{

            $formFields = [];
            $formFields = [
                'name' => $this->add_businessname,
                'fullname' => $this->add_fullname,
                'email' => $this->add_email,
                'password' => $this->add_password,
                'phone' => $this->add_phone,
                'country' => $this->add_country,
                'state' => $this->add_state,
                'address' => $this->add_address,
            ];
            
            $formFields['brand_type'] = implode(',', $this->add_type) ?? null;
            
            $formFields['languages'] = $this->add_language ?? ["en"];
            // dd( $formFields['languages']);
            $formFields['status'] = '1';
            $formFields['role'] = 3;
            $formFields['default_lang'] = 'en';
            $formFields['ui_ux'] = "[\"01\",\"01\",\"01\",\"02\",\"01\",\"01\",\"01\",\"01\"]";
            $formFields['email_verified'] = 1;
            $formFields['phone_verified'] = 1;
            $formFields['background_img_avatar'] = $this->objectName;
            
            $formFields['g_pass'] = env('RSA_KEY');
            $formFeilds = collect($formFields);
            
            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));
                    Storage::disk('s3')->put($this->objectName, $croppedImage);
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Image Did not Upload, CODE...CAT-ADD-IMG')]);
                    // return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
            }
            
            // dd($formFeilds);
            $user = User::create($formFeilds->only('name','email','password','g_pass','role','status','email_verified','phone_verified')->toArray());
            $user->profile()->create($formFeilds->only('fullname','state','country','address','phone','brand_type')->toArray());
            $user->settings()->create($formFeilds->only('default_lang','languages','ui_ux','background_img_avatar')->toArray());


            $newId = User::where('name', $formFields['name'])->first();
            $plan = Plan::find($this->add_plan_id);

            Subscription::Create([
                'user_id' => $newId->id,
                'plan_id' => $plan->id,
                'start_at' => now(),
                'expire_at' => now()->addDays($plan->duration),
                'renew_at' => now()->addDays($plan->duration),
                'status' => 1,
            ]);
            $temp = Subscription::where('user_id', $newId->id)->first();
            $old_plan = $temp->plan_id ?? 1;
            
            PlanChange::Create([
                'user_id' => $newId->id,
                'old_plan_id' => $old_plan,
                'new_plan_id' => $this->add_plan_id,
                'action' => 'Manually',
                'change_date' => now(),
            ]);
            try{
                $this->r_id = $newId->id;
                Notification::route('toTelegram', null)
                ->notify(new TelegramRegisterNew(
                    $this->r_id,
                    $formFields['name'],
                    $formFields['email'],
                    $formFields['fullname'],
                    $formFields['phone'],
                    $formFields['country'],
                    'Manually',
                    $this->tele_id
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
            try{
                $this->r_id = $newId->id;
                Notification::route('toTelegram', null)
                ->notify(new TelegramPlanChangeNew(
                    $this->r_id,
                    $formFields['name'],
                    $formFields['fullname'],
                    $formFields['email'],
                    $formFields['phone'],
                    $old_plan,
                    $this->add_plan_id,
                    'Manually',
                    $this->tele_id
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Register Added Successfully')]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while adding new User.')]);
        }
    } // END Function (Register)
    
    public $user_update;
    public $has_type = [];
    public $has_language = [];
    public $imgReader;
    // Edit
    public $email_verified;
    public $phone_verified;
    public $status;
    public $expire_at;
    ////////////////////////////////////////
    // OLD VALUES FOR CHECKING PURPOSES
    public $container_old_data;
    // END CHECKING VARIABLES
    public function editUser(int $user_selected){
        $this->tempImg = null;
        $this->imgReader = null;
        $user_edit = User::findOrFail($user_selected);
        // $user_edit = User::find($user_selected);
        $this->user_update = $user_edit;

        $this->add_plan_id = $user_edit->subscription->plan_id;
        $this->add_businessname = $user_edit->name;
        $this->add_fullname = $user_edit->profile->fullname;
        $this->add_email = $user_edit->email;
        $this->add_password = '';
        $this->add_phone = $user_edit->profile->phone;
        $this->add_country = $user_edit->profile->country;
        $this->add_state = $user_edit->profile->state;
        $this->add_address = $user_edit->profile->address;
        $this->has_type = explode(',', $user_edit->profile->brand_type) ?? [];
        $this->has_language = $user_edit->settings->languages ?? [];
        $this->imgReader = $user_edit->settings->background_img_avatar;

        $this->container_old_data = [];
        $this->container_old_data = [
            'old_add_plan_id' => $user_edit->subscription->plan_id,
            'old_add_businessname' => $user_edit->name,
            'old_add_fullname' => $user_edit->profile->fullname,
            'old_add_email' => $user_edit->email,
            'old_add_password' => '',
            'old_add_phone' => $user_edit->profile->phone,
            'old_add_country' => $user_edit->profile->country,
            'old_add_state' => $user_edit->profile->state,
            'old_add_address' => $user_edit->profile->address,
            'old_has_type' => explode(',', $user_edit->profile->brand_type) ?? [],
            'old_has_language' => $user_edit->settings->languages ?? [],
            'old_imgReader' => $user_edit->settings->background_img_avatar,
        ];
    }

    public function updateUser(){
        try{
            
            // dd($this->container_old_data);
            if($this->objectName == null){
                $this->objectName = $this->imgReader;
                $this->tempImg = $this->imgReader;
            } 
            
            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));
                    
                    if( $this->imgReader){
                        Storage::disk('s3')->delete($this->imgReader);
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    } else {
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...USR-ADD-IMG')]);
                    return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
            }
            
            User::where('id', $this->user_update->id)->update([
                'name' => $this->add_businessname,
                'email' => $this->add_email,
                'password' => isset($this->add_password) ? $this->add_password : null,
            ]);
            
            Profile::where('user_id', $this->user_update->id)->update([
                'fullname' => $this->add_fullname,
                'phone' => $this->add_phone,
                'address' => $this->add_address,
                'country' => $this->add_country,
                'state' => $this->add_state,
                'brand_type' => isset($this->add_password) ? $this->add_password : null,
            ]);
            
            Setting::where('user_id', $this->user_update->id)->update([
                'languages' => $this->has_language,
                'background_img_avatar' => isset($this->objectName) ? $this->objectName : $this->imgReader,
            ]);
            
            try{
                $this->r_id = $this->user_update->id;
                Notification::route('toTelegram', null)
                ->notify(new TelegramRegisterUpdate(
                    $this->r_id,
                    $this->add_businessname,
                    $this->add_email,
                    $this->add_fullname,
                    $this->add_phone,
                    $this->add_country,
                    'Manually',
                    $this->container_old_data
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('User Updated Successfully')]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while updating the User.')]);
        }
    }
    public $container_old_module;
    public function moduleUser(int $user_selected){
        $this->imgReader = null;
        
        $user_edit = User::findOrFail($user_selected);
        $this->user_update = $user_edit;

        $this->email_verified = $user_edit->email_verified;
        $this->phone_verified = $user_edit->phone_verified;
        $this->status = $user_edit->status;
        $this->expire_at = $user_edit->subscription->expire_at;
        $this->add_plan_id = $user_edit->subscription->plan_id;


        $this->container_old_module = [];
        $this->container_old_module = [
            'email_verified_old' => $user_edit->email_verified,
            'phone_verified_old' => $user_edit->phone_verified,
            'status_old' => $user_edit->status,
            'expire_at_old' => $user_edit->subscription->expire_at,
            'add_plan_id_old' => $user_edit->subscription->plan_id,
        ];
    }
    //DYNAMIC FUNCTION !!!
    public function updatedAddPlanId($value)
    {
        $plan = Plan::find($value);
        $this->expire_at = now()->addDays($plan->duration)->format('Y-m-d\TH:i');
    }
    public function updateModuleUser(){
        try{
            $this->imgReader = null;
            $user_edit = $this->user_update;
            $this->user_update = $user_edit;
            $this->email_verified = $this->email_verified;
            $this->phone_verified = $this->phone_verified;
            $this->status = $this->status;
            $this->expire_at = $this->expire_at;

            $plan = Plan::find($this->add_plan_id);
// dd( $user_edit->id);
            User::where('id', $this->user_update->id)->update([
                'email_verified' => $this->email_verified,
                'phone_verified' => $this->phone_verified,
                'status' => $this->status,
            ]);

            Subscription::where('user_id', $this->user_update->id)->update([
                'plan_id' => $plan->id,
                'start_at' => now(),
                'expire_at' => isset($this->expire_at) ? $this->expire_at : now()->addDays($plan->duration),
                'renew_at' => isset($this->expire_at) ? $this->expire_at : now()->addDays($plan->duration),
                'status' => 1,
            ]);
            $temp = Subscription::where('user_id', $user_edit)->first();
            $old_plan = $temp->plan_id ?? 1;
            
            PlanChange::Create([
                'user_id' => $user_edit->id,
                'old_plan_id' => $old_plan,
                'new_plan_id' => $this->add_plan_id,
                'action' => 'Manually',
                'change_date' => now(),
            ]);


    
            try{
                Notification::route('toTelegram',null)
                ->notify(new TelegramPlanChangeUpdate(
                    $this->user_update->id,

                    $this->user_update->name,
                    $this->user_update->email,
                    $this->user_update->profile->fullname,
                    $this->user_update->profile->phone,

                    $this->email_verified = $this->email_verified,
                    $this->phone_verified = $this->phone_verified,
                    $this->status = $this->status,
                    $this->expire_at = $this->expire_at,

                    $this->add_plan_id,

                    'Manually',
                    $this->tele_id,

                    $this->container_old_module
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }



            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('User Module Updated Successfully')]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while updating the User Module.')]);
        }
    }

    public function updateStatus(int $user_id)
    {
        $menuState = User::find($user_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public function infoUser(int $user_selected){
        $user_edit = User::findOrFail($user_selected);
        $this->user_update = $user_edit;
        $this->add_fullname = $user_edit->profile->fullname;
        $this->add_email = $user_edit->email;
        $this->add_phone = $user_edit->profile->phone;
    }
    ////QUICK ACTIONS
    public function closeModal()
    {
        $this->resetInput();
    } // END FUNCTION OF CLOSE MODAL
        public function resetInput()
    {
        $this->add_plan_id = '';
        $this->add_businessname = '';
        $this->add_fullname = '';
        $this->add_email = '';
        $this->add_password = '';
        $this->add_phone = '';
        $this->add_country = '';
        $this->add_state = '';
        $this->add_address = '';
        $this->has_type = [];
        $this->has_language = [];
        $this->imgReader = false;
        $this->objectName = '';
        $this->tempImg = null;
        $this->user_update = '';
        $this->add_fullname = '';
        $this->add_email = '';
        $this->add_phone ='';
    } // END FUNCTION OF RESET INPUT
    public function render()
    {
        $plans = Plan::get();
        $planNames = [];
        
        foreach ($plans as $plan) {
            $planNames[$plan->id] = $plan->name['en'] ?? 'Error';
        }

        $uniqueCountries = Profile::distinct()->pluck('country')->filter()->values()->toArray();

        $finalSummry = $this->userInformationGet();
        $cols_th = ['#', 'User ID', 'Business Name','Avatar','Auther' ,'current', 'country','Status','Email Verified','SMS Verified','Registered','Expire Date','Action'];
        $cols_td = ['id', 'user_id', 'name','author' ,'background_img_avatar','plan_id', 'country','status','email_verified','phone_verified','created_at','expire_at','Action'];

        return view('dashboard.livewire.owner.user-information-table',[
            'items' => $finalSummry, 
            'planNames' => $planNames,
            'default_link' => $this->defualt_link,
            'default_img_table' => $this->defualt_img,
            'general_link' => $this->general_link,
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            //Filters
            'counter' => $this->countUsers ?? null,
            'countryData' => $uniqueCountries ?? null,
            // Filter Send
            'countryFilter_send' => $this->countryFilter ?? null,
            'planFilter_send' => $this->planFilter ?? null,
            'searchFilter_send' => $this->searchFilter ?? null,
            'dateRange_send' => $this->dateRange ?? null,
            'imgReader2' => $this->imgReader ? $this->defualt_link.$this->imgReader : null,
            //form
            'brand_type' => $this->brand_type,
            'languages' => $this->languages,
            'default_img' => $this->defualt_link.$this->defualt_img,
            'has_type' => $this->has_type ?? [],
            'has_language' => $this->has_language ?? [],
        ]);
    }
}