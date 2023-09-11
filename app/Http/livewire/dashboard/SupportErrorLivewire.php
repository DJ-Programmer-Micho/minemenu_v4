<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class SupportErrorLivewire extends Component
{
    public function render()
    {
        return view('dashboard.livewire.support-error-form');
    }
}

