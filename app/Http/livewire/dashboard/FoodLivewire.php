<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Categories;
use App\Models\Food;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Food_Translator;
use Illuminate\Support\Facades\Storage;

class FoodLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;
 
    protected $paginationTheme = 'bootstrap';
 
    //general
    public $lang;
    public $glang;
    public $food_id;
    public $food_selected_id;
    public $food_selected_id_delete;
    public $food_selected_name_delete;
    public $food_update;
    //utility
    public $search = '';
    public $categorieFilter = '';
    public $statusFilter = '';
    public $filteredLocales;
    //Form Data
    public $objectName;
    public $menu_select;
    public $cat_id;
    public $names = [];
    public $description = [];
    public $status;
    public $priority;

    protected $listeners = ['updateCroppedFoodImg' => 'handleCroppedImage'];

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
        $rules['cat_id'] = ['required'];
        $rules['priority'] = ['required'];
        $rules['status'] = ['required'];
        $rules['objectName'] = ['required'];
        return $rules;
    }

    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/menu/1' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            if( $this->imgReader){
                Storage::disk('s3')->delete($this->imgReader);
                Storage::disk('s3')->put($this->objectName, $croppedImage);
            } else {
                Storage::disk('s3')->put($this->objectName, $croppedImage);
            }
            
            $this->emit('imageUploaded', $this->objectName);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }

    public function saveFood()
    {
        $validatedData = $this->validate();

        $menu = Food::create([
            'user_id' => auth()->id(),
            'cat_id' => $validatedData['cat_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => $this->objectName,
        ]);
    
        foreach ($this->filteredLocales as $locale) {
            Food_Translator::create([
                'food_id' => $menu->id,
                'name' => $this->names[$locale],
                'lang' => $locale,
            ]);
        }
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Food Inserted')]);
    }
    
    public $imgReader;
    public function editFood(int $menu_selected)
    {
        $menu_edit = Food::find($menu_selected);
        $this->food_update = $menu_edit;

        if ($menu_edit) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Food_Translator::where('food_id', $menu_edit->id)
                    ->where('lang', $locale)
                    ->first();

                if ($translation) {
                    $this->names[$locale] = $translation->name;
                } else {
                    $this->names[$locale] = 'Not Found';
                }
                $this->lang = $locale;
            }
            $this->cat_id = $menu_edit->cat_id;
            $this->status = $menu_edit->status;
            $this->priority = $menu_edit->priority;
            $this->imgReader = $menu_edit->img;
        } else {
            return redirect()->to('/rest');
        }
           
    }
 
    public function updateFood()
    {
        $this->objectName = $this->imgReader;
        $validatedData = $this->validate();
        // Update the Categories record
        Food::where('id', $this->food_update->id)->update([
            'cat_id' => $validatedData['cat_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => $this->imgReader,
        ]);
    
        // Create or update the Categories_Translator records
        $menu = Food::find($this->food_update->id);
        foreach ($this->filteredLocales as $locale) {
            Food_Translator::updateOrCreate(
                [
                    'food_id' => $menu->id, 
                    'lang' => $locale
                ],
                [
                    'name' => $this->names[$locale],
                ]
            );
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Updated Successfully')]);
    }

    public function updateStatus(int $food_id)
    {
        $menuState = Food::find($food_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);
    }
     
    public $confirmDelete = false;
    public $foodNameToDelete = '';
    public $showTextTemp = '';

    public function deleteFood(int $food_selected_id)
    {
        $this->food_selected_id_delete = Food::find($food_selected_id);
        $this->food_selected_name_delete = Food_Translator::where('food_id', $food_selected_id)->where('lang', $this->glang)->first();
        $this->showTextTemp = $this->food_selected_name_delete->name;
        $this->confirmDelete = true;
    }

    public function destroyfood()
    {
        if ($this->confirmDelete && $this->foodNameToDelete === $this->showTextTemp) {
            Food::find($this->food_selected_id_delete->id)->delete();
            Storage::disk('s3')->delete($this->food_selected_id_delete->img);
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild')]);
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
        $this->cat_id = '';
        $this->status = '';
        $this->priority = '';
        $this->imgReader = '';
        $this->food_selected_id_delete = '';
        $this->food_selected_name_delete = '';
        $this->showTextTemp = '';
        $this->foodNameToDelete = '';
        $this->confirmDelete = false;
    }
 
    public function render()
    {
        // START GET THE MENU NAMES
        $this->menu_select = Categories::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->orderBy('id', 'DESC')
        ->get();
        // END GET THE MENU NAMES

        $colspan = 5;
        $cols_th = ['#','Menu','Name','Image','Status','Priority','Actions'];
        $cols_td = ['id','category.translation.name', 'translation.name','img','status','priority'];

        $data = Food::with(['category', 'translation', 'category.translation' => function ($query) {
            $query->where('lang', $this->glang);
        }, 'translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])->where('user_id', Auth::id())
            ->whereHas('translation', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categorieFilter !== '', function ($query) {
            $query->whereHas('category.translation', function ($query) {
                $query->where('name', $this->categorieFilter);
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->whereHas('translation', function ($query) {
                    $query->where('status', $this->statusFilter);
                });
            })->orderBy('priority', 'ASC')
            ->paginate(10);

        return view('dashboard.livewire.food-table', 
        [
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'menu_select' => $this->menu_select,
            //asdsad
            'fl' => $this->imgReader
        ])->with('alert', ['type' => 'info',  'message' => __('Menu Table Loaded')]);
    }

    public function resetFilter(){
        $this->search = '';
        $this->categorieFilter = '';
        $this->statusFilter = '';
    }

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Food::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;
            $varr->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Priority Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Priority Did Not Update')]);
        }
    }
}