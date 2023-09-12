<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Mainmenu;
use App\Models\Mainmenu_Translator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
 
class DashboardLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
 
    public $search = '';
    public $glang;
    public $filteredLocales;
    public $status;
    public $names = [];
    public $menu_selected_id;
    public $menu_id;
    public $lang;
    public $priority;
    public $menu_update;

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
    }

    public function render()
    {
        $colspan = 6;
        // $cols_th = ['#','Name','Priority','Status','actions'];
        // $cols_td = ['id','translation.name','priority','status'];

        // $data = Mainmenu::with(['translation' => function ($query) {
        //     $query->where('lang', $this->glang);
        // }])
        // ->where('user_id', Auth::id())
        // ->whereHas('translation', function ($query) {
        //     $query->
        //     // where('lang', $this->glang)
        //         where(function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%')
        //                 ->orWhere('user_id', 'like', '%' . $this->search . '%');
        //         });
        // })
        // ->orderBy('priority', 'ASC')
        // ->paginate(10);
        //$Menus = Menu::select('id','name','email','course')->get();
        return view('dashboard.livewire.dashboard-view',['asd' => $colspan]);
    }
}