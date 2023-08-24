<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Mainmenu;
use App\Models\Categories;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories_Translator;
use Illuminate\Support\Facades\Storage;

class CategoryLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;
 
    protected $paginationTheme = 'bootstrap';
 
    //general
    public $lang;
    public $glang;
    public $category_id;
    public $category_selected_id;
    public $category_selected_id_delete;
    public $category_selected_name_delete;
    public $category_update;
    //utility
    public $search = '';
    public $mainmenuFilter = '';
    public $statusFilter = '';
    public $filteredLocales;
    //Form Data
    public $imgFlag = false; 
    public $objectName;
    public $menu_select;
    public $menu_id;
    public $names = [];
    public $status;
    public $priority;

    protected $listeners = ['updateCroppedCategoryImg' => 'handleCroppedImage'];

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        // dd($this->filteredLocales);
    }

    protected function rules()
    {
        $rules = [];
        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
        }
        $rules['menu_id'] = ['required'];
        $rules['priority'] = ['required'];
        $rules['status'] = ['required'];
        $rules['objectName'] = ['required'];
        return $rules;
    }

    public $tempImg;
    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/menu/1' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImg = $base64data;
            $this->imgFlag = true;
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

    public function saveCategory()
    {
        $validatedData = $this->validate();

        $menu = Categories::create([
            'user_id' => auth()->id(),
            'menu_id' => $validatedData['menu_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => $this->objectName,
            'cover' => null,
        ]);
    
        foreach ($this->filteredLocales as $locale) {
            Categories_Translator::create([
                'cat_id' => $menu->id,
                'name' => $this->names[$locale],
                'locale' => $locale,
            ]);
        }
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Category Inserted')]);
    }
    
    public $imgReader;
    public function editCategory(int $menu_selected)
    {
        $menu_edit = Categories::find($menu_selected);
        $this->category_update = $menu_edit;

        if ($menu_edit) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Categories_Translator::where('cat_id', $menu_edit->id)
                    ->where('lang', $locale)
                    ->first();

                if ($translation) {
                    $this->names[$locale] = $translation->name;
                } else {
                    $this->names[$locale] = 'Not Found';
                }
                $this->lang = $locale;
            }
            $this->menu_id = $menu_edit->menu_id;
            $this->status = $menu_edit->status;
            $this->priority = $menu_edit->priority;
            $this->imgReader = $menu_edit->img;
        } else {
            return redirect()->to('/rest');
        }
           
    }
 
    public function updateCategory()
    {
        // $this->objectName = $this->imgReader;
        $validatedData = $this->validate();
        // Update the Categories record
        Categories::where('id', $this->category_update->id)->update([
            'menu_id' => $validatedData['menu_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => $this->objectName,
            'cover' => null,
        ]);
    
        // Create or update the Categories_Translator records
        $menu = Categories::find($this->category_update->id);
        foreach ($this->filteredLocales as $locale) {
            Categories_Translator::updateOrCreate(
                [
                    'cat_id' => $menu->id, 
                    'lang' => $locale
                ],
                [
                    'name' => $this->names[$locale],
                ]
            );
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Updated Successfully')]);
    }

    public function updateStatus(int $category_id)
    {
        $menuState = Categories::find($category_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Status Updated Successfully')]);
    }
     
    public $confirmDelete = false;
    public $categoryNameToDelete = '';
    public $showTextTemp = '';

    public function deleteCategory(int $category_selected_id)
    {
        $this->category_selected_id_delete = Categories::find($category_selected_id);
        $this->category_selected_name_delete = Categories_Translator::where('cat_id', $category_selected_id)->where('lang', $this->glang)->first();
        $this->showTextTemp = $this->category_selected_name_delete->name;
        $this->confirmDelete = true;
    }

    public function destroycategory()
    {
        if ($this->confirmDelete && $this->categoryNameToDelete === $this->showTextTemp) {
            Categories::find($this->category_selected_id_delete->id)->delete();
            Storage::disk('s3')->delete($this->category_selected_id_delete->img);
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->dispatchBrowserEvent('fixx');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Deleted Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild del-303')]);
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
        $this->menu_id = '';
        $this->status = '';
        $this->priority = '';
        $this->imgReader = '';
        $this->category_selected_id_delete = '';
        $this->category_selected_name_delete = '';
        $this->showTextTemp = '';
        $this->categoryNameToDelete = '';
        $this->confirmDelete = false;
        $this->imgFlag = false;
    }
 
    public function render()
    {
        // START GET THE MENU NAMES
        $this->menu_select = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->orderBy('id', 'DESC')
        ->get();
        // END GET THE MENU NAMES

        $colspan = 5;
        $cols_th = ['#','Menu','Name','Image','Status','Priority','Actions'];
        $cols_td = ['id','mainmenu.translation.name', 'translation.name','img','status','priority'];

        $data = Categories::with(['mainmenu', 'translation', 'mainmenu.translation' => function ($query) {
            $query->where('lang', $this->glang);
        }, 'translation' => function ($query) {
            $query->where('locale', $this->glang);
        }])->where('user_id', Auth::id())
            ->whereHas('translation', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->mainmenuFilter !== '', function ($query) {
            $query->whereHas('mainmenu.translation', function ($query) {
                $query->where('name', $this->mainmenuFilter);
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->whereHas('translation', function ($query) {
                    $query->where('status', $this->statusFilter);
                });
            })->orderBy('priority', 'ASC')
            ->paginate(10);

        return view('dashboard.livewire.category-table', 
        [
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'menu_select' => $this->menu_select,
            //asdsad
            'fl' => $this->imgReader
        ])->with('alert', ['type' => 'info',  'message' => __('Category Table Loaded')]);
    }

    public function resetFilter(){
        $this->search = '';
        $this->mainmenuFilter = '';
        $this->statusFilter = '';
    }

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Categories::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;
            $varr->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Priority Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Priority Did Not Update')]);
        }
    }
}