<?php
 
namespace App\Http\Livewire\cart;
 
use App\Models\Food;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodCartLivewire extends Component
{
    public $food;
    public array $quantity = [];

    public $foodAction;
    public $setting;
    public $glang;
    public function mount($foodcartdata, $setting ,$glang){
        $this->foodAction = $foodcartdata;
        $this->setting = $setting;
        $this->glang = $glang;


        $existingCartItem = null;

        // GET THE VALUES
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $foodcartdata->id) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            $rowId = $existingCartItem->rowId;
            $cartItem = Cart::get($rowId);
            $this->quantity[$foodcartdata->id] = $cartItem ? $cartItem->qty : 0; 
        }
    }

    public function render(){

        $cart = Cart::content();

        return view('dashboard.livewire.food-cart', 
        [
                'foodAction' => $this->foodAction,
                'settings' => $this->setting,
                'glang' => $this->glang,
                'cart' => $cart,
            ]);

    }

    public function addToCart($food_id)
    {
        $existingCartItem = null;
    
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $food_id) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            // update the quantity
            $rowId = $existingCartItem->rowId;
            // dd($cartItem,$rowId, $this->quantity[$food_id]);
            // Cart::update($rowId, $this->quantity[$food_id]);
            Cart::update($rowId, ['qty' => $this->quantity[$food_id]]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
            $this->emit('cart_updated');
        } else {
            // add new food
            $food = Food::findOrFail($food_id);
            Cart::add(
                $food->id,
                $food->translation->name,
                $this->quantity[$food_id],
                $food->price,
                ['img' => $food->img]
                
            );
    
            $this->emit('cart_updated');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Cart Food Inserted')]);
        }
    }

    public function increaseQuantity($food_id)
    {
        if (isset($this->quantity[$food_id])) {
            $this->quantity[$food_id]++;
            $this->addToCart($food_id); // Call the addToCart method with the updated quantity
        }
    }
    
    public function decreaseQuantity($food_id)
    {
        if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] > 1) {
            $this->quantity[$food_id]--;
            $this->addToCart($food_id); // Call the addToCart method with the updated quantity
        }
    }
    
    

    // public function removeFromCart($rowId)
    // {
    //     Cart::remove($rowId);
    //     $this->emit('cart_updated');
    // }
} 