<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
use App\Models\PlanChange;
use Livewire\WithPagination;
use App\Exports\UsersActivityExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
 
class UserActivityLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $glang;
    public $filteredLocales;
    public $currentYear;
    public $selectedYear;
    public $availableYears;
    public $chartData;
    public $totalDemoUsers;
    public $totalOneMonthUsers;
    public $totalSixMonthUsers;
    public $totalOneYearUsers;
    public $totalActiveUsers;
    public $totalDeactiveUsers;
    public $totalExpireUsers;
    public $totalPendingUsers;
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

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];


    public function export($planFilter_send,$searchFilter_send,$dateRange_send){
        return Excel::download(new UsersActivityExport($planFilter_send,$searchFilter_send,$dateRange_send), 'usersActivity.xlsx');
    }
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->defualt_img = app('no_uknown_user');
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

     private function topFiveActions()
    {
        if (Auth::check()) {
            try {
                $topFiveActionsQuery = PlanChange::with(['user', 'user.profile', 'user.settings'])
                    ->orderBy('change_date', 'DESC');
    
                // Apply filters
                if ($this->planFilter != '') {
                    // Apply category filter
                    $topFiveActionsQuery->whereHas('user', function ($query) {
                        $query->where('new_plan_id', $this->planFilter);
                    });
                }
    
                if ($this->searchFilter != '') {
                    // Apply category filter
                    $topFiveActionsQuery->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchFilter . '%');
                    });
                }
    
                if ($this->dateRange) {
                    list($startDate, $endDate) = explode(' - ', $this->dateRange);
                    $topFiveActionsQuery->whereBetween('change_date', [$startDate, $endDate]);
                }
                $finalSummry = $topFiveActionsQuery->paginate(15);    
                
                return $finalSummry;
            } catch (\Exception $e) {
                // Handle exceptions here
            }
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
        $finalSummry = $this->topFiveActions();
        $cols_th = ['#', 'User ID', 'Business Name', 'Avatar', 'Old Plan ID', 'New Plan ID', 'Date Time','Action'];
        $cols_td = ['id', 'user_id', 'name', 'background_img_avatar', 'old_plan_id', 'new_plan_id', 'change_date','Action'];

        return view('dashboard.livewire.owner.user-activity-table',[
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