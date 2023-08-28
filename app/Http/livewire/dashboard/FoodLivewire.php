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
    public $optionFilter = '';
    public $filteredLocales;
    //Form Data
    public $imgFlag = false; 
    public $objectName; 
    public $menu_select;
    public $cat_id;
    public $names = [];
    public $description = [];
    public $options = [];
    public $status;
    public $priority;
    public $showTextarea = false;
    public $price = '';
    public $oldPrice = '';

    protected $listeners = ['updateCroppedFoodImg' => 'handleCroppedImage'];

    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->initializeOptions();
    }
    public function initializeOptions()
    {
        foreach ($this->filteredLocales as $locale) {
            $this->options[$locale] = [];
            for ($i = 0; $i < 3; $i++) {
                $this->options[$locale][] = ['key' => '', 'value' => ''];
            }
        }
    }

    public function addOption()
    {
        foreach ($this->filteredLocales as $locale) {
            $this->options[$locale][] = ['key' => '', 'value' => ''];
        }
    }

    public function removeOption($locale, $index)
    {
        unset($this->options[$locale][$index]);
        $this->options[$locale] = array_values($this->options[$locale]);
    }
    protected function rules()
    {
        $rules = [];
        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
            $rules['description.' . $locale] = 'required|string|min:2';
        }
        $rules['cat_id'] = ['required'];
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
            
            // $this->emit('imageUploaded', $this->objectName);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }

    public function saveFood()
    {
        $validatedData = $this->validate();

        $sorm = $this->showTextarea ? 1 : 0;
        $optionsData = $this->showTextarea == false ? null : json_encode($this->options);

        $menu = Food::create([
            'user_id' => auth()->id(),
            'cat_id' => $validatedData['cat_id'],
            'priority' => $validatedData['priority'],
            'price' => $this->price ? $this->price : null,
            'old_price' => $this->oldPrice ? $this->oldPrice : null,
            'options' =>  $optionsData,
            'sorm' => $sorm,
            'status' => $validatedData['status'],
            'img' => $this->objectName,
        ]);

        foreach ($this->filteredLocales as $locale) {
            Food_Translator::create([
                'food_id' => $menu->id,
                'name' => $this->names[$locale],
                'description' => $this->description[$locale],
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
                    $this->description[$locale] = $translation->description;
                } else {
                    $this->names[$locale] = 'Not Found';
                    $this->description[$locale] = 'Not Found';
                }
                $this->lang = $locale;
            }

            $options = json_decode($menu_edit->options, true);
            if ($options === null) {
                $this->initializeOptions();
            } else {
                $this->options = $options;
            }

            $this->cat_id = $menu_edit->cat_id;
            $this->oldPrice = $menu_edit->old_price ? $menu_edit->old_price : null;
            $this->price = $menu_edit->price ? $menu_edit->price : null;
            $this->showTextarea = $menu_edit->sorm == 0 ? false : true ;
            $this->priority = $menu_edit->priority;
            $this->status = $menu_edit->status;
            $this->imgReader = $menu_edit->img;
        } else {
            return redirect()->to('/rest');
        }
    }
 
    public function updateFood()
    {
  
        if($this->objectName == null){
            $this->objectName = $this->imgReader;
        } 

        $validatedData = $this->validate();

        $sorm = $this->showTextarea ? 1 : 0;
        $optionsData = $this->showTextarea ? json_encode(json_encode($this->options)) : null;
        // Update the Food record
        Food::where('id', $this->food_update->id)->update([
            'cat_id' => $validatedData['cat_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'sorm' => $sorm,
            'options' => $optionsData,
            'old_price' => isset($validatedData['oldPrice']) ? $validatedData['oldPrice'] : null,
            'price' => isset($validatedData['price']) ? $validatedData['price'] : null,
            'img' => isset($this->objectName) ? $this->objectName : $this->imgReader,
        ]);
    
        // Create or update the Foods_Translator records
        $menu = Food::find($this->food_update->id);
        foreach ($this->filteredLocales as $locale) {
            Food_Translator::updateOrCreate(
                [
                    'food_id' => $menu->id, 
                    'lang' => $locale
                ],
                [
                    'name' => $this->names[$locale],
                    'description' => $this->description[$locale],
                ]
            );
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Updated Successfully')]);
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
            $this->dispatchBrowserEvent('fixx');
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
            $this->description[$locale] = "";
        }
        $this->cat_id = '';
        $this->status = '';
        $this->priority = '';
        $this->imgReader = '';
        $this->food_selected_id_delete = '';
        $this->food_selected_name_delete = '';
        $this->showTextTemp = '';
        $this->foodNameToDelete = '';
        $this->price = '';
        $this->oldPrice = '';
        $this->confirmDelete = false;
        $this->initializeOptions();
        $this->imgFlag = false;
    }
 


    public function resetFilter(){
        $this->search = '';
        $this->categorieFilter = '';
        $this->statusFilter = '';
        $this->optionFilter = '';
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

    // ... Other component logic ...
    public function toggleTextarea()
    {
        $this->showTextarea = !$this->showTextarea;
        $this->emit('toggleTextarea');
    }

    public function render()
    {
        // START GET THE Category NAMES
        $this->menu_select = Categories::with(['translation' => function ($query) {
            $query->where('locale', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->orderBy('id', 'DESC')
        ->get();
        // END GET THE Category NAMES

        $colspan = 5;
        $cols_th = ['#','Menu','Name','Price','Old Price','Multi','Image','Status','Priority','Actions'];
        $cols_td = ['id','category.translation.name', 'translation.name','price','old_price','sorm','img','status','priority'];

        $data = Food::with(['category', 'translation', 'category.translation' => function ($query) {
            $query->where('locale', $this->glang);
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
            ->when($this->optionFilter !== '', function ($query) {
                $query->whereHas('translation', function ($query) {
                    $query->where('sorm', $this->optionFilter);
                });
            })
            ->paginate(10);

        return view('dashboard.livewire.food-table', 
        [
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'menu_select' => $this->menu_select,
            //asdsad
            'imgReader' => $this->imgReader
        ])->with('alert', ['type' => 'info', 'message' => __('Menu Table Loaded')]);
    }
}