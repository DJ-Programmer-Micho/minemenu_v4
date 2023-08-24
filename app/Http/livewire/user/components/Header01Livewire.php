<?php
 
namespace App\Http\Livewire\user\components;
use Livewire\Component;

use App\Models\User;
use App\Models\Mainmenu;
 
class Header01Livewire extends Component
{
    public $asd;

    public function mount($data)
    {
        $this->asd = $data->id;
    }

    public function render()
    {
        return view('user.components.category.h1c', [
            'categories' => $this->asd,
        ]);
    }
}
