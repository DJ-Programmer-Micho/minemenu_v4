<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Plan;
use Livewire\Component;
 
class plansUserViewLivewire extends Component
{
    public $glang;
    public $filteredLocales;
    public $offerPlan;
    public $regularPlans;

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');

        $this->offerPlan = Plan::where('status', 1)->where('type','offer')->where('valid_date','>',now())->get();
        $this->regularPlans = Plan::where('status', 1)->where('type','regular')->get();
    }


    public function render()
    {
        return view('dashboard.livewire.owner.plan-user-view',[
            'visit_lifetime' => 1,
            'offerPlan' => $this->offerPlan,
            'regularPlans' => $this->regularPlans,
        ]);
    }
}