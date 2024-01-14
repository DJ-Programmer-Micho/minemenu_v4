<?php
 
namespace App\Http\Livewire\Owner;

use App\Models\Ads;
use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
use App\Models\AdsTracker;
use App\Models\PlanChange;
use Livewire\WithPagination;
use App\Exports\UsersActivityExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
 
class DynamicUrlLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $glang;
    public $filteredLocales;
    public $currentYear;
    public $selectedYear;
    public $availableYears;
    public $chartData;
    public $sortedTopUsersInfo;
    public $defualt_img;
    public $defualt_link;
    public $general_link;
    public $tempDataModal;
    public $chartCountryData;
    // Filters
    public $planFilter = null;
    public $searchFilter = null;
    public $dateRange = null;
    //NEW
    public $qrId;
    public $qrName;
    public $qrOld;
    public $adName;
    public $redirect_url;
    public $qr_code;
    public $objectName;
    public $tempImg;
    public $confirmDelete = false;
    public $adNameToDelete = '';
    public $showTextTemp = '';
    public $ad_selected_id_delete;
    public $ad_selected_name_delete;

    protected $listeners = [
        'dateRangeSelected' => 'applyDateRangeFilter',
        'qrCodeUploader' => 'handleImage',
    ];

    public function export($planFilter_send,$searchFilter_send,$dateRange_send){
        return Excel::download(new UsersActivityExport($planFilter_send,$searchFilter_send,$dateRange_send), 'usersActivity.xlsx');
    }
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->defualt_img = app('no_data_img');
        $this->defualt_link = app('cloudfront');
        $this->general_link = env('APP_URL');

    }
    //NEW
    public function resetFilter(){
        $this->planFilter = '';
        $this->searchFilter = '';
        $this->dateRange = '';
    } // END OF FUNCTION RESETING FILTER

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

    protected function rules()
    {
        $rules = [];
        $rules['adName'] = ['required'];
        $rules['redirect_url'] = ['required'];
        // $rules['qr_code'] = ['required'];
    
        return $rules;
    }


    public function handleImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'mine-setting/qr_code_ad/' . auth()->user()->name.'_qr_'.date('Ydm') . $microtime . '.jpeg';
            $this->tempImg = $base64data;
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Ready to upload')]);

            // $this->dispatchBrowserEvent('fakeProgressBarFood');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }


    public function selectQr(int $id) {
        $this->qrOld = Ads::where('id', $id)->first()->qr_code;
        $this->qrName = '';
        $this->qrId = $id;
        $this->qrName = "ads/" . $id;
    }

    public function addQr() {
        try {
            if($this->tempImg) {
                $qrImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->tempImg));
                if($this->qrOld && $this->qrOld != $this->objectName) {
                    Storage::disk('s3')->delete($this->qrOld);
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Old Qr Removed successfully')]);

                }
                Storage::disk('s3')->put($this->objectName, $qrImage);

                Ads::where('id', $this->qrId)->update([
                    'qr_code' => $this->objectName ?? null,
                ]);

                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Qr Code Added')]);
                $this->qrId = '';
                $this->qrName = '';
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please reload The Page CODE...CAT-ADD-IMG')]);
                return;
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Try Reload the Page: ' . $e->getMessage())]);
        }
    }
    public function saveAd()
    {        
        // dd($this->validate());

        $validatedData = $this->validate();
        $ads = Ads::create([
            'name' => $validatedData['adName'],
            'redirect_url' => $validatedData['redirect_url'],
            'qr_code' => null,
        ]);
    
        // if($this->telegram_channel_status == 1){
        //     try{
        //         Notification::route('toTelegram', null)
        //         ->notify(new TelegramMenuNew(
        //             $menu->id,
        //             $this->names['en'],
        //             $this->telegram_channel_link,
        //             $this->view_business_name
        //         ));
        //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
        //     }  catch (\Exception $e) {
        //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
        //     }
        // }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('QR Code Ad Added Successfully')]);
        // $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }


    public $old_ad_data;
    public $ad_selected;
    public $status;

    public function editAd(int $ad_id)
    {

        $ad_edit = Ads::find($ad_id);
        $this->ad_selected = $ad_id;
        $this->adName = $ad_edit->name;
        $this->redirect_url = $ad_edit->redirect_url;
        // $this->status = $ad_edit->status;
        // $this->status = $ad_edit->status;

        $this->old_ad_data = [];

        if ($ad_edit) {
            $this->old_ad_data = null;

            $this->old_ad_data = [
                'id' => $ad_edit->id,
                'name' => $ad_edit->name,
                'redirect_url' => $ad_edit->redirect_url,
            ];
        } else {
            return redirect()->to('/dynamicurl');
        }
    }


    public function updateAd()
    {
        $validatedData = $this->validate();

        Ads::where('id', $this->ad_selected)->update([
            'redirect_url' => $validatedData['redirect_url'],
        ]);


        // if($this->telegram_channel_status == 1){
        //     try{
        //         Notification::route('toTelegram', null)
        //         ->notify(new TelegramMenuUpdate(
        //             $this->old_menu_data,
        //             $menu->id,
        //             $this->names,
        //             $this->status,
        //             $this->priority,
        //             $this->telegram_channel_link,
        //             $this->view_business_name,
        //         ));
        //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
        //     }  catch (\Exception $e) {
        //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
        //     }
        // }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Updated Successfully')]);
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }




    public function deleteAd(int $ad_selected_id)
    {
        $this->ad_selected_id_delete = Ads::find($ad_selected_id);
        $this->ad_selected_name_delete = $this->ad_selected_id_delete->name;
        if ($this->ad_selected_name_delete) {
            $this->showTextTemp = $this->ad_selected_name_delete;
            $this->confirmDelete = true;
        } else {
            // Handle the case where the record is not found
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Record Not Found')]);
        }
    }

    public function destroyAd()
    {
        if ($this->confirmDelete && $this->adNameToDelete === $this->showTextTemp) {
            Ads::find($this->ad_selected_id_delete->id)->delete();
            $this->dispatchBrowserEvent('close-modal');
            $this->closeModal();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Deleted Successfully')]);

            // if($this->telegram_channel_status == 1){
            //     try{
            //         Notification::route('toTelegram', null)
            //         ->notify(new TelegramMenuDelete(
            //             $this->menu_selected_id_delete->id,
            //             $this->menuNameToDelete,
            //             $this->telegram_channel_link,
            //             $this->view_business_name,
            //         ));
            //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
            //     }  catch (\Exception $e) {
            //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
            //     }
            // }
            $this->confirmDelete = false;
            $this->ad_selected_id_delete = null;
            $this->ad_selected_name_delete = null;
            $this->adNameToDelete = null;
            $this->showTextTemp = null;
            // $this->reloadData();
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Operaiton Faild')]);
        }
    }








    public function updateStatus(int $ad_id)
    {
        $adState = Ads::find($ad_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $adState->status = $adState->status == 0 ? 1 : 0;
        // $this->editMenu($adState->id);
        // if($this->telegram_channel_status == 1){
        //     try{
        //         Notification::route('toTelegram', null)
        //         ->notify(new TelegramMenuUpdate(
        //             $this->old_menu_data,
        //             $menuState->id,
        //             $this->names,
        //             $menuState->status,
        //             $this->priority,
        //             $this->telegram_channel_link,
        //             $this->view_business_name,
        //         ));
        //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
        //     }  catch (\Exception $e) {
        //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
        //     }
        // }
        $adState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);


    }
    public function updateVision(int $ad_id)
    {
        $adState = Ads::find($ad_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $adState->vision = $adState->vision == 0 ? 1 : 0;
        // $this->editMenu($adState->id);
        // if($this->telegram_channel_status == 1){
        //     try{
        //         Notification::route('toTelegram', null)
        //         ->notify(new TelegramMenuUpdate(
        //             $this->old_menu_data,
        //             $menuState->id,
        //             $this->names,
        //             $menuState->status,
        //             $this->priority,
        //             $this->telegram_channel_link,
        //             $this->view_business_name,
        //         ));
        //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Notification Send Successfully')]);
        //     }  catch (\Exception $e) {
        //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
        //     }
        // }
        $adState->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);


    }

    public function closeModal()
    {
        $this->resetInput();
    }
 
    public function resetInput()
    {
        $this->qrId = '';
        $this->qrName = '';
        $this->qrOld = '';
        $this->adName = '';
        $this->redirect_url = '';
        $this->qr_code = '';
        $this->objectName = '';
        $this->tempImg = '';
  
    }




     private function dynamicUrl()
    {
        if (Auth::check()) {
            // try {
                $dynamicUrlQuery = Ads::query() ?? [];
    
                // Apply filters
                if ($this->planFilter != '') {
                    // Apply category filter
                    $dynamicUrlQuery->whereHas('name', function ($query) {
                        $query->where('new_plan_id', $this->planFilter);
                    });
                }
    
                if ($this->searchFilter != '') {
                    // Apply category filter
                    $dynamicUrlQuery->whereHas('name', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchFilter . '%');
                    });
                }
    
                if ($this->dateRange) {
                    list($startDate, $endDate) = explode(' - ', $this->dateRange);
                    $dynamicUrlQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                $finalSummry = $dynamicUrlQuery->paginate(15);    
                
                return $finalSummry;
            // } catch (\Exception $e) {
                // dd('error');
                // Handle exceptions here
            // }
        }
    }
    public function checkDashboard($url)
    {
        $tempUser = User::where('id', $url)->first();

        $this->emit('clicked', $tempUser->name, 'aaaaaaaaa');
    }
    public function render()
    {
        $plans = Plan::get();
        $planNames = [];

        foreach ($plans as $plan) {
            $planNames[$plan->id] = $plan->name['en'] ?? 'Error';
        }
        $finalSummry = $this->dynamicUrl() ?? [];
        $cols_th = ['#', 'Name', 'URL', 'QR CODE', 'SCANS', 'Status', 'Vision', 'Date Time','Action'];
        $cols_td = ['id', 'name', 'redirect_url', 'qr_code', 'scans', 'status', 'vision', 'created_at','Action'];

        return view('dashboard.livewire.owner.dynamic-url-table',[
            'items' => $finalSummry, 
            'planNames' => $planNames,
            'default_link' => $this->defualt_link,
            'default_img' => $this->defualt_img,
            'general_link' => $this->general_link,
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            // Filter Send
            'planFilter_send' => $this->planFilter ?? null,
            'searchFilter_send' => $this->searchFilter ?? null,
            'dateRange_send' => $this->dateRange ?? null,
        ]);
    }
}