<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Food;
use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
// use Livewire\WithPagination;
use App\Models\Tracker;
use Livewire\Component;
use App\Models\Categories;
use App\Models\PlanChange;
use App\Models\TrackFoods;
use App\Exports\UsersExport;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
 
class UserActivityLivewire extends Component
{
    public $glang;
    public $filteredLocales;
    public $totalVisitsLifetime;
    public $totalVisitsPerMonth;
    public $totalCategories;
    public $totalFoods;
    public $currentYear;
    public $selectedYear;
    public $categoryClicksData;
    public $foodClicksData;
    public $availableYears;
    public $chartData;
    public $categoriesWithNames;
    public $sumCategoryClick;
    public $topCategoriesStore;
    public $topCategories;
    public $foodWithNames;
    public $sumFoodClick;
    public $topFoodStore;
    public $topFood;
    public $profile = [];
    //new
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
    public $tempDataModal;
    public $chartCountryData;
    // public $topUsersInfo;


    
    public function export($locale){
        return Excel::download(new UsersExport($locale), 'users.xlsx');
    }
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $this->defualt_img = app('uknown_user');
        $this->defualt_link = app('cloudfront');

        if (Auth::check()) {
            $this->availableYears = $this->getAvailableYears();
            $this->selectedYear = now()->year; // Initialize with the current year
            $this->loadChartData($this->selectedYear);
            $this->loadChartCountryData(2023);

        //     // dd(auth()->user()->profile);
        //     $this->profile['avatar'] = app('cloudfront') . (auth()->user()->settings->background_img_avatar ?? 'mine-setting/user.png');
        //     $this->profile['restName'] = auth()->user()->name;
        //     $this->profile['name'] = auth()->user()->profile->fullname;
        //     $this->profile['email'] = auth()->user()->email;
        //     $this->profile['phone'] = auth()->user()->profile->phone;
        //     $this->profile['country'] = auth()->user()->profile->country;
        //     $this->profile['create'] = auth()->user()->subscription->start_at;
        //     $this->profile['expire'] = auth()->user()->subscription->expire_at;
        //     $this->profile['plan_id'] = auth()->user()->subscription->plan_id;
        //     $plan_name = Plan::where('id',  auth()->user()->subscription->plan_id)
        //     ->first();

        //     $this->profile['plan_name'] = $plan_name->name[$this->glang];
        }
    }
    //NEW
    private function getTotalDemoUsers() {
        return Subscription::where('plan_id', 1)->count() ?? 0;
    }
    private function getTotalOneMonthUsers() {
        return Subscription::where('plan_id', 2)->count() ?? 0;
    }
    private function getTotalSixMonthUsers() {
        return Subscription::where('plan_id', 3)->count() ?? 0;
    }
    private function getTotalOneYearUsers() {
        return Subscription::where('plan_id', 4)->count() ?? 0;
    }
    private function getTotalActiveUsers() {
        return User::where('role', 3)->where('status', 1)->count() ?? 0;
    }
    private function getTotalDeactiveUsers() {
        return User::where('role', 3)->where('status', 0)->count() ?? 0;
    }
    private function getTotalExpireUsers() {
        return Subscription::where('expire_at', '<=' , now() )->count() ?? 0;
    }
    private function getTotalPendingUsers() {
        return User::where('role', 3)
        ->where('email_verified', null)
        ->where('phone_verified', null)
        ->count() ?? 0;
    }

    // SOME TRACKING FUNCTIONS TO COUNT
    private function getTotalVisitsLifetime()
    {
        return Tracker::count();
    }

    private function getTotalVisitsPerMonth()
    {
        $currentMonth = now()->format('Y-m');
        return Tracker::selectRaw('DATE_FORMAT(visit_date, "%Y-%m") as month, COUNT(*) as total_visits')
            ->whereRaw('DATE_FORMAT(visit_date, "%Y-%m") = ?', [$currentMonth])
            ->groupBy('month')
            ->get();
    }
    private function getTotalCategories($id)
    {
        return Categories::count();
    }
    private function getTotalFoods($id)
    {
        return Food::count();
    }
    private function getAvailableYears()
    {
        // Fetch unique years from the Tracker table
        return PlanChange::distinct()
            ->pluck('change_date')
            ->map(function ($date) {
                return date('Y', strtotime($date));
            })
            ->unique()
            ->toArray();
    }

    private function loadChartData($selectedYear)
    {
        // Fetch chart data based on the selected year
        $this->chartData = [
            'timePlan' => $this->getChartDataForPlan($selectedYear, null),
            'demoPlan' => $this->getChartDataForPlan($selectedYear, 1),
            'planOne' => $this->getChartDataForPlan($selectedYear, 2),
            'planTwo' => $this->getChartDataForPlan($selectedYear, 3),
            'planThree' => $this->getChartDataForPlan($selectedYear, 4),
        ];
        // dd($this->chartData);
    }

    private function getChartDataForPlan($selectedYear, $planId)
    {
        $chartData = PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
            ->whereYear('change_date', $selectedYear);

        if ($planId !== null) {
            $chartData->where('new_plan_id', $planId);
        }

        $chartData = $chartData->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // Fill in missing months with counts of 0
        $monthsInYear = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthsInYear[sprintf('%04d-%02d', $selectedYear, $month)] = 0;
        }

        return array_replace($monthsInYear, $chartData);
    }

    private function loadChartCountryData($selectedYear)
    {
        // Fetch chart data based on the selected year
        $this->chartCountryData = [
            'timeCountry' => $this->getChartDataForCountry($selectedYear),
        ];
    }


    private function getChartDataForCountry($selectedYearCountry)
    {
        $subscriberData = User::with(['profile', 'subscription'])
            ->whereHas('subscription', function ($query) use ($selectedYearCountry) {
                $query->whereYear('created_at', $selectedYearCountry);
            })
            ->get();
    
        $monthlyCountryCounts = $subscriberData->filter(function ($subscriber) {
            return optional($subscriber->profile)->country !== null;
        })->groupBy(function ($subscriber) {
            return optional($subscriber->subscription->created_at)->format('Y-m');
        })->map(function ($group) {
            return $group->groupBy(function ($subscriber) {
                return optional($subscriber->profile)->country;
            })->map(function ($subGroup) {
                return count($subGroup);
            });
        });
    
        // Initialize an array to store sorted results
        $sortedChartData = [];
    
        for ($month = 1; $month <= 12; $month++) {
            $formattedMonth = sprintf('%04d-%02d', $selectedYearCountry, $month);
    
            if (!isset($monthlyCountryCounts[$formattedMonth])) {
                $monthlyCountryCounts[$formattedMonth] = [];
            }
    
            // Sort data by month and store it in the result array
            $sortedChartData[$formattedMonth] = $monthlyCountryCounts[$formattedMonth];
        }
    
        // Sort the array by keys to arrange the data by month
        // ksort($sortedChartData);
    
        // dd($this->chartCountryData,ksort($sortedChartData),$sortedChartData);
        return $sortedChartData;
    }


    private function topFiveActions()
    {
        try {

            // Get the top five actions ordered by change_date
            $topFiveActions = PlanChange::orderBy('change_date', 'DESC')
                ->limit(5)
                ->get();
    
            // Initialize an empty collection to store user information with PlanChange data
            $topUsersInfo = collect();
    
            // Fetch user information and PlanChange data based on each user ID
            foreach ($topFiveActions as $action) {
                $user = User::find($action->user_id);
    
                if ($user) {
                    $plan_old = Plan::find($action->old_plan_id);
                    $plan_new = Plan::find($action->new_plan_id);

                    if ($plan_old && $plan_new) {
                        // Decode the JSON field and access the 'en' key
                        $planNameOldEn = $plan_old->name['en'] ?? 'Error';
                        $planNameNewEn = $plan_new->name['en'] ?? 'Error';
                        // dd($user->settings->background_avatar_img);
                        if(isset($user->settings->background_img_avatar)){
                            if($user->settings->background_img_avatar != null){
                                $temp = $this->defualt_link.$user->settings->background_img_avatar;
                            } else {
                                $temp = $this->defualt_img;
                            }
                        } else {
                            $temp = $this->defualt_img;
                        }
                        $userInfo = [
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'background_avatar_img' => $temp,
                            'old_plan_id' => [$action->old_plan_id,$planNameOldEn],
                            'new_plan_id' => [$action->new_plan_id,$planNameNewEn],
                            'date_time' => $action->change_date
                        ];
    
                        $topUsersInfo->push($userInfo);
                    }
                }
            }
            $this->sortedTopUsersInfo = $topUsersInfo;
    
            // Now, $topUsersInfo contains the top user information with old_plan_id and new_plan_id
    
        } catch (\Exception $e) {
            // Handle exceptions here
        }
    }
    
    // public function checkUser($id){
    //     // try {
    //         $userData = User::select('id', 'name', 'email','status','email_verified','email_verified')->find($id);
    //         if (!$userData) {
    //             return response()->json(['error' => 'User not found'], 404);
    //         }
    //         $profileData = Profile::select('*')->where('user_id', $id)->first();
    //         $subscriptionData = Subscription::select('start_at', 'start_at')->where('user_id', $id)->first();
    
    //         if (!$profileData) {
    //             $profileData = [];
    //         }
        
    //         if (!$subscriptionData) {
    //             $subscriptionData = [];
    //         }
        
    //         $userData['profile'] = $profileData;
    //         $userData['subscription'] = $subscriptionData;
    //         $this->tempDataModal = $userData;
    //         // dd( $this->tempDataModal);
    //         // Return the combined data
    //         return response()->json(200);
    //     // } catch (\Exception $e) {
    //     //     // Handle exceptions here, such as database errors
    //     //     return response()->json(['error' => 'An error occurred'], 500);
    //     // }
        
    // }
    private function topCategories(){
        try {
            $topCategories = TrackFoods::selectRaw('category_id, COUNT(*) as click_count')
                ->where('food_id', null)
                ->groupBy('category_id')
                ->orderByDesc('click_count')
                ->limit(5)
                ->get();
    
            $maxClickCount = TrackFoods::where('food_id', null)
                ->count();
    
            $topCategoryIds = $topCategories->pluck('category_id')->toArray();
    
            $this->categoriesWithNames = Categories::whereIn('id', $topCategoryIds)
            ->with(['translation' => function ($query) {
                $query->where('locale', $this->glang);
            }])
            ->get()
            ->sortByDesc(function ($category) use ($topCategories) {
                // Sort the categories by click_count from $topCategories
                $clickCount = $topCategories->where('category_id', $category->id)->first()->click_count ?? 0;
                return $clickCount;
            });
                $this->sumCategoryClick = $maxClickCount;
                $this->topCategories = $topCategories;
                // dd($topCategoryIds,$this->categoriesWithNames,$this->sumCategoryClick,$this->topCategories);
        } catch (\Exception $e) {
            // Handle the exception, log the error, or return an error response as needed.
            // You can also rethrow the exception if you want it to propagate up the call stack.
            // Example: throw $e;
        }
    }
    private function topFoods(){
        $topFood = TrackFoods::selectRaw('food_id, COUNT(*) as click_count')
        ->whereNotNull('food_id')
        ->groupBy('food_id')
        ->orderByDesc('click_count')
        ->limit(5)
        ->get();

        $maxClickCount = TrackFoods::whereNotNull('food_id')
        ->count();

        $topFoodIds = $topFood->pluck('food_id')->toArray();

        $this->foodWithNames = Food::whereIn('id', $topFoodIds)
        ->with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->get()
        ->sortByDesc(function ($food) use ($topFood) {
            // Sort the foods by click_count from $topFood
            $clickCount = $topFood->where('food_id', $food->id)->first()->click_count ?? 0;
            return $clickCount;
        });

        $this->sumFoodClick = $maxClickCount;
        $this->topFood = $topFood;
        // dd($topFood,$this->foodWithNames);
    }

    public function updatedSelectedYear()
    {
        $this->loadChartData($this->selectedYear);
        $this->dispatchBrowserEvent('chartDataUpdated',  $this->chartData);
        
        $this->getChartDataForCountry(2023);
        $this->dispatchBrowserEvent('chartDataCountryUpdated',  $this->chartCountryData);
    }
    public function render()
    {
        if (Auth::check()) {
            //New
            $this->totalDemoUsers = $this->getTotalDemoUsers();
            $this->totalOneMonthUsers = $this->getTotalOneMonthUsers();
            $this->totalSixMonthUsers = $this->getTotalSixMonthUsers();
            $this->totalOneYearUsers = $this->getTotalOneYearUsers();
            $this->totalActiveUsers = $this->getTotalActiveUsers();
            $this->totalDeactiveUsers = $this->getTotalDeactiveUsers();
            $this->totalExpireUsers = $this->getTotalExpireUsers();
            $this->totalPendingUsers = $this->getTotalPendingUsers();
            //Old
            $this->totalVisitsLifetime = $this->getTotalVisitsLifetime(auth()->user()->name);
            $this->totalVisitsPerMonth = $this->getTotalVisitsPerMonth(auth()->user()->name);
            $this->totalCategories = $this->getTotalCategories(auth()->user()->id);
            $this->totalFoods = $this->getTotalFoods(auth()->user()->id);
            $this->topFiveActions();
            $this->topCategories(auth()->user()->name);
            $this->topFoods(auth()->user()->name);
        }
// dd( $this->totalDemoUsers);
        return view('dashboard.livewire.owner.dashboard-view',[
            'visit_lifetime' => $this->totalVisitsLifetime,
            'visit_monthly' => $this->totalVisitsPerMonth[0]['total_visits'] ?? 0,
            'count_category' => $this->totalCategories,
            'count_food' => $this->totalFoods,
            // 'chartData' => $this->chartData,
            'chartData' => 'asd',
            'topCategories' => $this->topCategories,
            'categoriesWithNames' => $this->categoriesWithNames,
            'sumCategoryClick' => $this->sumCategoryClick,
            'topFood' => $this->topFood,
            'foodWithNames' => $this->foodWithNames,
            'sumFoodClick' => $this->sumFoodClick,
            'profile' => $this->profile,
            // NEW
            'totalDemoUsers' => $this->totalDemoUsers,
            'totalOneMonthUsers' => $this->totalOneMonthUsers,
            'totalSixMonthUsers' => $this->totalSixMonthUsers,
            'totalOneYearUsers' => $this->totalOneYearUsers,
            'totalDeactiveUsers' => $this->totalDeactiveUsers,
            'totalExpireUsers' => $this->totalExpireUsers,
            'totalPendingUsers' => $this->totalPendingUsers,
            'tempDataModal' => $this->tempDataModal,
            'chartCountryData' => $this->chartCountryData,
        ]);
    }
}