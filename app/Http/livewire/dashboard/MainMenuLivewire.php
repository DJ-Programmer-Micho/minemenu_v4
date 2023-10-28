<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Mainmenu;
use Livewire\WithPagination;
use App\Models\Mainmenu_Translator;
use Illuminate\Support\Facades\Auth;
use App\Notifications\rest\TelegramMenuNew;
use Illuminate\Support\Facades\Notification;
use App\Notifications\rest\TelegramMenuDelete;
use App\Notifications\rest\TelegramMenuUpdate;
 
class MainMenuLivewire extends Component
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

    public $telegram_channel_link;
    public $telegram_channel_status;
    public $view_business_name;
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        if (auth()->check()) {
            $userSettings = Auth::user()->settings;
            $this->telegram_channel_status = $userSettings ? $userSettings->telegram_notify_status : null;
            $this->telegram_channel_link = $userSettings ? $userSettings->telegram_notify : null;
            $this->view_business_name = Auth::user()->name;
        }
    }

    protected function rules()
    {
        $rules = [];

        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
        }
        $rules['priority'] = ['required'];
        $rules['status'] = ['required'];
    
        return $rules;
    }
 
    public function saveMenu()
    {        $validatedData = $this->validate();

        $menu = Mainmenu::create([
            'user_id' => auth()->id(),
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
        ]);
    
        foreach ($this->filteredLocales as $locale) {
            Mainmenu_Translator::create([
                'menu_id' => $menu->id,
                'name' => $this->names[$locale],
                'lang' => $locale,
            ]);
        }

        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramMenuNew(
                    $menu->id,
                    $this->names['en'],
                    $this->telegram_channel_link,
                    $this->view_business_name
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Added Successfully')]);
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
     
    public $old_menu_data;
    public function editMenu(int $menu_selected)
    {
        $menu_edit = Mainmenu::find($menu_selected);
        $this->menu_update = $menu_edit;
        $this->priority = $menu_edit->priority;
        $this->status = $menu_edit->status;

        $this->old_menu_data = [];

        if ($menu_edit) {
            $this->old_menu_data = null;
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

            $this->old_menu_data = [
                'id' => $menu_edit->id,
                'locales' => $this->filteredLocales,
                'names' => $this->names,
                'status' => $menu_edit->status,
                'priority' => $menu_edit->priority,
            ];
        } else {
            return redirect()->to('/rest');
        }
    }
 
    public function updateMenu()
    {
        $validatedData = $this->validate();

        Mainmenu::where('id', $this->menu_update->id)->update([
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
        ]);

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

        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramMenuUpdate(
                    $this->old_menu_data,
                    $menu->id,
                    $this->names,
                    $this->status,
                    $this->priority,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Updated Successfully')]);
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function updateStatus(int $menu_id)
    {
        $menuState = Mainmenu::find($menu_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
        $this->editMenu($menuState->id);
        if($this->telegram_channel_status == 1){
            try{
                Notification::route('toTelegram', null)
                ->notify(new TelegramMenuUpdate(
                    $this->old_menu_data,
                    $menuState->id,
                    $this->names,
                    $menuState->status,
                    $this->priority,
                    $this->telegram_channel_link,
                    $this->view_business_name,
                ));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            }  catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            }
        }
        $menuState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);


    }
     
    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Mainmenu::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;
            $this->editMenu($varr->id);
            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramMenuUpdate(
                        $this->old_menu_data,
                        $varr->id,
                        $this->names,
                        $varr->status,
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
    }

    public $confirmDelete = false;
    public $menuNameToDelete = '';
    public $showTextTemp = '';
    public $menu_selected_id_delete;
    public $menu_selected_name_delete;

    public function deleteMenu(int $menu_selected_id)
    {
        $this->menu_selected_id_delete = Mainmenu::find($menu_selected_id);
        $this->menu_selected_name_delete = Mainmenu_Translator::where('menu_id', $menu_selected_id)->where('lang', $this->glang)->first();
        if ($this->menu_selected_name_delete) {
            $this->showTextTemp = $this->menu_selected_name_delete->name;
            $this->confirmDelete = true;
        } else {
            // Handle the case where the record is not found
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    }

    public function destroyMenu()
    {
        if ($this->confirmDelete && $this->menuNameToDelete === $this->showTextTemp) {
            Mainmenu::find($this->menu_selected_id_delete->id)->delete();
            $this->dispatchBrowserEvent('close-modal');
            $this->closeModal();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Deleted Successfully')]);

            if($this->telegram_channel_status == 1){
                try{
                    Notification::route('toTelegram', null)
                    ->notify(new TelegramMenuDelete(
                        $this->menu_selected_id_delete->id,
                        $this->menuNameToDelete,
                        $this->telegram_channel_link,
                        $this->view_business_name,
                    ));
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
                }  catch (\Exception $e) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
                }
            }
            $this->confirmDelete = false;
            $this->menu_selected_id_delete = null;
            $this->menu_selected_name_delete = null;
            $this->menuNameToDelete = null;
            $this->showTextTemp = null;
            // $this->reloadData();
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
            $this->status = '';
            $this->priority = '';
        }
    }
 
    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','Name','Priority','Status','actions'];
        $cols_td = ['id','translation.name','priority','status'];

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
        ->orderBy('priority', 'ASC')
        ->paginate(10);
        //$Menus = Menu::select('id','name','email','course')->get();
        return view('dashboard.livewire.menu-form', ['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    }
}