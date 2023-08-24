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


        $menuData = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', $this->user_id )
        // ->whereHas('translation', function ($query) {
        //     $query->
        //     // where('lang', $this->glang)
        //         where(function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%')
        //                 ->orWhere('user_id', 'like', '%' . $this->search . '%');
        //         });
        // })
        ->orderBy('id', 'DESC')
        ->paginate(10);



        return view('user.components.category.b1c', [
            'settings' => $this->setting,
            'name' => $this->rest_name,
            // 'menuData' => $menuData,
            'aaa' =>  $this->aaa,
            'user_id' => $this->user_id,
            'glang' => $this->glang,
        ]);
    }
}
