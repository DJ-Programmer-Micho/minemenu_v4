<?php
 
namespace App\Http\Livewire\cart;
 
use App\Models\Food;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodQuantityHandleLivewire extends Component
{
    public $quantity = 0;
    public $foodId;

    protected $listeners = ['quantityUpdated'];

    public function mount($foodId, $existingQuantity)
    {
        $this->foodId = $foodId;
        $this->quantity = $existingQuantity;
    }

    public function increaseQuantity()
    {
        $this->quantity++;
        $this->emitQuantityUpdated();
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->emitQuantityUpdated();
        }
    }

    public function addToCart()
    {
        $this->emit('addToCart', $this->foodId, $this->quantity);
    }

    public function emitQuantityUpdated()
    {
        $this->emit('quantityUpdated', $this->foodId, $this->quantity);
    }

    public function render()
    {
        return view('livewire.quantity-input');
    }
} 