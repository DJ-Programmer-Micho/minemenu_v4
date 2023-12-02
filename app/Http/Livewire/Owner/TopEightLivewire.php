<?php
 
namespace App\Http\Livewire\Owner;

use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
use App\Models\PlanChange;
use Livewire\WithPagination;
use App\Exports\UsersActivityExport;
use App\Models\TopUsers;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
 
class TopEightLivewire extends Component
{
    public $showMenu;

    public function mount(){
        $this->showMenu = TopUsers::first()->menus_id;
    }

    public function saveMenuShow(){
        // $update = $this->showMenu;
        $update = explode(',', $this->showMenu);
        $topUsers = TopUsers::find(1);
        $topUsers->update([
            'menus_id' => $update
        ]);
    }

    public function render(){
        return view('dashboard.livewire.owner.top-eight');
    }
}