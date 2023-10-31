<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Food;
use App\Models\Plan;
use App\Models\Tracker;
use Livewire\Component;
// use Livewire\WithPagination;
use App\Models\Categories;
use App\Models\TrackFoods;
use App\Exports\UsersExport;
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
            $this->loadChartData($this->selectedYear, auth()->user()->name);

            // dd(auth()->user()->profile);
            $this->profile['avatar'] = app('cloudfront') . (auth()->user()->settings->background_img_avatar ?? 'mine-setting/user.png');
            $this->profile['restName'] = auth()->user()->name;
            $this->profile['name'] = auth()->user()->profile->fullname;
            $this->profile['email'] = auth()->user()->email;
            $this->profile['phone'] = auth()->user()->profile->phone;
            $this->profile['country'] = auth()->user()->profile->country;
            $this->profile['create'] = auth()->user()->subscription->start_at;
            $this->profile['expire'] = auth()->user()->subscription->expire_at;
            $this->profile['plan_id'] = auth()->user()->subscription->plan_id;
            $plan_name = Plan::where('id',  auth()->user()->subscription->plan_id)
            ->first();

            $this->profile['plan_name'] = $plan_name->name[$this->glang];
        }
    }

    // SOME TRACKING FUNCTIONS TO COUNT
    private function getTotalVisitsLifetime($businessName)
    {
        return Tracker::where('business_name', $businessName)->count();
    }

    private function getTotalVisitsPerMonth($businessName)
    {
        $currentMonth = now()->format('Y-m');
        return Tracker::selectRaw('DATE_FORMAT(visit_date, "%Y-%m") as month, COUNT(*) as total_visits')
            ->where('business_name', $businessName)
            ->whereRaw('DATE_FORMAT(visit_date, "%Y-%m") = ?', [$currentMonth])
            ->groupBy('month')
            ->get();
    }
    private function getTotalCategories($id)
    {
        return Categories::where('user_id', $id)->count();
    }
    private function getTotalFoods($id)
    {
        return Food::where('user_id', $id)->count();
    }
    private function getAvailableYears()
    {
        // Fetch unique years from the Tracker table
        return Tracker::where('business_name', auth()->user()->name)
            ->distinct()
            ->pluck('visit_date')
            ->map(function ($date) {
                return date('Y', strtotime($date));
            })
            ->unique()
            ->toArray();
    }
    private function loadChartData($selectedYear,$businessName)
    {
        // Fetch chart data based on the selected year
        $this->chartData = [
            // Fetch visits data for the selected year
            'visits' => Tracker::selectRaw('DATE_FORMAT(visit_date, "%Y-%m") as month, COUNT(*) as count')
                ->where('business_name', $businessName)
                ->whereYear('visit_date', $selectedYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

            // Fetch clicks in categories data for the selected year
            'categoryClicks' => TrackFoods::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->where('business_name_id', $businessName)
                ->where('food_id', null)
                ->whereYear('created_at', $selectedYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

            // Fetch clicks in food data for the selected year
            'foodClicks' => TrackFoods::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->where('business_name_id', $businessName)
                ->whereYear('created_at', $selectedYear)
                ->whereNotNull('food_id')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];
  
        
    }
    private function topCategories($businessName){
        try {
            $topCategories = TrackFoods::selectRaw('category_id, COUNT(*) as click_count')
                ->where('business_name_id', $businessName)
                ->where('food_id', null)
                ->groupBy('category_id')
                ->orderByDesc('click_count')
                ->limit(5)
                ->get();
    
            $maxClickCount = TrackFoods::where('business_name_id', $businessName)
                ->where('food_id', null)
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
    private function topFoods($businessName){
        $topFood = TrackFoods::selectRaw('food_id, COUNT(*) as click_count')
        ->where('business_name_id', $businessName)
        ->whereNotNull('food_id')
        ->groupBy('food_id')
        ->orderByDesc('click_count')
        ->limit(5)
        ->get();

        $maxClickCount = TrackFoods::where('business_name_id', $businessName)
        ->whereNotNull('food_id')
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
        $this->loadChartData($this->selectedYear, auth()->user()->name);
        $this->dispatchBrowserEvent('chartDataUpdated',  $this->chartData);
    }
    public function render()
    {
        if (Auth::check()) {
            $this->totalVisitsLifetime = $this->getTotalVisitsLifetime(auth()->user()->name);
            $this->totalVisitsPerMonth = $this->getTotalVisitsPerMonth(auth()->user()->name);
            $this->totalCategories = $this->getTotalCategories(auth()->user()->id);
            $this->totalFoods = $this->getTotalFoods(auth()->user()->id);
            $this->topCategories(auth()->user()->name);
            $this->topFoods(auth()->user()->name);
        }

        return view('dashboard.livewire.dashboard-view',[
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
            'profile' => $this->profile
        ]);
    }
}