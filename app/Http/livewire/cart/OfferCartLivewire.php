<?php
 
namespace App\Http\Livewire\cart;
 
use App\Models\Offer;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class OfferCartLivewire extends Component
{
    protected $listeners = [
        'refreshOfferQuantityA' 
        // 'gocheckoffer' => 'refreshOfferQuantityA'
        // 'reset' => 'render'
    ];

    public $food;
    public array $quantity = [];
    public $offerAction;
    public $setting;
    public $glang;


    // ******************************* STEP #1
    public function mount($offercartdata, $setting ,$glang){
        $this->offerAction = $offercartdata;
        $this->setting = $setting;
        $this->glang = $glang;

        $this->mountSingle($offercartdata);

    }

    // ******************************* STEP #2.1
    private function mountSingle($offercartdata)
    {
        $existingCartItem = Cart::search(function ($cartItem) use ($offercartdata) {
            return $cartItem->id === $offercartdata->id;
        })->first();

        if ($existingCartItem) {
            $this->quantity[$offercartdata->id] = $existingCartItem->qty;
        } else {
            $this->quantity[$offercartdata->id] = 0;
        }
    }

    // ******************************* STEP #A
    public function addToCart($offer_id)
    {
        $this->addToCartSingle($offer_id);
    }

    // ******************************* STEP #B.1
    private function addToCartSingle($offer_id)
    {
        // dd($offer_id);
        $existingCartItem = null;
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == intval($offer_id)) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            // update the quantity
            $rowId = $existingCartItem->rowId;
            Cart::update($rowId, ['qty' => $this->quantity[$offer_id]]);
            // dd($this->quantity[$offer_id],$rowId);
            $this->emit('cart_updated');
            // $this->emit('check-offer-go', $offer_id);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Quantity Updated')]);
        } else {
            $offer = Offer::findOrFail($offer_id);
            $allOfferTranslations = $offer->translation()->pluck('name', 'lang')->toArray();
            // add new food
            
            Cart::add(
                $offer->id,
                $allOfferTranslations,
                $this->quantity[$offer_id],
                $offer->price,
                ['img' => $offer->img, 'size' => 'offer']
            );
            $this->emit('cart_updated');
            $this->emit('check-offer-go', $offer_id);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Inserted To Cart')]);
        }
    }


    public function render(){
        $cart = Cart::content();

        return view('dashboard.livewire.offer-cart', 
        [
                'offerAction' => $this->offerAction,
                'settings' => $this->setting,
                'glang' => $this->glang,
                'cart' => $cart,
            ]);

    }


    public function increaseQuantity($offer_id)
    {
        if (isset($this->quantity[$offer_id])) {
            $this->quantity[$offer_id]++;
            $this->addToCartSingle($offer_id); // Call the addToCartSingle method with the updated quantity
            // dd($this->quantity[$offer_id]);
        }
    }

    public function decreaseQuantity($offer_id)
    {
        if (isset($this->quantity[$offer_id]) && $this->quantity[$offer_id] == 0) {
            return;
        } else {
            if (isset($this->quantity[$offer_id]) && $this->quantity[$offer_id] > 0) {
                $this->quantity[$offer_id]--;
                $this->addToCartSingle($offer_id); // Call the addToCartSingle method with the updated quantity
            }
        }
    }
    
    public function refreshOfferQuantityA($offer_id)
    {
        $existingCartItem = Cart::search(function ($cartItem) use ($offer_id) {
            return $cartItem->id == intval($offer_id);
        })->first();

        if ($existingCartItem) {
            $rowId = $existingCartItem->id;
                if ($rowId) {
                    $this->quantity[$rowId] = $existingCartItem->qty;
                } else {
                    $this->quantity[$rowId] = 0;
                }

        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Working On It!')]);
        }
    }
} 