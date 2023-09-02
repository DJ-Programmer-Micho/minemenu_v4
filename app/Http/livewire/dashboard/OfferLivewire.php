<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Offer;
use App\Models\Offer_Translator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

    protected $listeners = ['updateCroppedOfferImg' => 'handleCroppedImage'];

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
            $rules['description.' . $locale] = 'required|string|min:2';
        }
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

    public function saveOffer()
    {
        $validatedData = $this->validate();

        $menu = Offer::create([
            'user_id' => auth()->id(),
            'priority' => $validatedData['priority'],
            'price' => $this->price ? $this->price : null,
            // 'old_price' => $this->oldPrice ? $this->oldPrice : null,
            'status' => $validatedData['status'],
            'img' => $this->objectName,
        ]);

        foreach ($this->filteredLocales as $locale) {
            Offer_Translator::create([
                'offer_id' => $menu->id,
                'name' => $this->names[$locale],
                'description' => $this->description[$locale],
                'lang' => $locale,
            ]);
        }
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Offer Inserted')]);
    }
    
    public $imgReader;
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
            // $this->oldPrice = $menu_edit->old_price ? $menu_edit->old_price : null;
            $this->price = $offer_edit->price ? $offer_edit->price : null;
            $this->priority = $offer_edit->priority;
            $this->status = $offer_edit->status;
            $this->imgReader = $offer_edit->img;
        } else {
            return redirect()->to('/rest');
        }
    }
 
    public function updateOffer()
    {
  
        if($this->objectName == null){
            $this->objectName = $this->imgReader;
        } 

        $validatedData = $this->validate();

        // Update the Food record
        Offer::where('id', $this->offer_update->id)->update([
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            // 'old_price' => isset($validatedData['oldPrice']) ? $validatedData['oldPrice'] : null,
            'price' => isset($validatedData['price']) ? $validatedData['price'] : null,
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
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Updated Successfully')]);
    }

    public function updateStatus(int $offer_id)
    {
        $menuState = Offer::find($offer_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Offer Status Updated Successfully')]);
    }
     
    public $confirmDelete = false;
    public $foodNameToDelete = '';
    public $showTextTemp = '';

    public function deleteOffer(int $offer_selected_id)
    {
        $this->offer_selected_id_delete = Offer::find($offer_selected_id);
        $this->offer_selected_name_delete = Offer_Translator::where('offer_id', $offer_selected_id)->where('lang', $this->glang)->first();
        $this->showTextTemp = $this->food_selected_name_delete->name;
        $this->confirmDelete = true;
    }

    public function destroyfood()
    {
        if ($this->confirmDelete && $this->offerNameToDelete === $this->showTextTemp) {
            Offer::find($this->offer_selected_id_delete->id)->delete();
            Storage::disk('s3')->delete($this->offer_selected_id_delete->img);
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
        $this->status = '';
        $this->priority = '';
        $this->imgReader = '';
        $this->offer_selected_id_delete = '';
        $this->offer_selected_name_delete = '';
        $this->showTextTemp = '';
        $this->offerNameToDelete = '';
        $this->price = '';
        // $this->oldPrice = '';
        $this->confirmDelete = false;
        $this->imgFlag = false;
    }
 


    public function resetFilter(){
        $this->search = '';
        $this->categorieFilter = '';
        $this->statusFilter = '';
        $this->optionFilter = '';
    }

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Offer::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;
            $varr->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Priority Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Priority Did Not Update')]);
        }
    }

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
            'imgReader' => $this->imgReader
        ])->with('alert', ['type' => 'info', 'message' => __('Menu Table Loaded')]);
    }
}