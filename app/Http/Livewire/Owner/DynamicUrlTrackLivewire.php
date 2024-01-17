<?php
 
namespace App\Http\Livewire\Owner;

use Livewire\Component;
use App\Models\AdsTracker;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
 
class DynamicUrlTrackLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $glang;
    public $filteredLocales;
    public $currentYear;
    public $selectedYear = null;
    public $selectedMonth = 'all';
    public $availableYears;
    public $chartData;
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

    protected $listeners = [
        'dateRangeSelected' => 'applyDateRangeFilter',
    ];

    public function mount()
    {
        // $this->glang = app('glang');
        // $this->filteredLocales = app('userlanguage');
        $this->selectedYear = now()->year;
        $this->fetchLineChartData($this->selectedYear,  null);

    }

    public function applyDateRangeFilter()
    {
        return $this->dateRange;
    }

     private function dynamicUrl()
    {
        if (Auth::check()) {
            // try {
                $dynamicUrlQuery = AdsTracker::query() ?? [];
    
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

    public $lineChartData;
    public function updatedselectedYear()
    {

        if ($this->selectedMonth === null || $this->selectedMonth === '') {
            $this->lineChartData = [];
            $this->fetchLineChartData($this->selectedYear, null);
        } else {
            $this->fetchLineChartData($this->selectedYear, $this->selectedMonth);
        }
    

        $this->dispatchBrowserEvent('lineChartDataUpdated', $this->lineChartData);
        
    }

    public function updatedselectedMonth()
    {
        $this->fetchLineChartData($this->selectedYear ?? now()->year, $this->selectedMonth);
        $this->dispatchBrowserEvent('lineChartDataUpdated',  $this->lineChartData);  
    }

    public function fetchLineChartData($year_selected_param, $month_selected_param)
    {
        $lineChartData = null;
        // Fetch data from the database
        $lineChartData = AdsTracker::select([
            DB::raw('DATE_FORMAT(visit_date, "%Y-%m-%d") as day_date'),
            'name',
            DB::raw('COUNT(*) as count')
        ])
        ->whereYear('visit_date', '=', $year_selected_param)
        ->groupBy('day_date', 'name')
        ->get();
    
        // Initialize an array to store data for each day in each month
        $daysInMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $yearMonth = sprintf('%04d-%02d', $year_selected_param, $month);
            $daysInMonth[$yearMonth] = array_fill(1, cal_days_in_month(CAL_GREGORIAN, $month, $year_selected_param), 0);
        }
    
        // Process the data and fill in the counts for each day
        $this->lineChartData = $lineChartData->groupBy('name')->map(function ($data, $name) use (&$daysInMonth) {
            // Reset daily counts for each iteration
            $dailyCountsByMonth = $daysInMonth;
    
            // Fill in the counts based on the received data
            foreach ($data as $item) {
                $yearMonth = substr($item['day_date'], 0, 7);
                $day = intval(substr($item['day_date'], -2));
                $dailyCountsByMonth[$yearMonth][$day] = $item['count'];
            }
    
            return [
                'label' => $name,
                'data' => $dailyCountsByMonth,
            ];
        })->values();

    }
    
    public function render()
    {
        $finalSummry = $this->dynamicUrl() ?? [];
        $cols_th = ['#', 'Name', 'Redirect URL', 'IPv4', 'Device Name', 'Visit Date', 'Visit Time'];
        $cols_td = ['id', 'name', 'redirect_url', 'ip_Address', 'device_identifier', 'visit_date', 'visit_time'];

        return view('dashboard.livewire.owner.dynamic-url-track-table',[
            'items' => $finalSummry, 
            'cols_th' => $cols_th, 
            'cols_td' => $cols_td,
            // Filter Send
            'planFilter_send' => $this->planFilter ?? null,
            'searchFilter_send' => $this->searchFilter ?? null,
            'dateRange_send' => $this->dateRange ?? null,
        ]);
    }
}