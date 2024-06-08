<?php
 
namespace App\Http\Livewire\Dashboard;
 
use App\Models\Food;
use Livewire\Component;
use App\Models\Categories;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Food_Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Rest\TelegramFoodNew;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Rest\TelegramFoodShort;
use App\Notifications\Rest\TelegramFoodDelete;
use App\Notifications\Rest\TelegramFoodUpdate;

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
    public $confirmDelete = false;
    public $foodNameToDelete = '';
    public $showTextTemp = '';
    //Form Data
    public $imgFlag = false; 
    public $objectName; 
    public $menu_select;
    public $cat_id;
    public $names = [];
    public $description = [];
    public $options = [];
    public $status;
    public $special;
    public $priority;
    public $showTextarea = false;
    public $price = '';
    public $oldPrice = '';

    protected $listeners = [
        'updateCroppedFoodImg' => 'handleCroppedImage',
        'simulationCompleteImgFood' => 'handlesimulationCompleteImg',
    ];

    //// ON LOAD
    public $default_link;
    public $telegram_channel_status;
    public $telegram_channel_link;
    public $view_business_name;
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->default_link = app('cloudfront');
        // Check if the user is authenticated before querying the database
        if (auth()->check()) {
            $userSettings = Auth::user()->settings;
            $this->telegram_channel_status = $userSettings ? $userSettings->telegram_notify_status : null;
            $this->telegram_channel_link = $userSettings ? $userSettings->telegram_notify : null;
            $this->view_business_name = Auth::user()->name;
        }
        $this->initializeOptions();
    } //END FUNCTION OF MOUNT

    public function initializeOptions()
    {
        foreach ($this->filteredLocales as $locale) {
            $this->options[$locale] = [];
            for ($i = 0; $i < 3; $i++) {
                $this->options[$locale][] = ['key' => '', 'value' => ''];
            }
        }
    } //END FUNCTION OF INITIALIZE OPTION OF FOOD

    protected function rules()
    {
        $rules = [];
        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
            // $rules['description.' . $locale] = 'required|string|min:2';
        }
        $rules['cat_id'] = ['required'];
        $rules['priority'] = ['required'];
        $rules['status'] = ['required'];
        $rules['special'] = ['required'];
        $rules['objectName'] = ['required'];
        return $rules;
    } // END FUNCTION OF RULES & VALIDATION

    public $tempImg;
    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/' . auth()->user()->name . '/food/' . auth()->user()->name.'_food_'.date('Ydm') . $microtime . '.jpeg';
            $this->tempImg = $base64data;
            $this->dispatchBrowserEvent('fakeProgressBarFood');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }

    public $galleryFTab = [];
    public function fetchGallery(){
        if(empty($this->galleryTab)){
            $galleries = Storage::disk('s3')->directories('mine-setting/gallery/food');
            foreach ($galleries as $gallery) {
                $filesInFolder = Storage::disk('s3')->files($gallery);
                $this->galleryFTab[$gallery] = $filesInFolder;
            }
        }
    }

    public function focusImage($imageUrl)
    {
        $this->tempImg = app('cloudfront') . $imageUrl;
        $this->objectName = $imageUrl;
        $this->dispatchBrowserEvent('close-mini-modal');
    }

    public function saveFood()
    {
        $validatedData = $this->validate();
        if($validatedData){

            $sorm = $this->showTextarea ? 1 : 0;
            $optionsData = $this->showTextarea == false ? null : json_encode($this->options);
            // $startsWith = Str::startsWith($this->objectName, 'mine-setting/');
            // dd($startsWith); // Should output true
            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));
                    // dd($this->objectName, $this->imgReader);
                    if($this->imgReader){
                        if (Str::startsWith($this->imgReader, 'mine-setting/')) {
                            //Do nothing
                        } else {
                            Storage::disk('s3')->delete($this->imgReader);
                        }

                    } else {
                        if (Str::startsWith($this->objectName, 'mine-setting/')) {
                            // Do Nothing
                        } else {
                            Storage::disk('s3')->put($this->objectName, $croppedImage);
                        }
                    }
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...CAT-ADD-IMG')]);
                    return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
            }

            $food = Food::create([
                'user_id' => auth()->id(),
                'cat_id' => $validatedData['cat_id'],
                'priority' => $validatedData['priority'],
                'price' => $this->price ? $this->price : null,
                'old_price' => $this->oldPrice ? $this->oldPrice : null,
                'options' =>  $optionsData,
                'sorm' => $sorm,
                'status' => $validatedData['status'],
                'special' => $validatedData['special'],
                'img' => $this->objectName,
            ]);
    
            foreach ($this->filteredLocales as $locale) {
                Food_Translator::create([
                    'food_id' => $food->id,
                    'name' => $this->names[$locale],
                    'description' => $this->description[$locale] ?? null,
                    'lang' => $locale,
                ]);
            }

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramFoodNew(
                        $food->id,
                        $this->names['en'],
                        $validatedData['cat_id'],
                        $this->price,
                        $this->oldPrice,
                        $validatedData['special'],
                        $this->default_link.$this->objectName,
                        $this->telegram_channel_link,
                        $this->view_business_name
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            
            $this->objectName = null;
            $this->resetInput();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Food Inserted')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please refreash The Page CODE...FOD-ADD')]);
        }
    } // END FUNCTION OF SAVING FOOD
    
    public $imgReader;
    public $old_food_data;
    public function editFood(int $menu_selected)
    {
        $this->imgReader = null;
        $food_edit = Food::find($menu_selected);
        $this->food_update = $food_edit;

        $this->old_food_data = [];

        if ($food_edit) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Food_Translator::where('food_id', $food_edit->id)
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

            $options = json_decode($food_edit->options, true);
            if ($options === null) {
                $this->initializeOptions();
            } else {
                $this->options = $options;
            }

            $this->cat_id = $food_edit->cat_id;
            $this->oldPrice = $food_edit->old_price ? $food_edit->old_price : null;
            $this->price = $food_edit->price ? $food_edit->price : null;
            $this->showTextarea = $food_edit->sorm == 0 ? false : true ;
            $this->priority = $food_edit->priority;
            $this->status = $food_edit->status;
            $this->special = $food_edit->special;
            $this->imgReader = $food_edit->img;

            $this->old_food_data = [
                'id' => $food_edit->id,
                'cat_id' => $food_edit->cat_id,
                'locales' => $this->filteredLocales,
                'names' => $this->names,
                'oldPrice' => $food_edit->old_price ? $food_edit->old_price : null,
                'price' => $food_edit->price ? $food_edit->price : null,
                'sorm' => $food_edit->sorm,
                'status' => $food_edit->status,
                'priority' => $food_edit->priority,
                'special' => $food_edit->special,
                'img' => $this->default_link.$this->imgReader,
                'options' => $this->options = $options,
            ];
        } else {
            return redirect()->to('/rest/food');
        }
    }
 
    public $new_category_name;
    public $old_category_name;
    public function updateFood()
    {
        if($this->objectName == null){
            $this->objectName = $this->imgReader;
            // $this->tempImg = $this->imgReader;
        } 
        // $this->tempImg =  $this->objectName;
        
        $validatedData = $this->validate();

        if($validatedData){

            $sorm = $this->showTextarea ? 1 : 0;
            $optionsData = $this->showTextarea ? json_encode(json_encode($this->options)) : null;


            try {
                if($this->tempImg) {
                    $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));

                    if( $this->imgReader){
                        if (Str::startsWith($this->imgReader, 'mine-setting/')) {
                            //Do nothing
                        } else {
                            Storage::disk('s3')->delete($this->imgReader);
                            Storage::disk('s3')->put($this->objectName, $croppedImage);
                        }
                    } else {
                        if (Str::startsWith($this->objectName, 'mine-setting/')) {
                            // Do Nothing
                        } else {
                            Storage::disk('s3')->put($this->objectName, $croppedImage);
                        }                    
                    }
                } else {
                    // $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...CAT-ADD-IMG')]);
                    // return;
                }
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
            }

            // Update the Food record
            Food::where('id', $this->food_update->id)->update([
                'cat_id' => $validatedData['cat_id'],
                'priority' => $validatedData['priority'],
                'status' => $validatedData['status'],
                'special' => $validatedData['special'],
                'sorm' => $sorm,
                'options' => $optionsData,
                'price' => !empty($this->price) ? $this->price : null,
                'old_price' => !empty($this->oldPrice) ? $this->oldPrice : null,
                'img' => isset($this->objectName) ? $this->objectName : $this->imgReader,
            ]);
        
            // Create or update the Foods_Translator records
            $food = Food::find($this->food_update->id);
            foreach ($this->filteredLocales as $locale) {
                Food_Translator::updateOrCreate(
                    [
                        'food_id' => $food->id, 
                        'lang' => $locale
                    ],
                    [
                        'name' => $this->names[$locale],
                        'description' => $this->description[$locale],
                    ]
                );
            }

            if($this->telegram_channel_status == 1){
                try{
                    $this->old_category_name =  Categories::with(['translation' => function ($query) {
                        $query->where('locale', 'en');
                    }])
                    ->where('user_id', Auth::id())
                    ->where('id', $this->old_food_data['cat_id'])
                    ->first()->translation->name;
    
                    $this->new_category_name =  Categories::with(['translation' => function ($query) {
                        $query->where('locale', 'en');
                    }])
                    ->where('user_id', Auth::id())
                    ->where('id', $validatedData['cat_id'])
                    ->first()->translation->name;
    
                    $img = isset($this->objectName) ? $this->objectName : $this->imgReader;
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramFoodUpdate(
                        $this->old_food_data,
                        $food->id,
                        $validatedData['cat_id'],
                        $this->names,
                        $this->old_category_name,
                        $this->new_category_name,
                        $sorm,
                        $this->status,
                        $this->priority,
                        $this->special,
                        $this->price,
                        $this->oldPrice,
                        $this->options,
                        $this->default_link.$img,
                        $this->telegram_channel_link,
                        $this->view_business_name,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->imgReader = null;
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please Relaod The Page CODE...-UPT')]);
        }
    } // END OF FUNCTION UPDATE ITEM

    ////QUICK ACTIONS
    public function closeModal()
    {
        $this->resetInput();
    } // END FUNCTION OF CLOSE MODAL
 
    public function resetInput()
    {
        foreach ($this->filteredLocales as $locale) {
            $this->names[$locale] = "";
            $this->description[$locale] = "";
        }
        $this->cat_id = '';
        $this->status = '';
        $this->special = '';
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
        $this->objectName = '';
        $this->tempImg = null;
    } // END FUNCTION OF RESET INPUT

    public function resetFilter(){
        $this->search = '';
        $this->categorieFilter = '';
        $this->statusFilter = '';
        $this->optionFilter = '';
    } // END OF FUNCTION RESETING FILTER

    public function toggleTextarea()
    {
        $this->showTextarea = !$this->showTextarea;
        $this->emit('toggleTextarea');
    } // END FUNCTION OF SWITCHING BETWEEN SINGLE PRICE & MULTI PRICE

    // } // ADDING NEW OPTION
    public $flag = false;
    public function addOptionForAllAndLocale($locale)
    {
        try {
            if ($locale == 'all') {
            foreach ($this->filteredLocales as $locale) {
                $this->options[$locale][] = ['key' => '', 'value' => ''];
            }
            $this->flag = true;
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('New Option Added')]);

            } else {
            // Check if the specified locale is in the filtered locales
            if (in_array($locale, $this->filteredLocales)) {
                $this->options[$locale][] = ['key' => '', 'value' => ''];
                if($this->flag == false) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('If Did Not Add You May Need To Click Again')]);
                    $this->flag = true;
                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('New Option For Specific Locale Added')]);
                }
            }

            }
    
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Something Went Wrong With Adding Option CODE...OPT-ADD')]);
        }
    }

    public function removeOption($locale, $index)
    {
        try{
            unset($this->options[$locale][$index]);
            $this->options[$locale] = array_values($this->options[$locale]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Option Removed')]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Something Went Wrong With Removing Option CODE...OPT-REM')]);
        } 
    } // REMOVING SELECTED OPTION

    public function setSamePriceForAllLocales($locale, $index)
    {
        try{
            $price = $this->options[$locale][$index]['value'];
            foreach ($this->filteredLocales as $otherLocale) {
                $this->options[$otherLocale][$index]['value'] = $price;
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Something Went Wrong With Price Parity CODE...OPT-E=P')]);
        } 
    } // END FUNCTION OF MAKING SAME VALUE FOR EACH LOCALE

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Food::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;

            if($this->telegram_channel_status == 1){
                try{
                    $this->editFood($p_id);
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramFoodShort(
                        $this->old_food_data,
                        $varr->id,
                        $varr->cat_id,
                        $this->names,
                        null,
                        $varr->priority,
                        null,
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

    public function updateStatus(int $food_id)
    {
        $foodState = Food::find($food_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $foodState->status = $foodState->status == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{
                $this->editFood($food_id);
                Notification::route('toTelegram', null)
                ->notify(new TelegramFoodShort(
                    $this->old_food_data,
                    $foodState->id,
                    $foodState->cat_id,
                    $this->names,
                    $foodState->status,
                    $this->priority,
                    $this->special,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $foodState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public function updateSpecial(int $food_id)
    {
        $foodSpecial = Food::find($food_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $foodSpecial->special = $foodSpecial->special == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{
                $this->editFood($food_id);
                Notification::route('toTelegram', null)
                ->notify(new TelegramFoodShort(
                    $this->old_food_data,
                    $foodSpecial->id,
                    $foodSpecial->cat_id,
                    $this->names,
                    $this->status,
                    $this->priority,
                    $foodSpecial->special,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $foodSpecial->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Offer Switch Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public $nameDelete;
    public function deleteFood(int $food_selected_id)
    {
        $this->food_selected_id_delete = Food::find($food_selected_id);
        $this->food_selected_name_delete = Food_Translator::where('food_id', $food_selected_id)->where('lang', $this->glang)->first()->name ?? "DELETE";
        if($this->food_selected_name_delete){
            $this->nameDelete = $this->food_selected_name_delete;
            $this->showTextTemp = $this->food_selected_name_delete;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }

    } // END OF FUNCTION SELECTING ITEM TO DELETE

    public function destroyfood()
    {
        try {
            if ($this->confirmDelete && $this->foodNameToDelete === $this->showTextTemp) {
                $foodDelete = Food::find($this->food_selected_id_delete->id)->first();
                Food::find($this->food_selected_id_delete->id)->delete();
                if (Str::startsWith($this->food_selected_id_delete->img, 'mine-setting/')) {
                    //Do nothing
                } else {
                    Storage::disk('s3')->delete($this->food_selected_id_delete->img);
                }
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInput();
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Food Deleted Successfully')]);

                if($this->telegram_channel_status == 1){
                    try{
                        Notification::route('toTelegram', null)
                        ->notify(new TelegramFoodDelete(
                            $foodDelete->id,
                            $foodDelete->cat_id,
                            $this->nameDelete,
                            $this->telegram_channel_link,
                            $this->view_business_name,
                        ));
                        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                    }  catch (\Exception $e) {
                        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                    }
                }
                $this->food_selected_id_delete = null;
                $this->food_selected_name_delete = null;
                $this->nameDelete = null;
                $this->showTextTemp = null;
                $this->confirmDelete = null;
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild')]);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
        }
    } // END OF FUNCTION DELETING ITEM

    ////DISPATCH OR VIEW FUNCTIONS
    public function handlesimulationCompleteImg(){
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Image is Ready To Upload')]);
    } //END OF HANDLES SIMULATION OF IMG

    ////RENDER
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
        $cols_th = ['#','Menu','Name','Price','Old Price','Multi','Rate','Image','Status','Priority','Actions'];
        $cols_td = ['id','category.translation.name', 'translation.name','price','old_price','sorm','foodRatings.foodRatings_avg_rating','img','status','priority'];

        $data = Food::with(['category', 'foodRatings' ,'translation', 'category.translation' => function ($query) {
            $query->where('locale', $this->glang);
        }, 'translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])->where('user_id', Auth::id())
        ->leftJoin('food_translators', function ($join) {
            $join->on('food.id', '=', 'food_translators.food_id')
                ->where('food_translators.lang', '=', $this->glang);
        })
        
        ->where(function ($query) {
            $query->where('food_translators.name', 'like', '%' . $this->search . '%')
                ->orWhereNull('food_translators.name');
        })
        ->when($this->categorieFilter !== '', function ($query) {
            $query->whereHas('category.translation', function ($query) {
                $query->where('name', $this->categorieFilter);
            });
        })
        ->when($this->statusFilter !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('translation.status', $this->statusFilter)
                    ->orWhereNull('translation.status');
            });
        })
        ->orderBy('priority', 'ASC')
        ->when($this->optionFilter !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('translation.sorm', $this->optionFilter)
                    ->orWhereNull('translation.sorm');
            });
        })
        ->withAvg('foodRatings', 'rating') // Include average rating
        ->withCount('foodRatings')
        ->select('food.id as food_id', 'food.*') // Select the food table ID
        ->paginate(10);

        // dd($data);

        return view('dashboard.livewire.food-table', 
        [
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'menu_select' => $this->menu_select,
            'emptyImg' => app('fixedimage_640x360'),
            //asdsad
            'imgReader' => $this->imgReader
        ])->with('alert', ['type' => 'info', 'message' => __('Menu Table Loaded')]);
    } // END OF FUNCTION RENDER
}