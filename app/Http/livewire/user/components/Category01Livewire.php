<?php

namespace App\Http\Livewire\user\components;

use Livewire\Component;
use App\Models\Categories;

class Category01Livewire extends Component
{
    public $menuId;
    public $user;
    public $glang;
    protected $categoryData;

    protected $listeners = ['loadCategories'];

    public function mount($user, $glang, $menuId)
    {
        $this->initializeData($user, $glang, $menuId);
    }

    public function loadCategories($menuId)
    {
        $this->initializeData($this->user, $this->glang, $menuId);
    }

    private function initializeData($user, $glang, $menuId)
    {
        $this->glang = $glang;
        $this->user = $user;
        $this->menuId = $menuId;

        $this->categoryData = Categories::with(['mainmenu', 'translation', 'mainmenu.translation' => function ($query) {
                $query->where('lang', $this->glang);
            }, 'translation' => function ($query) {
                $query->where('locale', $this->glang);
            }])
            ->where('user_id', $this->user)
            ->where('menu_id', $this->menuId)
            ->orderBy('priority', 'ASC')
            ->paginate(10);
    }

    public function render()
    {
        return view('user.components.category.c1c', [
            'categoryData' => $this->categoryData,
        ]);
    }
}
