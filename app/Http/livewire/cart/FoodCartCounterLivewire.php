<?php
 
namespace App\Http\Livewire\cart;
 

use App\Models\Food;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodCartCounterLivewire extends Component
{
    protected $listeners = [
        'cart_updated' => 'render',
        'check-go' => 'refreshQuantity'
    ];

    public $food;
    public array $quantity = [];
    public $selectedSizeOption;
    public $selectedSizeOptionIndex;
    public $foodAction;
    public $setting;
    public $glang;
    public $quantity_f = [];
    public $previewQuantity = [];
    

    public function mount($foodcartdata, $setting ,$glang){
        $this->foodAction = $foodcartdata;
        $this->setting = $setting;
        $this->glang = $glang;

        // GET THE VALUES
        foreach (Cart::content() as $cartItem) {
            $rowId = $cartItem->id;
            if ($cartItem->options['sorm'] == 0) {
                if ($rowId) {
                    $this->quantity[$rowId] = $cartItem->qty;
                } else {
                    $this->quantity[$rowId] = 0;
                }
            } else {
                if ($rowId) {
                    $this->quantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = $cartItem->qty;
                    // $this->previewQuantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = $cartItem->qty;
                } else {
                    $this->quantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = 0;
                    // $this->previewQuantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = 0;
                }
            }
        }
    }
    public function render(){
        $cart_count = Cart::content()->count();
        $cart = Cart::content();

        return view('dashboard.livewire.food-cart-counter', 
        [
            'foodAction' => $this->foodAction,
            'settings' => $this->setting,
            'glang' => $this->glang,
            'cart_count' => $cart_count,
            'cart' => $cart
        ]
    );
    }

    //Start Main Function
    public function addToCart($food_id, $option_key, $option_index,  $check_sorm)
    {
        $existingCartItem = null;
    
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $food_id && $cartItem->options->get('size') === $option_key || $cartItem->id == $food_id) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            if($check_sorm == 0){
            // update the quantity
            $rowId = $existingCartItem->rowId;
            Cart::update($rowId, ['qty' => $this->quantity[$food_id]]);
            $this->emit('cart_updated');
            $this->emit('go-check', $food_id, $option_key, $option_index);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
        } else {
            // $rowId = $existingCartItem->rowId;

            $rowId = null;
            foreach (Cart::content() as $cartItem) {
                if ( $cartItem->options['sorm'] == 1) {
                    if( $cartItem->options['size'] == $option_key){
                     $rowId = $cartItem->rowId;
                     break;
                    }
                }
            }

            $food = Food::findOrFail($food_id);
            $options = json_decode($food->options, true);
            // $currentOptions = $options[$this->glang] ?? [];
            
            // MAIN CHILD index = en lang = 0 1
            foreach ($options as $index => $lang_option) {
                // dd($options,  $lang_option, $lang_option[$this->selectedSizeOptionIndex],$lang_option[$this->selectedSizeOptionIndex]['key']);
                if($lang_option[$this->selectedSizeOptionIndex]['key']){
                    $ars[$index] = $lang_option[$this->selectedSizeOptionIndex]['key'];
                }
            }
            
            foreach ($ars as $op) {
             
                // Check if the option key exists in $this->quantity array
                if (isset($this->quantity[$food_id][$option_index][$op])) {
                    $quantity = $this->quantity[$food_id][$option_index][$op];
                }

                if ($quantity > 0) {
                    $this->quantity_f = $quantity;
                } else {
                    Cart::remove($rowId);
                }
            }

            Cart::update($rowId, ['qty' => $this->quantity_f]);
            $this->emit('cart_updated');
            $this->emit('go-check', $food_id, $option_key, $option_index);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
        }
        
    }
}
//End Main Function
    public function increaseQuantity($food_id, $option_key, $option_index, $check_sorm)
    {
        if ($check_sorm == 0) {
                // Single food item scenario
                if (isset($this->quantity[$food_id])) {
                    $this->quantity[$food_id]++;
                    $this->addToCart($food_id, $option_key, $option_index, $check_sorm); // Call the addToCartSingle method with the updated quantity
                }
            } else {
                
                $this->selectedSizeOption = $option_key;
                $this->selectedSizeOptionIndex = $option_index;
                // Multiple-size food item scenario
                if ($this->selectedSizeOption && isset($this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption])) {
                    $this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption]++;
                    $this->addToCart($food_id, $option_key, $option_index, $check_sorm);
                }
            }
        // }
    }
    
    public function decreaseQuantity($food_id,$option_key, $option_index, $check_sorm)
    {
        if ($check_sorm == 0) {
            // Single food item scenario
            if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] > 0) {
                $this->quantity[$food_id]--;
                $this->addToCart($food_id, $option_key, $option_index, $check_sorm); // Call the addToCartSingle method with the updated quantity
            } 
        } else {
            $this->selectedSizeOption = $option_key;
            $this->selectedSizeOptionIndex = $option_index;
            // Multiple-size food item scenario
            if ($this->selectedSizeOption && isset($this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption])) {
                $this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption]--;
                $this->addToCart($food_id, $option_key, $option_index, $check_sorm);
            }
        }
    }

    public function refreshQuantity($food_id,$option_key, $option_index)
    {
        $existingCartItem = Cart::search(function ($cartItem) use ($food_id) {
            return $cartItem->id == $food_id;
        })->first();

        if ($existingCartItem) {
            $rowId = $existingCartItem->id;
            if ($existingCartItem->options['sorm'] == 0) {
                if ($rowId) {
                    $this->quantity[$rowId] = $existingCartItem->qty;
                } else {
                    $this->quantity[$rowId] = 0;
                }
            } else {
                foreach (Cart::content() as $cartItem) {
                    if ( $cartItem->options['sorm'] == 1) {
                        if( $cartItem->options['size'] == $option_key){
                         $existingCartItem = $cartItem;
                         break;
                        }
                    }
                }
                if ($rowId) {
                    $this->quantity[$rowId][$option_index][$option_key] = $existingCartItem->qty;
                    // $this->previewQuantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = $cartItem->qty;
                } else {
                    $this->quantity[$rowId][$option_index][$option_key] = 0;
                    // $this->previewQuantity[$rowId][$cartItem->options['sizeindex']][$cartItem->options['size']] = 0;
                }
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Something Went Wrong!')]);
        }
    }
} 