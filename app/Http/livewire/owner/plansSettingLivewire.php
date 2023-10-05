<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Plan;
use Livewire\Component;
 
class plansSettingLivewire extends Component
{
    public $glang;
    public $filteredLocales;
    // Filters
    public $countryFilter = null;
    public $planFilter = null;
    public $searchFilter = null;
    public $dateRange = null;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
    }

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

    public function resetFilter(){
        $this->planFilter = '';
        $this->searchFilter = '';
        $this->dateRange = '';
        $this->countryFilter = '';
    } // END OF FUNCTION RESETING FILTER

    public function render()
    {

        // $data = Plan::with(['category', 'translation', 'category.translation' => function ($query) {
        //     $query->where('locale', $this->glang);
        // }, 'translation' => function ($query) {
        //     $query->where('lang', $this->glang);
        // }])->where('user_id', Auth::id())
        //     ->whereHas('translation', function ($query) {
        //         $query->where(function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%');
        //         });
        //     })
        //     ->when($this->categorieFilter !== '', function ($query) {
        //     $query->whereHas('category.translation', function ($query) {
        //         $query->where('name', $this->categorieFilter);
        //         });
        //     })
        //     ->when($this->statusFilter !== '', function ($query) {
        //         $query->whereHas('translation', function ($query) {
        //             $query->where('status', $this->statusFilter);
        //         });
        //     })->orderBy('priority', 'ASC')
        //     ->when($this->optionFilter !== '', function ($query) {
        //         $query->whereHas('translation', function ($query) {
        //             $query->where('sorm', $this->optionFilter);
        //         });
        //     })
        //     ->paginate(10);
        $colspan = 5;
        $cols_th = ['#','Plan Name','Duration','Cost','Exchange rate','Monthly Cost','Status','Priority','Actions'];
        $cols_td = ['id','name', 'duration','cost','exchange_rate','monthly_cost','status','priority'];


        $data = Plan::get();
        return view('dashboard.livewire.owner.plan-setting',[
            'collections' => $data,
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'dateRange_send' => $this->dateRange ?? null,
        ]);
    }
}