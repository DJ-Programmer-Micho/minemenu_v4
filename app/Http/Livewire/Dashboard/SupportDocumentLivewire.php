<?php
 
namespace App\Http\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class SupportDocumentLivewire extends Component
{
    public function render()
    {
        return view('dashboard.livewire.support-document-form');
    }
}

