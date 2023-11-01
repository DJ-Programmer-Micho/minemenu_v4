<?php
 
namespace App\Http\Livewire\Cart;
 
use App\Models\Food;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodCartLivewire extends Component
{
    protected $listeners = [
        'go-check' => 'refreshAQuantity',
        'reset' => 'render'
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

    // ******************************* STEP #1
    public function mount($foodcartdata, $setting ,$glang){
        $this->foodAction = $foodcartdata;
        $this->setting = $setting;
        $this->glang = $glang;

        if ($this->foodAction->sorm == 0) {
            $this->mountSingle($foodcartdata);
        } else {
            $this->mountMultiple($foodcartdata);
        }
    }

    // ******************************* STEP #2.1
    private function mountSingle($foodcartdata)
    {
        $existingCartItem = Cart::search(function ($cartItem) use ($foodcartdata) {
            return $cartItem->id == $foodcartdata->id && $cartItem->options['size'] != 'offer';
        })->first();

        if ($existingCartItem) {
            $this->quantity[$foodcartdata->id] = $existingCartItem->qty;
        } else {
            $this->quantity[$foodcartdata->id] = 0;
        }
    }

    // ******************************* STEP #2.2
    private function mountMultiple($foodcartdata)
    {
        $options = json_decode($foodcartdata->options, true);
        
        foreach ($options[$this->glang] as $index => $option) {
            $this->quantity[$foodcartdata->id][$index][$option['key']] = 0;
        }
        // dd([$foodcartdata->id],[$index],[$option['key']]);
        $existingCartItem = null;
        
        foreach (Cart::content() as $index => $cartItem) {
            $i = 0;
            if ($cartItem->id == $foodcartdata->id && $cartItem->options['size'] != 'offer') {
                $existingCartItem = $cartItem;
                foreach ($options[$this->glang] as $option) {
                    if ($existingCartItem->options->has('size') && $existingCartItem->options->get('size') === $option['key']) {
                        $this->quantity[$foodcartdata->id][$i][$option['key']] = $existingCartItem->qty;
                    }
                    $i++;
                }
            }
        }
          
        $this->previewQuantity[$foodcartdata->id] = [];

        foreach ($options[$this->glang] as $index => $option) {
            $this->previewQuantity[$foodcartdata->id][$index][$option['key']] = isset($this->quantity[$foodcartdata->id][$index][$option['key']])
                ? $this->quantity[$foodcartdata->id][$index][$option['key']]
                : 0;
        }
    }

    // ******************************* STEP #A
    public function addToCart($food_id, $option_key, $option_index)
    {
        if ($this->foodAction->sorm == 0) {
            $this->addToCartSingle($food_id);
        } else {
            $this->addToCartMultiple($food_id, $option_key, $option_index);
        }
    }

    // ******************************* STEP #B.1
    private function addToCartSingle($food_id)
    {
        $existingCartItem = null;
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $food_id && $cartItem->options['size'] !== 'offer') {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            // update the quantity
            $rowId = $existingCartItem->rowId;
            Cart::update($rowId, ['qty' => $this->quantity[$food_id]]);
            $this->emit('cart_updated');
            $this->emit('check-go', $food_id, 'null','null');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
        } else {
            $food = Food::findOrFail($food_id);
            $allFoodTranslations = $food->translation()->pluck('name', 'lang')->toArray();
            // add new food
            
            Cart::add(
                $food->id,
                $allFoodTranslations,
                $this->quantity[$food_id],
                $food->price,
                ['img' => $food->img,  'size' => 'null','sorm' => $this->foodAction->sorm]
            );
            $this->emit('cart_updated');
            $this->emit('check-go', $food_id,'null','null');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Inserted To Cart')]);
        }
    }

    // ******************************* STEP #B.2
    private function addToCartMultiple($food_id, $option_key, $option_index)
    {
        $existingCartItem = null;
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $food_id && $cartItem->options->get('size') == $option_key && $cartItem->options['size'] != 'offer') {
                $existingCartItem = $cartItem;
                break;
            }
        }
        

        if ($existingCartItem) {
            $rowId = $existingCartItem->rowId;

            $food = Food::findOrFail($food_id);
            $options = json_decode($food->options, true);
            // $currentOptions = $options[$this->glang] ?? [];
            
            // MAIN CHILD index = en lang = 0 1
            foreach ($options as $index => $lang_option) {
                // dd($options,  $lang_option, $lang_option[$this->selectedSizeOptionIndex],$lang_option[$this->selectedSizeOptionIndex]['key']);
                if($lang_option[$this->selectedSizeOptionIndex]['key']){
                    $ars[$index] = $lang_option[$this->selectedSizeOptionIndex]['key'];
                    $price = $lang_option[$this->selectedSizeOptionIndex]['value'];
                }
            }
            
            foreach ($ars as $op) {
                // Check if the option key exists in $this->quantity array
                if (isset($this->quantity[$food_id][$option_index][$op])) {
                    $quantity = $this->quantity[$food_id][$option_index][$op];
                }

                if ($quantity > 0) {
                    $allFood = $food->translation()->pluck('name', 'lang')->toArray();
                    $this->quantity_f = $quantity;
                } else {
                    Cart::remove($rowId);
                    $this->emit('check-go', $food_id, $option_key, $option_index);
                    $this->emit('cart_updated');
                    return;
                }
            }

            Cart::update($rowId, ['qty' => $this->quantity_f]);
            $this->emit('cart_updated');
            $this->emit('check-go', $food_id,$option_key, $option_index);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Quantity Updated')]);
        } else {
            $food = Food::findOrFail($food_id);
            $options = json_decode($food->options, true);
            // $currentOptions = $options[$this->glang] ?? [];
            
            // MAIN CHILD index = en lang = 0 1
            foreach ($options as $index => $lang_option) {
                if($lang_option[$option_index]['key']){
                    $ars[$index] = $lang_option[$option_index]['key'];
                    $price = $lang_option[$option_index]['value'];
                }
            }
            
            foreach ($ars as $op) {
                // Check if the option key exists in $this->quantity array
                if (isset($this->quantity[$food_id][$option_index][$op])) {
                    $quantity = $this->quantity[$food_id][$option_index][$op];
                }

                if ($quantity > 0) {
                    $allFood = $food->translation()->pluck('name', 'lang')->toArray();
                    $this->quantity_f = $quantity;
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Done!')]);
                    return;
                }
            }

            $result = [];
          
            foreach ($allFood as $lang => $name) {
                $result[$lang] = $name . ' - ' . $ars[$lang];
            }
            $size = $ars['en'];
         
            Cart::add(
                $food->id,
                $result,
                $this->quantity_f,
                $price,
                ['img' => $food->img, 'size' => $size,'sorm' => $this->foodAction->sorm, 'sizeindex' => $option_index]
            );

            $this->emit('cart_updated');
            $this->emit('check-go', $food_id,$option_key, $option_index);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Cart Food Inserted')]);
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


    public function increaseQuantity($food_id, $option_key, $option_index)
    {
        if ($this->foodAction->sorm == 0) {
            // Single food item scenario
            if (isset($this->quantity[$food_id])) {
                $this->quantity[$food_id]++;
                $this->addToCartSingle($food_id); // Call the addToCartSingle method with the updated quantity
            }
        } else {
            $this->selectedSizeOption = $option_key;
            $this->selectedSizeOptionIndex = $option_index;
            // Multiple-size food item scenario
            if ($this->selectedSizeOption && isset($this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption])) {
                $this->quantity[$food_id][$this->selectedSizeOptionIndex][$this->selectedSizeOption]++;
                $this->addToCartMultiple($food_id, $option_key, $option_index);
            }
        }
    }

    public function decreaseQuantity($food_id, $option_key, $option_index)
    {
        if ($this->foodAction->sorm == 0) {
            // Single food item scenario
            if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] == 0) {
                return;
            } else {
                if (isset($this->quantity[$food_id]) && $this->quantity[$food_id] > 0) {
                    $this->quantity[$food_id]--;
                    $this->addToCartSingle($food_id); // Call the addToCartSingle method with the updated quantity
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
                    $this->addToCartMultiple($food_id, $option_key, $option_index);
                }
            }
        }
    }
    
    public function refreshAQuantity($food_id,$option_key, $option_index)
    {
        
        $existingCartItem = Cart::search(function ($cartItem) use ($food_id) {
            return $cartItem->id == $food_id;
        })->first();

        if ($existingCartItem) {
            $rowId = $existingCartItem->id;
            if ($existingCartItem->options['size'] != 'offer') {
            if ($existingCartItem->options['sorm'] == 0) {
                if ($rowId) {
                    $this->quantity[$rowId] = $existingCartItem->qty;
                } else {
                    $this->quantity[$rowId] = 0;
                }
            } else {
                foreach (Cart::content() as $cartItem) {
                    if ( $cartItem->options['size'] != 'offer') {
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
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Working On It!')]);
        }
    }
} 