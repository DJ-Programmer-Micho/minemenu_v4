<?php
 
namespace App\Http\Livewire\owner;

use Livewire\Component;
 
class plansViewLivewire extends Component
{
    public $glang;
    public $filteredLocales;

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
    }


    public function render()
    {
        return view('dashboard.livewire.owner.plan-view',[
            'visit_lifetime' => 1,
        ]);
    }
}