<?php
 
namespace App\Http\Livewire\cart;
 
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class FoodCartCounterLivewire extends Component
{
    protected $listeners = ['cart_updated' => 'render'];

    // public $foodAction;
    // public $setting;
    // public $glang;
    // public function mount($foodcartdata, $setting, $glang){
    //     $this->foodAction = $foodcartdata;
    //     $this->setting = $setting;
    //     $this->glang = $glang;
    // }
    public function render(){
        $cart_count = Cart::content()->count();
        return view('livewire.cart-counter', compact('cart_count'));
    }
} 