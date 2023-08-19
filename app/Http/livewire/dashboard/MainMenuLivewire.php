<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Mainmenu;
use App\Models\Mainmenu_Translator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
 
class MainMenuLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
 
    // public $name, $email, $role, $student_id, $status;
    public $search = '';
    public $glang;
    public $filteredLocales;
    public $names = [];
    public $menu_selected_id;
    public $menu_id;
    public $lang;
    public $menu_update;

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
    }

    protected function rules()
    {
        $rules = [];

        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
        }
    
        // $rules['status'] = ['required'];
    
        return $rules;
    }
 
    // public function updated($fields)
    // {
    //     $this->validateOnly($fields);
    // }
 
    public function saveMenu()
    {
        // $validatedData = $this->validate(); // Automatically validates the form fields based on the rules

        $menu = Mainmenu::create([
            'user_id' => auth()->id(),
            // 'status' => $validatedData['status'],
        ]);
    
        foreach ($this->filteredLocales as $locale) {
            Mainmenu_Translator::create([
                'menu_id' => $menu->id,
                'name' => $this->names[$locale],
                'lang' => $locale,
            ]);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Added Successfully')]);
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
     
    public function editStudent(int $menu_selected)
    {
        $menu_edit = Mainmenu::find($menu_selected);
        $this->menu_update = $menu_edit;

        if ($menu_edit) {
            foreach ($this->filteredLocales as $locale) {
                // Find the translation for the given locale in the Mainmenu_Translator table
                $translation = Mainmenu_Translator::where('menu_id', $menu_edit->id)
                    ->where('lang', $locale)
                    ->first();
    
                // Check if the translation exists for the given locale
                if ($translation) {
                    $this->names[$locale] = $translation->name;
                } else {
                    // If translation doesn't exist, set a default value
                    $this->names[$locale] = 'Not Found';
                }
                
                $this->lang = $locale;
            }
        } else {
            return redirect()->to('/rest');
        }
    }
 
    public function updateStudent()
    {
        // dd($this->menu_update->id);
        $validatedData = $this->validate();

        // Update the Mainmenu record
        Mainmenu::where('id', $this->menu_update->id)->update([
            // Update the relevant fields based on the form data
            // 'status' => $validatedData['status'],
        ]);
    
        // Create or update the Mainmenu_Translator records
        $menu = Mainmenu::find($this->menu_update->id);
        foreach ($this->filteredLocales as $locale) {
            Mainmenu_Translator::updateOrCreate(
                [
                    'menu_id' => $menu->id, 
                    'lang' => $locale
                ],
                [
                    'name' => $this->names[$locale],
                ]
            );
        }

        session()->flash('message','Menu Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function updateStatus(int $menu_id)
    {
        $menuState = Mainmenu::find($menu_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
    
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);
    }
     
    public function deleteStudent(int $menu_selected_id)
    {
        $this->menu_selected_id = $menu_selected_id;;
    }
 
    public function destroyStudent()
    {
        if( Mainmenu::find($this->menu_selected_id)->delete()) {
        // Mainmenu::find($this->menu_selected_id)->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Deleted Successfully')]);
            $this->dispatchBrowserEvent('fixx');
            $this->dispatchBrowserEvent('close-modal');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild del-301')]);
        }
    }
 
    public function closeModal()
    {
        $this->resetInput();
    }
 
    public function resetInput()
    {
        foreach ($this->filteredLocales as $locale) {
            $this->names[$locale] = "";
        }
    }
 
    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','USER ID','Name','status','actions'];
        $cols_td = ['id','user_id','translation.name','status'];

        $data = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->whereHas('translation', function ($query) {
            $query->
            // where('lang', $this->glang)
                where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('user_id', 'like', '%' . $this->search . '%');
                });
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
        //$students = Student::select('id','name','email','course')->get();
        return view('dashboard.livewire.user-table2', ['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    }
}