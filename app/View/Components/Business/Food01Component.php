<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Food;

class Food01Component extends Component
{
    /**
     * Create a new component instance.
     */
    public $foodId;
    public $user;
    public $glang;
    public $foodData;
    public $settings;
    public $ui;
    public $ui_select;

    public function __construct($user, $foodId, $ui, $settings)
    {
        $this->foodId = $foodId;
        $this->user = $user;
        $this->glang = app('glang');
        $this->ui = $ui;
        $this->ui_select = $ui[0];
        $this->settings = $settings;
        // Initialize the categoryData based on menuId
        $this->initializeFoodData();
    }

    private function initializeFoodData()
    {
        // Implement your data fetching logic using the provided $menuId
        $this->foodData = Food::with(['category', 'translation', 'category.translation' => function ($query) {
            $query->where('locale', $this->glang);
        }, 'translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', $this->user->id)
        ->where('cat_id', $this->foodId)
        ->orderBy('priority', 'ASC')
        ->get();
        // ->paginate(10);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui_select == '01') {
            return view('user.components.category.food01',['foodData' => $this->foodData, 'settings' => $this->settings]);
        } else if ($this->ui_select == '02') {
            return view('user.components.category.food02',['foodData' => $this->foodData, 'settings' => $this->settings]);
        } else {
            return view('user.components.category.food03',['foodData' => $this->foodData, 'settings' => $this->settings]);
        }
    }
}
