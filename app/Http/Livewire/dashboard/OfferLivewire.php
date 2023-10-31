<?php
 
namespace App\Http\Livewire\dashboard;
 
use Exception;
use App\Models\Offer;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Offer_Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\rest\TelegramOfferNew;
use Illuminate\Support\Facades\Notification;
use App\Notifications\rest\TelegramOfferShort;
use App\Notifications\rest\TelegramOfferDelete;
use App\Notifications\rest\TelegramOfferUpdate;

class OfferLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;
 
    protected $paginationTheme = 'bootstrap';
 
    //general
    public $lang;
    public $glang;
    public $offer_id;
    public $offer_selected_id;
    public $offer_selected_id_delete;
    public $offer_selected_name_delete;
    public $offer_update;
    //utility
    public $search = '';
    public $categorieFilter = '';
    public $statusFilter = '';
    public $optionFilter = '';
    public $filteredLocales;
    //Form Data
    public $imgFlag = false; 
    public $objectName; 
    public $offerNameToDelete;
    public $names = [];
    public $description = [];
    public $status;
    public $priority;
    public $price = '';
    public $oldPrice = '';
    public $tempImg;

    public $confirmDelete = false;
    public $foodNameToDelete = '';
    public $showTextTemp = '';

    protected $listeners = [
        'updateCroppedOfferImg' => 'handleCroppedImage',
        'simulationCompleteImgOffer' => 'handlesimulationCompleteImg',
    ];

    public $default_link;
    public $telegram_channel_status;
    public $telegram_channel_link;
    public $view_business_name;
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
            $rules['description.' . $locale] = 'required|string|min:2';
        }
        $rules['priority'] = ['required'];
        $rules['status'] = ['required'];
        $rules['objectName'] = ['required'];
        return $rules;
    } // END FUNCTION OF RULES & VALIDATION

    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/' . auth()->user()->name . '/offer/' . auth()->user()->name.'_offer_'.date('Ydm') . $microtime . '.jpeg';
            $this->tempImg = $base64data;
            $this->dispatchBrowserEvent('fakeProgressBarOffer');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    } // END FUNCTION OF HANDLING THE CROPPED COVER

    public function saveOffer()
    {
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


            $offer = Offer::create([
                'user_id' => auth()->id(),
                'priority' => $validatedData['priority'],
                'price' => $this->price ? $this->price : null,
                'old_price' => $this->oldPrice ? $this->oldPrice : null,
                'status' => $validatedData['status'],
                'img' => $this->objectName,
            ]);
    
            foreach ($this->filteredLocales as $locale) {
                Offer_Translator::create([
                    'offer_id' => $offer->id,
                    'name' => $this->names[$locale],
                    'description' => $this->description[$locale],
                    'lang' => $locale,
                ]);
            }

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramOfferNew(
                        $offer->id,
                        $this->names['en'],
                        $this->price,
                        $this->oldPrice,
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
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Offer Inserted')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please refreash The Page CODE...OFF-ADD')]);
        }
    } // END FUNCTION OF SAVING OFFER
    
    public $imgReader;
    public $old_offer_data;
    public function editOffer(int $offer_selected)
    {
        $offer_edit = Offer::find($offer_selected);
        $this->offer_update = $offer_edit;

        if ($offer_edit) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Offer_Translator::where('offer_id', $offer_edit->id)
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
            $this->oldPrice = $offer_edit->old_price ? $offer_edit->old_price : null;
            $this->price = $offer_edit->price ? $offer_edit->price : null;
            $this->priority = $offer_edit->priority;
            $this->status = $offer_edit->status;
            $this->imgReader = $offer_edit->img;

            $this->old_offer_data = [
                'id' => $offer_edit->id,
                'locales' => $this->filteredLocales,
                'names' => $this->names,
                'oldPrice' => $offer_edit->old_price ? $offer_edit->old_price : null,
                'price' => $offer_edit->price ? $offer_edit->price : null,
                'status' => $offer_edit->status,
                'priority' => $offer_edit->priority,
                'img' => $this->default_link.$this->imgReader,
            ];
        } else {
            return redirect()->to('/rest/offer');
        }
    } // END FUNCTION OF SELECTING ITEM TO EDIT
 
    public function updateOffer()
    {
        if($this->objectName == null){
            $this->objectName = $this->imgReader;
            $this->tempImg = $this->imgReader;
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

        // Update the Food record
        Offer::where('id', $this->offer_update->id)->update([
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'price' => $this->price ? $this->price : null,
            'old_price' => $this->oldPrice ? $this->oldPrice : null,
            'img' => isset($this->objectName) ? $this->objectName : $this->imgReader,
        ]);
    
        // Create or update the Foods_Translator records
        $menu = Offer::find($this->offer_update->id);
        foreach ($this->filteredLocales as $locale) {
            Offer_Translator::updateOrCreate(
                [
                    'offer_id' => $menu->id, 
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
                Notification::route('toTelegram', null)
                ->notify(new TelegramOfferUpdate(
                    $this->old_offer_data,
                    $menu->id,
                    $this->names,
                    $this->price,
                    $this->oldPrice,
                    $this->status,
                    $this->priority,
                    $this->default_link.$this->objectName,
                    $this->telegram_channel_link,
                    $this->view_business_name
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Updated Successfully')]);
    } else {
        $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please Relaod The Page CODE...OFF-UPT')]);
    }
}

    //// QUICK ACTIONS
    public function updateStatus(int $offer_id)
    {
        $offerState = Offer::find($offer_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $offerState->status = $offerState->status == 0 ? 1 : 0;

        if($this->telegram_channel_status == 1){
            try{
                $this->editOffer($offer_id);
                Notification::route('toTelegram', null)
                ->notify(new TelegramOfferShort(
                    $this->old_offer_data,
                    $offerState->id,
                    $this->names,
                    $offerState->status,
                    $this->priority,
                    $this->telegram_channel_link,
                    $this->view_business_name
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $offerState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Status Updated Successfully')]);
    } // END OF FUNCTION UPDATING STATUS

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Offer::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;

            if($this->telegram_channel_status == 1){
                try{
                    $this->editOffer($p_id);
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramOfferShort(
                        $this->old_offer_data,
                        $varr->id,
                        $this->names,
                        $varr->status,
                        $varr->priority,
                        $this->telegram_channel_link,
                        $this->view_business_name
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
     
    public $offerDelete;
    public function deleteOffer(int $offer_selected_id)
    {
        $this->offer_selected_id_delete = Offer::find($offer_selected_id);
        $this->offer_selected_name_delete = Offer_Translator::where('offer_id', $offer_selected_id)->where('lang', $this->glang)->first()->name ?? "DELETE";
        if($this->offer_selected_name_delete) {
            $this->offerDelete = $this->offer_selected_name_delete;
            $this->showTextTemp = $this->offer_selected_name_delete;
            $this->confirmDelete = true;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }

    } // END OF FUNCTION SELECTING ITEM TO DELETE

    public function destroyOffer()
    {
        try{
            if ($this->confirmDelete && $this->offerNameToDelete === $this->showTextTemp) {
                $offerDelete = Offer::find($this->offer_selected_id_delete->id)->first();
                Offer::find($this->offer_selected_id_delete->id)->delete();
                Storage::disk('s3')->delete($this->offer_selected_id_delete->img);
                $this->offer_selected_id_delete = null;
                $this->offer_selected_name_delete = null;
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInput();
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Deleted Successfully')]);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild')]);
                return;
            }
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramOfferDelete(
                        $offerDelete->id,
                        $this->offerDelete,
                        $this->telegram_channel_link,
                        $this->view_business_name,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->offer_selected_id_delete = null;
            $this->offer_selected_name_delete = null;
            $this->showTextTemp = null;
            $this->confirmDelete = null;
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
        }
    } // END OF FUNCTION DELETING ITEM
 
    ////AFTER PROCEESS FUNCTIONS
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
        $this->status = '';
        $this->priority = '';
        $this->imgReader = '';
        $this->offer_selected_id_delete = '';
        $this->offer_selected_name_delete = '';
        $this->showTextTemp = '';
        $this->offerNameToDelete = '';
        $this->price = '';
        $this->oldPrice = '';
        $this->confirmDelete = false;
        $this->imgFlag = false;
        $this->objectName = '';
        $this->tempImg = null;
    } // END FUNCTION OF RESET INPUT
 
    public function resetFilter(){
        $this->search = '';
        $this->categorieFilter = '';
        $this->statusFilter = '';
        $this->optionFilter = '';
    } // END FUNCTION OF RESET FILTERS

    ////DISPATCH OR VIEW FUNCTIONS
    public function handlesimulationCompleteImg(){
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Image is Ready To Upload')]);
    } //END OF HANDLES SIMULATION OF IMG
    
    ////RENDER
    public function render()
    {
        $colspan = 5;
        $cols_th = ['#','Offer Name','Price','Old Price','Image','Status','Priority','Actions'];
        $cols_td = ['id','translation.name','price','old_price','img','status','priority'];

        $data = Offer::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->whereHas('translation', function ($query) {
            $query->
                where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('offer_id', 'like', '%' . $this->search . '%');
            });
        })
        ->orderBy('priority', 'ASC')
        ->paginate(10);

        return view('dashboard.livewire.offer-table', 
        [
            'items' => $data, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'emptyImg' => app('fixedimage_640x360'),
            'imgReader' => $this->imgReader
        ])->with('alert', ['type' => 'info', 'message' => __('Menu Table Loaded')]);
    }
}