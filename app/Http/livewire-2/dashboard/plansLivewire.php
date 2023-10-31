<?php
 
namespace App\Http\Livewire\dashboard;
use Livewire\Component;
 
class plansLivewire extends Component
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
        return view('dashboard.livewire.plan-view',[
            'visit_lifetime' => 1,
        ]);
    }
}