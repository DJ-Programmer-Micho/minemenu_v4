<?php

namespace App\Http\Livewire\Rating;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use App\Models\FoodRating;
use App\Models\RestRating;

class FoodRatingLivewire extends Component
{
    public $glang;
    public $food = 0;
    public $foodId;
    public $restName;
    public $review;
    public $phone = '';
    public $avg = 0;

    public $flagNumber = false;
    public $flagRate = false;


    public function mount($glang, $restName)
    {
        $this->glang = $glang;
        $this->restName = $restName;
    
       
    }

    public function foodSetRating($category, $value)
    {
        $this->$category = $value;
        $this->avg = $value;
    }


    public function submitFoodRating()
    {
    
        if($this->avg == 0 || $this->phone == "" ) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('please fill all data')]);
            return;
        }

        $existingNumber = Customer::where('phone', $this->phone)->first();

        if($existingNumber){
            $this->flagNumber = true;
        } else {
            $this->flagNumber = false;
        }
        
        if ($existingNumber == false) {
            $this->emit('hideRate');
            $dataFood = [   
                'type' => 'food',
                'foodId' => $this->foodId,
                'phone' => $this->phone,
                'avg' => $this->avg,
            ];
            $this->emit('showAddCustRateFoodModal',$dataFood);
            return;
        }

        $existingRating = FoodRating::where('customer_id', $existingNumber->id)->where('food_id', $this->foodId)->first();
        if($existingNumber){
            $this->flagRate = true;
        } else {
            $this->flagRate = false;
        }

        if ($existingRating == true) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Already Rated')]);
            return;
        }
        FoodRating::create([
            'customer_id' => $existingNumber->id,
            'food_id' => $this->foodId,
            'rating' => $this->avg,
        ]);

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Thank you for your rating!')]);
        $this->resetModal();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetModal(){
        $this->food = 0;
        $this->foodId = '';
        $this->phone = '';
        $this->avg = 0;
    }

    public function render()
    {
        return view('dashboard.livewire.rating.food-rating-livewire');
    }
}