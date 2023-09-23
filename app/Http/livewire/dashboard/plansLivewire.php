<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Food;
use App\Models\Plan;
use App\Models\Tracker;
use Livewire\Component;
// use Livewire\WithPagination;
use App\Models\Categories;
use App\Models\TrackFoods;
use Illuminate\Support\Facades\Auth;
 
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