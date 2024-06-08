<?php

namespace App\Http\Livewire\Rating;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use App\Models\FoodRating;
use App\Models\RestRating;
use Illuminate\Http\Request;

class CustomerDataRatingLivewire extends Component
{
    public $firstName = '';
    public $lastName = '';
    public $dob = '';
    // Combine Data
    public $type;
    public $phone;
    // Extra Data V1
    public $foodId;
    public $avg;
    // Extra Data V2
    public $staff;
    public $service;
    public $environment;
    public $experience;
    public $cleaning;
    public $note;

    public $restId;

    protected $listeners = [
        'sendData' => 'getData',
    ];

    public function getData($data)
    {
        $this->type = $data['type'];
        $this->phone = $data['phone'];
        if ($this->type == 'restaurant') {
            $this->restId = $data['restId'];
            $this->staff = $data['staff'];
            $this->service = $data['service'];
            $this->environment = $data['environment'];
            $this->experience = $data['experience'];
            $this->cleaning = $data['cleaning'];
            $this->note = $data['note'] ?? null;
        } elseif ($this->type == 'food') {
            $this->foodId = $data['foodId'];
            $this->avg = $data['avg'];
        }
    }

    public function submitCustomerData()
    {

        if ($this->type == 'restaurant') { 
            if($this->staff == 0 || $this->service == 0 || $this->environment == 0 || $this->experience == 0 || $this->cleaning == 0 || $this->phone == ""  || $this->firstName == '' || $this->lastName == '' || $this->dob == '') {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('please fill all data')]);
                return;
            
        } else {
            $customer = Customer::create([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'dob' => $this->dob,
                'phone' => $this->phone,
            ]);

            RestRating::create([
                'customer_id' => $customer->id,
                'user_id' => $this->restId,
                'staff' => $this->staff,
                'service' => $this->service,
                'environment' => $this->environment,
                'experience' => $this->experience,
                'cleaning' => $this->cleaning,
                'note' => $this->note ?? null,
            ]);
        }
        } else {
            if( $this->foodId == '' || $this->phone == ""  || $this->firstName == '' || $this->lastName == '' || $this->dob == '' || $this->avg == 0) { 
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('please fill all data')]);
                return;
            } else {
                $customer = Customer::create([
                    'first_name' => $this->firstName,
                    'last_name' => $this->lastName,
                    'dob' => $this->dob,
                    'phone' => $this->phone,
                ]);


                FoodRating::create([
                    'customer_id' => $customer->id,
                    'food_id' => $this->foodId,
                    'rating' => $this->avg,
                ]);
            }
        }

        $customer->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Thank you for your rating!')]);
        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetModal(){
        $this->firstName = '';
        $this->lastName = '';
        $this->phone = '';
        $this->dob = '';
    }

    public function render()
    {
        return view('dashboard.livewire.rating.customer-rating-livewire');
    }
}