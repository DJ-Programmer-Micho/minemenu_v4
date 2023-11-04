<?php
 
namespace App\Http\Livewire\Cart;
 
use App\Models\Food;
use App\Models\Offer;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodCartCounterLivewire extends Component
{
    protected $listeners = [
        'cart_updated' => 'render',
        'check-go' => 'refreshQuantity',
        'check-offer-go' => 'refreshOfferQuantity',
    ];

    public $food;
    public array $quantity = []; 
    public array $quantityOffer = []; 
    public $selectedSizeOption;
    public $selectedSizeOptionIndex;
    public $glang;
    public $tax;
    public $quantity_f = [];
    public $previewQuantity = [];
    

    public function mount($glang, $setting){
        $this->glang = $glang;
        $this->tax = $setting->fees;

        // GET THE VALUES
        foreach (Cart::content() as $cartItem) {
            $rowId = $cartItem->id;
            if($cartItem->options['size'] == 'offer'){
                if ($rowId) {
                    $this->quantityOffer[$rowId] = $cartItem->qty;
                } else {
                    $this->quantityOffer[$rowId] = 0;
                }
            } else {  
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
    }
    public function render(){
        $cart_count = Cart::content()->count();
        $cart = Cart::content();
        

        $data = json_decode($cart, true);

        // Initialize a variable to store the sum of subtotals
        $totalSubtotal = 0;
        
        // Loop through the data and sum the subtotals
        foreach ($data as $item) {
            $subtotal = floatval($item['subtotal']); // Convert subtotal to float
            $totalSubtotal += $subtotal;
        }
        $taxRate = $this->tax / 100;
        $grandTotal = $totalSubtotal + ($totalSubtotal * $taxRate);
        
    
        return view('dashboard.livewire.food-cart-counter', 
        [
            'glang' => $this->glang,
            'cart_count' => $cart_count,
            'cart' => $cart,
            'tax' => $this->tax,
            'totalSubtotal' => $totalSubtotal,
            'grandTotal' => $grandTotal
        ]
    );
    }

    //Start Main Function
    public function addToCart($food_id, $option_key, $option_index,  $check_sorm)
    {
        $existingCartItem = null;
    
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $food_id && $cartItem->options['size'] === $option_key || $cartItem->id == $food_id && $cartItem->options['size'] != 'offer') {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
        // if ($existingCartItem->options['size'] != 'offer') {
            


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
                if ( $cartItem->options['size'] != 'offer') {
                if ( $cartItem->options['sorm'] == 1) {
                    if( $cartItem->options['size'] == $option_key){
                     $rowId = $cartItem->rowId;
                     break;
                    }
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
                    $this->emit('go-check', $food_id, $option_key, $option_index);
                    $this->emit('cart_updated');
                    return;
                }
            }

            Cart::update($rowId, ['qty' => $this->quantity_f]);
            $this->emit('cart_updated');
            $this->emit('go-check', $food_id, $option_key, $option_index);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
        }
        




    // }
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
            if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] == 0) {
                return;
            } else {
                if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] > 0) {
                    $this->quantity[$food_id]--;
                    $this->addToCart($food_id, $option_key, $option_index, $check_sorm); // Call the addToCartSingle method with the updated quantity
                } 
            }
        } else {
            $this->selectedSizeOption = $option_key;
            $this->selectedSizeOptionIndex = $option_index;
            // Multiple-size food item scenario
            if ($this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption] == 0) {
                return;
            } else {
                if ($this->selectedSizeOption && isset($this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption])) {
                    $this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption]--;
                    $this->addToCart($food_id, $option_key, $option_index, $check_sorm);
                }
            }
        }
    }

    public function refreshQuantity($food_id,$option_key, $option_index)
    {
        $existingCartItem = Cart::search(function ($cartItem) use ($food_id) {
            return $cartItem->id == $food_id && $cartItem->options['size'] != 'offer';
        })->first();

        if ($existingCartItem) {
            if ($existingCartItem->options['size'] != 'offer'){
                $rowId = $existingCartItem->id;

        
            if ($existingCartItem->options['sorm'] == 0) {
                if ($rowId) {
                    $this->quantity[$rowId] = $existingCartItem->qty;
                } else {
                    $this->quantity[$rowId] = 0;
                }
            } else {
                foreach (Cart::content() as $cartItem) {
                    if ($cartItem->options['size'] != 'offer'){
                    if ( $cartItem->options['sorm'] == 1) {
                        if( $cartItem->options['size'] == $option_key){
                         $existingCartItem = $cartItem;
                         break;
                        }
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
            // $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => __('Cart Processing')]);
        }
    }
    }

    public function refreshOfferQuantity($offer_id)
    {
        // dd('ASD');
        $existingCartItem = Cart::search(function ($cartItem) use ($offer_id) {
            return $cartItem->id == $offer_id && $cartItem->options['size'] == 'offer';
        })->first();

        if ($existingCartItem) {
            $rowId = $existingCartItem->id;
            // if ($existingCartItem->options['size'] == 'offer') {
                if ($rowId) {
                    $this->quantityOffer[$rowId] = $existingCartItem->qty;
                } else {
                    $this->quantityOffer[$rowId] = 0;
                }
            // } 
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => __('Cart Processing')]);
        }
    }

    public function removeFood($rowId, $food_id, $option_key, $option_index){
    // public function removeFood($rowId){
            Cart::remove($rowId);
            $this->emit('reset');
            $this->emit('go-check', $food_id, $option_key, $option_index);
            $this->emit('cart_updated');
            $this->render();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Removed')]);
    }
    public function removeList(){
            Cart::destroy();
            $this->emit('reset');
            $this->emit('cart_updated');
            $this->render();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Cart Removed, New Cart :)')]);
    }

    // OFFER ADD LIST
    public function addOfferToCartSingle($offer_id)
    {
        $existingCartItem = null;
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $offer_id && $cartItem->options->get('size') === 'offer') {
                $existingCartItem = $cartItem;
                // dd($existingCartItem);
                break;
            }
        }

        if ($existingCartItem) {
            // update the quantity
            $rowId = $existingCartItem->rowId;
            Cart::update($rowId, ['qty' => $this->quantityOffer[$offer_id]]);
            $this->emit('cart_updated');
            $this->emit('refreshOfferQuantityA', $offer_id);
            $this->refreshOfferQuantity($offer_id);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Quantity Updated')]);
        } 
    }

    public function increaseOfferQuantity($offer_id)
    {
        if (isset($this->quantityOffer[$offer_id])) {
            $this->quantityOffer[$offer_id]++;
            $this->addOfferToCartSingle($offer_id); // Call the addToCartSingle method with the updated quantity
        }
    }

    public function decreaseOfferQuantity($offer_id)
    {
        if (isset($this->quantityOffer[$offer_id]) && $this->quantityOffer[$offer_id] == 0) {
            return;
        } else {
            if (isset($this->quantityOffer[$offer_id]) && $this->quantityOffer[$offer_id] > 0) {
                $this->quantityOffer[$offer_id]--;
                $this->addOfferToCartSingle($offer_id); // Call the addToCartSingle method with the updated quantity
            }
        }
    }
} 