<?php
 
namespace App\Http\Livewire\owner;

use App\Models\Food;
use App\Models\Plan;
use App\Models\User;
use App\Models\Tracker;
// use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Categories;
use App\Models\TrackFoods;
use App\Exports\UsersExport;
use App\Models\PlanChange;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
 
class DashboardLivewire extends Component
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


    
    public function export($locale){
        return Excel::download(new UsersExport($locale), 'users.xlsx');
    }
    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');

        if (Auth::check()) {
            $this->availableYears = $this->getAvailableYears();
            $this->selectedYear = now()->year; // Initialize with the current year
            $this->loadChartData($this->selectedYear);

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
    // private function loadChartData($selectedYear)
    // {
    //     // Fetch chart data based on the selected year
    //     $this->chartData = [
    //         // Fetch visits data for the selected year
    //         'timePlan' => PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
    //             // ->where('business_name', $businessName)
    //             ->whereYear('change_date', $selectedYear)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get(),

    //         'demoPlan' => PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
    //             // ->where('business_name', $businessName)
    //             ->whereYear('change_date', $selectedYear)
    //             ->where('new_plan_id', 1)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get(),

    //         // Fetch visits data for the selected year
    //         'planOne' => PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
    //             // ->where('business_name', $businessName)
    //             ->whereYear('change_date', $selectedYear)
    //             ->where('new_plan_id', 2)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get(),

    //         'planTwo' => PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
    //             // ->where('business_name', $businessName)
    //             ->whereYear('change_date', $selectedYear)
    //             ->where('new_plan_id', 3)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get(),

    //         'planThree' => PlanChange::selectRaw('DATE_FORMAT(change_date, "%Y-%m") as month, COUNT(*) as count')
    //             // ->where('business_name', $businessName)
    //             ->whereYear('change_date', $selectedYear)
    //             ->where('new_plan_id', 4)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get(),
    //     ];
    // }
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
            $this->topCategories(auth()->user()->name);
            $this->topFoods(auth()->user()->name);
        }
// dd( $this->totalDemoUsers);
        return view('dashboard.livewire.owner.dashboard-view',[
            'visit_lifetime' => $this->totalVisitsLifetime,
            'visit_monthly' => $this->totalVisitsPerMonth[0]['total_visits'] ?? 0,
            'count_category' => $this->totalCategories,
            'count_food' => $this->totalFoods,
            'chartData' => $this->chartData,
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
        ]);
    }
}