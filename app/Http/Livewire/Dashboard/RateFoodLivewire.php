<?php
 
namespace App\Http\Livewire\Dashboard;

use App\Models\FoodRating;
use Livewire\Component;
use App\Models\RestRating;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

 
class RateFoodLivewire extends Component
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
        // $this->overallRate = $this->overallAvg();
    }

    // private function overallAvg(){
    //     $data = FoodRating::selectRaw('AVG(rating) AS overall_average')
    //         ->where('user_id',  Auth::id())
    //         ->first();

    //     return $data->overall_average / 5;
    // }


    public function render()
    {
        $colspan = 8; // Adjust the colspan based on the number of columns
        $cols_th = ['#', 'First Name', 'Last Name', 'Birth', 'Phone', 'Food Name', 'Image', 'Ratings']; // Headers
        $cols_td = ['id', 'customer.first_name', 'customer.last_name', 'customer.dob', 'customer.phone', 'food.translation.name', 'food.img', 'rating']; // Table columns

        // Fetch the data with the necessary relationships and conditions
        $query = FoodRating::with(['customer', 'food.translation'])
            ->whereHas('food', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where(function ($query) {
                $query->whereHas('food.translation', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('customer', function ($query) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('dob', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            });

        // Apply option filter if provided
        if ($this->optionFilter !== '') {
            switch ($this->optionFilter) {
                case '2':
                    $query->whereBetween('rating', [0, 1.9]);
                    break;
                case '3':
                    $query->whereBetween('rating', [2, 2.9]);
                    break;
                case '4':
                    $query->whereBetween('rating', [3, 3.9]);
                    break;
                case '4.9':
                    $query->whereBetween('rating', [4, 4.9]);
                    break;
                case '5':
                    $query->where('rating', 5);
                    break;
            }
        }

        $data = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Transform data to include and average rating
        $items = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'customer' => $item->customer,
                'food' => $item->food,
                'rating' => number_format($item->rating, 2), // Assuming 'rating' is a column in FoodRating table
            ];
        });

        // Create a LengthAwarePaginator instance for pagination
        $paginatedItems = new LengthAwarePaginator(
            $items,
            $data->total(),
            $data->perPage(),
            $data->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Return the view with the necessary data
        return view('dashboard.livewire.rate-food-table', [
            'items' => $paginatedItems,
            'cols_th' => $cols_th,
            'cols_td' => $cols_td,
            'colspan' => $colspan,
        ]);
    }
    

}