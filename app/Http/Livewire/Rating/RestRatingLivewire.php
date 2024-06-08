<?php

namespace App\Http\Livewire\Rating;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use App\Models\RestRating;
class RestRatingLivewire extends Component
{
    public $staff = 0;
    public $service = 0;
    public $environment = 0;
    public $experience = 0;
    public $cleaning = 0;
    public $note = null;
    public $phone = '';
    public $restName;

    public $flagNumber = false;
    public $flagRate = false;


    public function mount($restName){
        $this->restName = $restName;
    }

    public function setRating($category, $value)
    {
        $this->$category = $value;
    }

    public function submitRestRating()
    {
        if($this->staff == 0 || $this->service == 0 || $this->environment == 0 || $this->experience == 0 || $this->cleaning == 0 || $this->phone == "" ) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('please fill all data')]);
            return;
        }

        // PROTECTED
        try {
            $userProfile = User::where('name', $this->restName)->first();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong')]);
        }
        // PROTECTED

        $existingNumber = Customer::where('phone', $this->phone)->first();

        if($existingNumber){
            $this->flagNumber = true;
        } else {
            $this->flagNumber = false;
        }
        
        if ($existingNumber == false) {
            $this->emit('hideRate');
            $data = [   
                'type' => 'restaurant',
                'restId' => $userProfile->id,
                'staff' => $this->staff,
                'service' => $this->service,
                'environment' => $this->environment,
                'experience' => $this->experience,
                'cleaning' => $this->cleaning,
                'note' => $this->note ?? null,
                'phone' => $this->phone,
            ];
            $this->emit('showAddCustRateModal',$data);
            return;
        }

        $existingRating = RestRating::where('customer_id', $existingNumber->id)->where('user_id', $userProfile->id)->first();
        if($existingNumber){
            $this->flagRate = true;
        } else {
            $this->flagRate = false;
        }

        if ($existingRating == true) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Already Rated')]);
            return;
        }
        
        RestRating::create([
            'customer_id' => $existingNumber->id,
            'user_id' =>$userProfile->id,
            'staff' => $this->staff,
            'service' => $this->service,
            'environment' => $this->environment,
            'experience' => $this->experience,
            'cleaning' => $this->cleaning,
            'note' => $this->note ?? null,
        ]);

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Thank you for your rating!')]);
        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetModal(){
        $this->staff = 0;
        $this->service = 0;
        $this->environment = 0;
        $this->experience = 0;
        $this->cleaning = 0;
        $this->note = null;
        $this->phone = '';
    }

    public function render()
    {
        return view('dashboard.livewire.rating.rest-rating-livewire');
    }
}