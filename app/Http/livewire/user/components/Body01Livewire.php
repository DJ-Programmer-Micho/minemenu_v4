<?php
 
namespace App\Http\Livewire\user\components;

use Livewire\Component;

use App\Models\Mainmenu;
 
class Body01Livewire extends Component
{
    // fixed
    public $glang;
    // Var
    public $setting;
    public $user_id;
    public $rest_name;
    public $aaa;

    public function mount($user, $setting)
    {
        $this->glang = app('glang');
        $this->user_id = $user->id;
        $this->rest_name = $user->name;
        $this->setting = $setting;
        $this->aaa = '01';

    }
    
    public function render()
    {
        return view('user.components.category.b1c', [
            'settings' => $this->setting,
            'name' => $this->rest_name,
            'aaa' =>  $this->aaa,
            'user_id' => $this->user_id,
            'glang' => $this->glang,
        ]);
    }
}
