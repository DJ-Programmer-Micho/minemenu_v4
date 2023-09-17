<?php

namespace App\View\Components\Business;

use Closure;
use App\Models\Offer;
use App\Models\Mainmenu;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Offer01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // fixed
    public $glang;
    // var
    public $user_id;
    public $ui;
    public $ui_select;

    public function __construct($user, $ui)
    {
        $this->glang = app('glang');
        $this->user_id = $user;
        $this->ui = json_decode($ui);
        $this->ui_select = $this->ui[3] ?? 01;

    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $offerData = Offer::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', $this->user_id )
        ->where('status', 1)
        ->orderBy('priority', 'ASC')
        ->get();
        // ->paginate(10);

        if ($this->ui_select == '01') {
            return view('user.components.offers.offer01',['offerData' => $offerData]);
        } else if ($this->ui_select == '02') {
            return view('user.components.offers.offer02',['offerData' => $offerData]);
        } else if ($this->ui_select == '03'){
            return view('user.components.offers.offer03',['offerData' => $offerData]);
        } else {
            return view('user.components.offers.offer04',['offerData' => $offerData]);
        }
        
    }
}
