<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Categories;

class Category01Component extends Component
{
    /**
     * Create a new component instance.
     */
    public $menuId;
    public $user;
    public $glang;
    public $categoryData;
    public $ui;
    public $ui_select;

    public function __construct($menuid, $user, $glang, $ui)
    {
        $this->menuId = $menuid;
        $this->user = $user;
        $this->glang = $glang;
        $this->ui = $ui;
        $this->ui_select = $ui[0];
        // Initialize the categoryData based on menuId
        $this->initializeCategoryData();
    }


    private function initializeCategoryData()
    {
        // Implement your data fetching logic using the provided $menuId
        $this->categoryData = Categories::with(['mainmenu', 'translation', 'mainmenu.translation' => function ($query) {
            $query->where('lang', $this->glang);
        }, 'translation' => function ($query) {
            $query->where('locale', $this->glang);
        }])
        ->where('user_id', $this->user)
        ->where('menu_id', $this->menuId)
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
            return view('user.components.categories.category01',['categoryData' => $this->categoryData]);
        } else if ($this->ui_select == '02') {
            return view('user.components.categories.category02',['categoryData' => $this->categoryData]);
        } else {
            return view('user.components.categories.category03',['categoryData' => $this->categoryData]);
        }
    }
}
