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
use Illuminate\Support\Facades\Notification;
use App\Notifications\rest\TelegramCategoryNew;
use App\Notifications\rest\TelegramCategoryDelete;
use App\Notifications\rest\TelegramCategoryUpdate;
use App\Notifications\rest\TelegramCategoryUpdateStatus;
use App\Notifications\rest\TelegramCategoryUpdatePriority;

class CategoryLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;
 
    protected $paginationTheme = 'bootstrap';
    //General
    public $lang;
    public $glang;
    public $category_id;
    public $category_selected_id;
    public $category_selected_id_delete;
    public $category_selected_name_delete;
    public $category_update;
    //Form Data
    public $menu_select;
    public $menu_id;
    public $names = [];
    public $status;
    public $priority;
    //IMG INFO
    public $imgReader;
    public $objectName;
    public $tempImg; 
    public $objectNameCover;
    public $imgReaderCover;
    public $tempImgCover;
    //utility
    public $search = '';
    public $mainmenuFilter = '';
    public $statusFilter = '';
    public $filteredLocales;
    public $confirmDelete = false;
    public $categoryNameToDelete = '';
    public $showTextTemp = '';
    // LISTENERS
    protected $listeners = [
        'updateCroppedCategoryImg' => 'handleCroppedImage',
        'updateCroppedCategoryImgCover' => 'handleCroppedImageCover',
        'simulationCompleteImg' => 'handlesimulationCompleteImg',
        'simulationCompleteCover' => 'handlesimulationCompleteCover'
    ];

    //// ON LOAD
    public $telegram_channel_link;
    public $telegram_channel_status;
    public $view_business_name;
    public $default_link;
    public $menu_name;
    public $old_menu_name;
    public $new_menu_name;
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->default_link = app('cloudfront');
        if (auth()->check()) {
            $userSettings = Auth::user()->settings;
            $this->telegram_channel_status = $userSettings ? $userSettings->telegram_notify_status : null;
            $this->telegram_channel_link = $userSettings ? $userSettings->telegram_notify : null;
            $this->view_business_name = Auth::user()->name;
        }
    } //END FUNCTION OF MOUNT

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
    } // END FUNCTION OF RULES & VALIDATION

    //// MAIN ENGIN
    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/menu/1' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $this->tempImg = $base64data;
            $this->dispatchBrowserEvent('fakeProgressBarImg');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    } // END FUNCTION OF HANDLING THE CROPPED IMG

    public function handleCroppedImageCover($base64dataCover)
    {
        if ($base64dataCover){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectNameCover = 'rest/menu/cover_' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $this->tempImgCover = $base64dataCover;
            $this->dispatchBrowserEvent('fakeProgressBarCover');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    } // END FUNCTION OF HANDLING THE CROPPED COVER

    public function saveCategory()
    {
        //Validate The Neccessary Data
        $validatedData = $this->validate();

        if($validatedData){
            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));

                    if( $this->imgReader){
                        Storage::disk('s3')->delete($this->imgReader);
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    } else {
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...CAT-ADD-IMG')]);
                    return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred during image upload: ' . $e->getMessage())]);
            }

            if($this->tempImgCover) {
                $croppedImageCover = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',  $this->tempImgCover));
                try {
                    if( $this->imgReaderCover){
                        Storage::disk('s3')->delete($this->imgReaderCover);
                        Storage::disk('s3')->put($this->objectNameCover, $croppedImageCover);
                    } else {
                        Storage::disk('s3')->put($this->objectNameCover, $croppedImageCover);
                    }
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred during image upload: ' . $e->getMessage())]);
                }
            } 

           
        $menu = Categories::create([
            'user_id' => auth()->id(),
            'menu_id' => $validatedData['menu_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => $this->objectName,
            'cover' => $this->objectNameCover ?? null,
        ]);
    
        foreach ($this->filteredLocales as $locale) {
            Categories_Translator::create([
                'cat_id' => $menu->id,
                'name' => $this->names[$locale],
                'locale' => $locale,
            ]);
        }

        
        if($this->telegram_channel_status == 1){
            try{
                $this->menu_name =  Mainmenu::with(['translation' => function ($query) {
                    $query->where('lang', 'en');
                }])
                ->where('user_id', Auth::id())
                ->where('id', $validatedData['menu_id'])
                ->first()->translation->name;
                Notification::route('toTelegram', null)
                ->notify(new TelegramCategoryNew(
                    $menu->id,
                    $this->menu_name,
                    $this->names['en'],
                    $this->default_link.$this->objectName,
                    $this->telegram_channel_link,
                    $this->view_business_name
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Category Inserted')]);
        } else {
        $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please refreash The Page CODE...CAT-ADD')]);
        }
    } // END FUNCTION OF SAVING CATEGORY
    
    public $old_category_data;
    public function editCategory(int $menu_selected)
    {
        $this->tempImgCover = null;
        $this->imgReaderCover = null;

        $menu_edit = Categories::find($menu_selected);
        $this->category_update = $menu_edit;

        $this->old_category_data = [];

        if ($menu_edit) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Categories_Translator::where('cat_id', $menu_edit->id)
                    ->where('locale', $locale)
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
            $this->imgReaderCover = $menu_edit->cover;

            $this->old_category_data = [
                'id' => $menu_edit->id,
                'menu_id' => $menu_edit->menu_id,
                'locales' => $this->filteredLocales,
                'names' => $this->names,
                'status' => $menu_edit->status,
                'priority' => $menu_edit->priority,
                'img' => $this->default_link.$this->imgReader,
            ];
        } else {
            return redirect()->to('/rest/category');
        }
    } // END OF FUNCTION SELECTING ITEM TO EDIT
 
    public function updateCategory()
    {
        if($this->objectName == null){
            $this->objectName = $this->imgReader;
            $this->tempImg = $this->imgReader;
        } 
        if($this->objectNameCover == null){
            $this->objectNameCover = $this->imgReaderCover;
            $this->tempImgCover = $this->imgReaderCover;
        } 
        // $this->tempImg =  $this->objectName;

        $validatedData = $this->validate();


        if($validatedData){
            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));

                    if( $this->imgReader){
                        Storage::disk('s3')->delete($this->imgReader);
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    } else {
                        Storage::disk('s3')->put($this->objectName, $croppedImage);
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...CAT-ADD-IMG')]);
                    return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred during image upload: ' . $e->getMessage())]);
            }

            if($this->tempImgCover) {
                $croppedImageCover = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',  $this->tempImgCover));
                try {
                    if( $this->imgReaderCover){
                        Storage::disk('s3')->delete($this->imgReaderCover);
                        Storage::disk('s3')->put($this->objectNameCover, $croppedImageCover);
                    } else {
                        Storage::disk('s3')->put($this->objectNameCover, $croppedImageCover);
                    }
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred during image upload: ' . $e->getMessage())]);
                }
            } 
            // dd($this->tempImg, $croppedImage, $this->tempImgCover, $croppedImageCover);
        // Update the Categories record
        Categories::where('id', $this->category_update->id)->update([
            'menu_id' => $validatedData['menu_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'img' => isset($this->objectName) ? $this->objectName : $this->imgReader,
            'cover' =>isset($this->objectNameCover) ? $this->objectNameCover : $this->imgReaderCover,
        ]);
    
        // Create or update the Categories_Translator records
        $menu = Categories::find($this->category_update->id);
        foreach ($this->filteredLocales as $locale) {
            Categories_Translator::updateOrCreate(
                [
                    'cat_id' => $menu->id, 
                    'locale' => $locale
                ],
                [
                    'name' => $this->names[$locale],
                ]
            );
        }
        if($this->telegram_channel_status == 1){
            try{
                $this->old_menu_name =  Mainmenu::with(['translation' => function ($query) {
                    $query->where('lang', 'en');
                }])
                ->where('user_id', Auth::id())
                ->where('id', $this->old_category_data['menu_id'])
                ->first()->translation->name;

                $this->new_menu_name =  Mainmenu::with(['translation' => function ($query) {
                    $query->where('lang', 'en');
                }])
                ->where('user_id', Auth::id())
                ->where('id', $validatedData['menu_id'])
                ->first()->translation->name;

                $img = isset($this->objectName) ? $this->objectName : $this->imgReader;
                Notification::route('toTelegram', null)
                ->notify(new TelegramCategoryUpdate(
                    $this->old_category_data,
                    $menu->id,
                    $this->names,
                    $this->status,
                    $this->priority,
                    $this->default_link.$img,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                    $this->old_menu_name,
                    $this->new_menu_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Updated Successfully')]);
    } else {
        $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please Relaod The Page CODE...CAT-UPT')]);
    }
    } // END OF FUNCTION UPDATE ITEM

    ////QUICK ACTIONS
    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Categories::find($p_id);
        if ($varr) {
            $this->editCategory($p_id);
            $varr->priority = $updatedPriority;
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramCategoryUpdatePriority(
                        $this->old_category_data,
                        $varr->id,
                        $this->names,
                        $varr->priority,
                        $this->telegram_channel_link,
                        $this->view_business_name,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $varr->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Priority Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Priority Did Not Update')]);
        }
    } // END FUNCTION OF UPDATING PRIOEITY

    public function updateStatus(int $category_id)
    {
        $menuState = Categories::find($category_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $this->editCategory($category_id);
        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramCategoryUpdateStatus(
                    $this->old_category_data,
                    $menuState->id,
                    $this->names,
                    $menuState->status,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }


        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Status Updated Successfully')]);
    } // END OF FUNCTION UPDATING STATUS

    public function resetFilter(){
        $this->search = '';
        $this->mainmenuFilter = '';
        $this->statusFilter = '';
    } // END OF FUNCTION RESETING FILTER

    public $idd;
    public function deleteCategory(int $category_selected_id)
    {
        $this->idd = $category_selected_id;
        $this->category_selected_id_delete = Categories::find($category_selected_id);
        $this->category_selected_name_delete = Categories_Translator::where('cat_id', $category_selected_id)->where('locale', $this->glang)->first()->name ?? "DELETE";
        if($this->category_selected_name_delete){
            $this->showTextTemp = $this->category_selected_name_delete;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    } // END OF FUNCTION SELECTING ITEM TO DELETE

    public function destroycategory()
    {
        try{
            if ($this->confirmDelete && $this->categoryNameToDelete === $this->showTextTemp) {
                Categories::find($this->category_selected_id_delete->id)->delete();
                Storage::disk('s3')->delete($this->category_selected_id_delete->img);
                $this->category_selected_id_delete = null;
                $this->category_selected_name_delete = null;
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInput();
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Deleted Successfully')]);

                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramCategoryDelete(
                        $this->idd,
                        $this->categoryNameToDelete,
                        $this->telegram_channel_link,
                        $this->view_business_name,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
                $this->idd = null;
                $this->category_selected_id_delete = null;
                $this->category_selected_name_delete = null;
                $this->showTextTemp = null;
                $this->confirmDelete = null;
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Operation Failed, Make sure of the name CODE...DEL-NAME, The name:') . ' ' . $this->showTextTemp]);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
        }
    } // END OF FUNCTION DELETING ITEM

    public function deleteCoverCategory()
    {
        try{
            Categories::where('id', $this->category_update->id)->update([
                'cover' => null,
            ]);
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Category Cover Image Deleted Successfully')]);
        } catch (\Exception) {
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Something Went Wrong, CODE...DEL-CVR')]);
        }
    } //END OF DELETING COVER

    ////AFTER PROCEESS FUNCTIONS
    public function closeModal()
    {
        $this->resetInput();
    } // END FUNCTION OF CLOSE MODAL
 
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
        $this->objectName = '';
        $this->objectNameCover = '';
        $this->tempImg = null;
        $this->tempImgCover = null;
    } // END FUNCTION OF RESET INPUT

    ////DISPATCH OR VIEW FUNCTIONS
    public function handlesimulationCompleteImg(){
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Image is Ready To Upload')]);
    } //END OF HANDLES SIMULATION OF IMG

    public function handlesimulationCompleteCover(){
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Cover is Ready To Upload')]);
    } //END OF HANDLES SIMULATION OF COVER

    ////RENDER
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
        $cols_th = ['#','Menu','Name','Image','Cover','Status','Priority','Actions'];
        $cols_td = ['id','mainmenu.translation.name', 'translation.name','img','cover','status','priority'];

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
            'emptyImg' => app('fixedimage_640x360'),
            'fl' => $this->imgReader
        ])->with('alert', ['type' => 'info',  'message' => __('Category Table Loaded')]);
    } // END OF FUNCTION RENDER
}