<?php
 
namespace App\Http\Livewire\cart;
 

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodCartCounterLivewire extends Component
{
    protected $listeners = ['cart_updated' => 'render'];

    public function render(){
        $cart_count = Cart::content()->count();
        $cart = Cart::content();

        return view('dashboard.livewire.food-cart-counter', compact('cart_count','cart'));
    }
} 