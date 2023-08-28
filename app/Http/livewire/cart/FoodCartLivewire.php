<?php
 
namespace App\Http\Livewire\cart;
 
use Livewire\Component;

class FoodCartLivewire extends Component
{
    public $foodAction;
    public $setting;
    public $glang;
    public function mount($foodcartdata, $setting, $glang){
        $this->foodAction = $foodcartdata;
        $this->setting = $setting;
        $this->glang = $glang;
    }
    public function render(){
        return view('dashboard.livewire.food-cart', [
            'foodAction' => $this->foodAction,
            'settings' => $this->setting,
            'glang' => $this->glang
        ]);
    }
} 