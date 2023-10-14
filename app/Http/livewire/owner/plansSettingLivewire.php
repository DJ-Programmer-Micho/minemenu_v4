<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Plan;
use Livewire\Component;
 
class plansSettingLivewire extends Component
{
    public $glang;
    public $filteredLocales = ['en','ar','ku'];
    // Filters
    public $countryFilter = null;
    public $planFilter = null;
    public $searchFilter = null;
    public $dateRange = null;
    //Forms
    public $names = [];
    public $description = [];
    public $description_rest = [];
    public $description_onpay = [];
    public $exchange_rate;
    public $monthly_cost;
    public $duration;
    public $cost;
    public $status;
    public $priority;
    public $type;
    public $valid_date;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];

    public function mount()
    {
        $this->glang = app('glang');
    }

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

    public function resetFilter(){
        $this->planFilter = '';
        $this->searchFilter = '';
        $this->dateRange = '';
        $this->countryFilter = '';
    } // END OF FUNCTION RESETING FILTER

    protected function rules()
    {
        $rules = [];
        foreach ($this->filteredLocales as $locale) {
            $rules['names.' . $locale] = 'required|string|min:2';
            $rules['description.' . $locale] = 'required|string|min:2';
            $rules['description_rest.' . $locale] = 'required|string|min:2';
            $rules['description_onpay.' . $locale] = 'required|string|min:2';
            // $rules['description.' . $locale] = 'required|string|min:2';
        }
        $rules['duration'] = ['required'];
        $rules['exchange_rate'] = ['required'];
        $rules['status'] = ['required'];
        $rules['monthly_cost'] = ['required'];
        $rules['priority'] = ['required'];
        $rules['cost'] = ['required'];
        $rules['type'] = ['required'];

        if ($this->type == 'offer') {
            $rules['valid_date'] = ['required'];
        }
        return $rules;
    } // END FUNCTION OF RULES & VALIDATION

    public function savePlan()
    {
        $validatedData = $this->validate();
        if($validatedData){
            $names = [];
            $description = [];
            $description_rest = [];
            $description_onpay = [];
            foreach ($this->filteredLocales as $locale) {
                $names[$locale] = $this->names[$locale];
                $description[$locale] = $this->description[$locale];
                $description_rest[$locale] = $this->description_rest[$locale];
                $description_onpay[$locale] = $this->description_onpay[$locale];
            }
            // $asd = json_encode($translations);

            Plan::create([
                'name' => $names,
                'description' => $description,
                'description_rest' => $description_rest,
                'description_onpay' => $description_onpay,
                'duration' => $validatedData['duration'],
                'exchange_rate' => $validatedData['exchange_rate'],
                'monthly_cost' => $validatedData['monthly_cost'],
                'priority' => $validatedData['priority'],
                'status' => $validatedData['status'],
                'cost' => $validatedData['cost'],
                'type' => $validatedData['type'],
                'valid_date' => $validatedData['valid_date'] ?? null,
            ]);

            // $this->resetInput();
            // $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('New Plan Inserted')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Something Went Wrong, Please refreash The Page CODE...FOD-ADD')]);
        }
    } // END FUNCTION OF SAVING FOOD

    public function updatePriority(int $p_id, $updatedPriority){
        $varr = Plan::find($p_id);
        if ($varr) {
            $varr->priority = $updatedPriority;
            $varr->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Priority Updated Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Priority Did Not Update')]);
        }
    } // END FUNCTION OF UPDATING PRIOEITY

    public function updateStatus(int $plan_id)
    {
        $planStatus = Plan::find($plan_id);
        // Toggle the status (0 to 1 and 1 to 0)
        $planStatus->status = $planStatus->status == 0 ? 1 : 0;
        $planStatus->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Menu Status Updated Successfully')]);
    } // END FUNCTION OF UPDATING PRIOEITY

    public $plan_update;
    public function editPlan(int $plan_selected)
    {
        $plan_edit = Plan::find($plan_selected);
        $this->plan_update = $plan_edit->id;

        if ($plan_edit) {
            if($plan_edit->name){
                foreach ($plan_edit->name as $locale => $name) {
                    $this->names[$locale] = $name ?? '';
                }
            }
            if($plan_edit->description){
                foreach ($plan_edit->description as $locale => $description) {
                    $this->description[$locale] = $description ?? '';
                }
            }
            if($plan_edit->description_rest){
                foreach ($plan_edit->description_rest as $locale => $description_rest) {
                    $this->description_rest[$locale] = $description_rest ?? '';
                }
            }
            if($plan_edit->description_onpay){
                foreach ($plan_edit->description_onpay as $locale => $description_onpay) {
                    $this->description_onpay[$locale] = $description_onpay ?? '';
                }
            }

            $this->status = $plan_edit->status;
            $this->priority = $plan_edit->priority;
            $this->duration = $plan_edit->duration;
            $this->exchange_rate = $plan_edit->exchange_rate;
            $this->monthly_cost = $plan_edit->monthly_cost;
            $this->cost = $plan_edit->cost;
            $this->type = $plan_edit->type;
            $this->valid_date = $plan_edit->valid_date ?? null;
            $this->description_rest = $plan_edit->description_rest;
            $this->description_onpay = $plan_edit->description_onpay;

        } else {
            return redirect()->to('/own/plansetting');
        }
    }
 
    public function updatePlan()
    {
        $validatedData = $this->validate();

        if($validatedData){
            $names = [];
            $description = [];
            $description_rest = [];
            $description_onpay = [];
            foreach ($this->filteredLocales as $locale) {
                $names[$locale] = $this->names[$locale];
                $description[$locale] = $this->description[$locale];
                $description_rest[$locale] = $this->description_rest[$locale];
                $description_onpay[$locale] = $this->description_onpay[$locale];
            }

            Plan::where('id', $this->plan_update)->update([
                'name' => $names,
                'description' => $description,
                'description_rest' => $description_rest,
                'description_onpay' => $description_onpay,
                'duration' => $validatedData['duration'],
                'exchange_rate' => $validatedData['exchange_rate'],
                'monthly_cost' => $validatedData['monthly_cost'],
                'priority' => $validatedData['priority'],
                'status' => $validatedData['status'],
                'cost' => $validatedData['cost'],
                'type' => $validatedData['type'],
                'valid_date' => $validatedData['valid_date'] ?? null,
            ]);

            $this->dispatchBrowserEvent('close-modal');
            // $this->resetInput();
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
            }
            $this->exchange_rate= '';
            $this->monthly_cost= '';
            $this->duration= '';
            $this->cost= '';
            $this->type= '';
            $this->valid_date= '';
            $this->status= '';
            $this->priority= '';
            $this->description= '';
            $this->description_rest= '';
            $this->description_onpay= false;
        } // END FUNCTION OF RESET INPUT
        
    public function render()
    {

        // $data = Plan::with(['category', 'translation', 'category.translation' => function ($query) {
        //     $query->where('locale', $this->glang);
        // }, 'translation' => function ($query) {
        //     $query->where('lang', $this->glang);
        // }])->where('user_id', Auth::id())
        //     ->whereHas('translation', function ($query) {
        //         $query->where(function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%');
        //         });
        //     })
        //     ->when($this->categorieFilter !== '', function ($query) {
        //     $query->whereHas('category.translation', function ($query) {
        //         $query->where('name', $this->categorieFilter);
        //         });
        //     })
        //     ->when($this->statusFilter !== '', function ($query) {
        //         $query->whereHas('translation', function ($query) {
        //             $query->where('status', $this->statusFilter);
        //         });
        //     })->orderBy('priority', 'ASC')
        //     ->when($this->optionFilter !== '', function ($query) {
        //         $query->whereHas('translation', function ($query) {
        //             $query->where('sorm', $this->optionFilter);
        //         });
        //     })
        //     ->paginate(10);
        $colspan = 5;
        $cols_th = ['#','Plan Name','Duration','Cost','Exchange rate','Monthly Cost','Bundle Type','Status','Priority','Valid Date','Actions'];
        $cols_td = ['id','name', 'duration','cost','exchange_rate','monthly_cost','type','status','priority','valid_date'];


        $data = Plan::orderBy('priority', 'ASC')->get();
        // dd($data);
        return view('dashboard.livewire.owner.plan-setting',[
            'collections' => $data,
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            'colspan' => $colspan,
            'dateRange_send' => $this->dateRange ?? null,
        ]);
    }
}