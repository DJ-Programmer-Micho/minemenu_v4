<?php 

namespace App\Http\Controllers\Api\V1;

use App\Models\Mainmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MineMenuApiController extends Controller
{
    protected $glang;
    protected $filteredLocales;
    protected $telegram_channel_status;
    protected $telegram_channel_link;
    protected $view_business_name;
    protected $search;

    public function __construct()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        if (auth()->check()) {
            $userSettings = Auth::user()->settings;
            $this->telegram_channel_status = $userSettings ? $userSettings->telegram_notify_status : null;
            $this->telegram_channel_link = $userSettings ? $userSettings->telegram_notify : null;
            $this->view_business_name = Auth::user()->name;
        }
    }

    public function index()
    {
        $data = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', auth()->id())
        ->whereHas('translation', function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('user_id', 'like', '%' . $this->search . '%');
            });
        })
        ->orderBy('priority', 'ASC')
        ->paginate(10);

        return response()->json($data); // Return JSON response containing the data
    }

    public function store(Request $request)
    {
        // Handle storing data, if applicable
    }

    public function show($id)
    {
        // Retrieve specific data, if applicable
    }

    public function update(Request $request, $id)
    {
        // Handle updating data, if applicable
    }

    public function destroy($id)
    {
        // Handle deleting data, if applicable
    }
}
