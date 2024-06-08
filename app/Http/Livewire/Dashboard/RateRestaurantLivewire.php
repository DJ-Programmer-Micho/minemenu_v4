<?php
 
namespace App\Http\Livewire\Dashboard;
 
use Livewire\Component;
use App\Models\RestRating;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

 
class RateRestaurantLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
 
    public $search = '';
    public $optionFilter = '';
    public $glang;
    public $filteredLocales;
    public $lang;
    public $overallRate;

    //Reviews Rest
    public $reviewData;

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
        $this->overallRate = $this->overallAvg();
    }

    private function overallAvg(){
        $data = RestRating::selectRaw('AVG(staff + service + environment + experience + cleaning) AS overall_average')
            ->where('user_id',  Auth::id())
            ->first();

        return $data->overall_average / 5;
    }

    public function render()
    {
        $colspan = 6;
        $cols_th = ['#', 'First Name', 'Last Name', 'Birth','Phone','Notes','Ratings', 'Average']; // Headers
        $cols_td = ['id', 'customer.first_name', 'customer.last_name', 'customer.dob','customer.phone','note','ratings','average']; // Table columns
    
        // Fetch the data with the necessary relationships and conditions
        $query = RestRating::with(['customer'])
        ->select('rest_ratings.*', DB::raw('(staff + service + environment + experience + cleaning) / 5 as average'))
        ->where('user_id', Auth::id())
        ->whereHas('customer', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->orWhere('dob', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->orWhere('note', 'like', '%' . $this->search . '%');
        });
    
    if ($this->optionFilter !== '') {
        switch ($this->optionFilter) {
            case '2':
                $query->havingRaw('average > 0 AND average <= 1.9');
                break;
            case '3':
                $query->havingRaw('average > 1.9 AND average <= 2.9');
                break;
            case '4':
                $query->havingRaw('average > 2.9 AND average <= 3.9');
                break;
            case '4.9':
                $query->havingRaw('average > 3.9 AND average <= 4.9');
                break;
            case '5':
                $query->havingRaw('average = 5');
                break;
        }
    }
    
    $data = $query->orderBy('created_at', 'DESC')->paginate(10);
        
        // Transform data to include ratings and average rating
        $items = $data->map(function ($item) {
            $ratings = [
                'staff' => $item->staff ?? 0,
                'service' => $item->service ?? 0,
                'environment' => $item->environment ?? 0,
                'experience' => $item->experience ?? 0,
                'cleaning' => $item->cleaning ?? 0,
            ];
    
            $average = array_sum($ratings) / count($ratings);
    
            return [
                'id' => $item->id,
                'customer' => $item->customer,
                'ratings' => $ratings,
                'note' => $item->note,
                'average' => number_format($average, 2),
            ];
        });


        $paginatedItems = new LengthAwarePaginator(
            $items,
            $data->total(),
            $data->perPage(),
            $data->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
        // dd($items);
        // Return the view with the necessary data
        return view('dashboard.livewire.rest-rating-table', [
            'items' => $paginatedItems,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
        ]);
    }
    

}