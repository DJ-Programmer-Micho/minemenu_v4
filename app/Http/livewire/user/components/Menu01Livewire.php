<?php
 
namespace App\Http\Livewire\user\components;

use Livewire\Component;

use App\Models\User;
use App\Models\Mainmenu;
 
class Menu01Livewire extends Component
{
        // fixed
        public $glang;
// var
    public $menuData;
    public $user_id;
    public $aaa;
    public function mount($user, $aaa)
    {
        $this->glang = app('glang');
        $this->user_id = $user;
        $this->aaa = $aaa;
    }

    public function loadCategories($menuId)
    {
        $this->emit('loadCategories', $menuId);
    }
    
    public function render()
    {
        $menuDataCc = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', $this->user_id )
        // ->orderBy('priority', 'ASC')
        ->paginate(10);
  
        return view('user.components.category.m1c', [
            'menuDataC' => $menuDataCc,
            'aaa' => $this->aaa,
        ]);
    }
}
