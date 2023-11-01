<?php
 
namespace App\Http\Livewire\Owner;

use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\UsersDataExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
 
class UserDataLivewire extends Component
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
    public $countryFilter = null;
    public $planFilter = null;
    public $searchFilter = null;
    public $dateRange = null;
    public $planSelect = null;

    protected $listeners = ['dateRangeSelected' => 'applyDateRangeFilter'];


    public function export($planFilter_send,$searchFilter_send,$dateRange_send,$countryFilter_send){
        return Excel::download(new UsersDataExport($planFilter_send,$searchFilter_send,$dateRange_send,$countryFilter_send), 'usersData.xlsx');
    }
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->defualt_img = app('no_uknown_user');
        $this->defualt_link = app('cloudfront');
        $this->general_link = env('APP_URL');
        $this->planSelect = $this->planSelectFilter();

    }
    //NEW
    public function resetFilter(){
        $this->planFilter = '';
        $this->searchFilter = '';
        $this->dateRange = '';
        $this->countryFilter = '';
    } // END OF FUNCTION RESETING FILTER

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

    private function planSelectFilter(){
        return Plan::get();
    }

    public $countUsers;
    private function topFiveActions()
    {
        if (Auth::check()) {
            try {
                $topFiveActionsQuery = User::with(['profile', 'settings','subscription'])
                ->where('role', 3)
                ->orderBy('created_at', 'DESC');

                // Apply filters
                if ($this->planFilter != '') {
                    $topFiveActionsQuery->whereHas('subscription', function ($query) {
                        $query->where('plan_id', $this->planFilter);
                    });
                }

                if ($this->countryFilter != '') {
                    $topFiveActionsQuery->whereHas('profile', function ($query) {
                        $query->where('country', $this->countryFilter);
                    });
                }
    
                if ($this->searchFilter != '') {
                    // Apply category filter to user->name
                    $topFiveActionsQuery->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->searchFilter . '%')
                            ->orWhereHas('profile', function ($subquery) {
                                $subquery->where('fullName', 'like', '%' . $this->searchFilter . '%');
                            })->orWhereHas('profile', function ($subquery) {
                                $subquery->where('country', 'like', '%' . $this->searchFilter . '%');
                            })->orWhereHas('profile', function ($subquery) {
                                $subquery->where('address', 'like', '%' . $this->searchFilter . '%');
                            });
                    });
                }
    
                if ($this->dateRange) {
                    list($startDate, $endDate) = explode(' - ', $this->dateRange);
                    $topFiveActionsQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                $this->countUsers = $topFiveActionsQuery->count();
                $finalSummry = $topFiveActionsQuery->paginate(5);    
                // dd($finalSummry);
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

        $uniqueCountries = Profile::distinct()->pluck('country')->filter()->values()->toArray();

        $finalSummry = $this->topFiveActions();
        $cols_th = ['#', 'User ID', 'Business Name', 'Avatar','Auther' ,'current', 'country',  'Date Time','Action'];
        $cols_td = ['id', 'user_id', 'name', 'background_img_avatar','author' ,'plan_id', 'country','created_at','Action'];

        return view('dashboard.livewire.owner.user-data-table',[
            'items' => $finalSummry, 
            'planNames' => $planNames,
            'default_link' => $this->defualt_link,
            'default_img' => $this->defualt_img,
            'general_link' => $this->general_link,
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            //Filters
            'counter' => $this->countUsers ?? null,
            'countryData' => $uniqueCountries ?? null,
            // Filter Send
            'countryFilter_send' => $this->countryFilter ?? null,
            'planFilter_send' => $this->planFilter ?? null,
            'searchFilter_send' => $this->searchFilter ?? null,
            'dateRange_send' => $this->dateRange ?? null,
        ]);
    }
}