<?php
 
namespace App\Http\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class SupportTutorialLivewire extends Component
{
    public $selectedPlaylist = null;
    public $playlistsData;


    public function mount()
    {
        $this->playlistsData = [
            // 'Patricia Reels' => ['PLq2poEBbwrl7x6IruEBQzjoSssciXIJN4', 'en'],
            'ماين مينيو' => ['PLQe1kP4aCPRaKxCgNOOLTjHbj6SrI_y5M', 'ar'],
            // 'M Magazine' => ['PLq2poEBbwrl6YhamyTFCnBu2IUQd7LMur', 'en'],
            // 'Astron' => ['PLq2poEBbwrl4HwAU-rQEkHWHLrnCr2tl2', 'ku'],
        ];
    }

    public function updatePlaylist($playlistId)
    {
        $this->selectedPlaylist = $playlistId;
        $this->dispatchBrowserEvent('reloadVid',$this->selectedPlaylist);
    }

    public function render()
    {
        return view('dashboard.livewire.support-tutorial-form', [
            'loadFirst' => reset($this->playlistsData)[0] ?? null,
            'playlistsData' => $this->playlistsData,
        ]);
    }
}

