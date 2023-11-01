<?php
 
namespace App\Http\Livewire\Dashboard;

use App\Models\Food;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Mainmenu;
use App\Models\Categories;
use App\Models\Offer;

class SupportMenuFixLivewire extends Component
{
    public $menuCount;
    public $categoryCount;
    public $offerCount;
    public $glang;
    public $showRequirements = false;
    public $analysing = false;
    public $messages = [];

    public function mount()
    {
        $this->glang = app('glang');
    }

    public function checkRequirements()
    {
        $this->messages['offer']= null;
        $this->messages['menu']= null;
        $this->messages['category']= null;
        $this->messages['name']= null;
        $this->messages['description']= null;
        $this->messages['option']= null;
        
        $user = auth()->id();
        $this->analysing = true;
        // dd($user);
        // Logic to check requirements goes here
        $this->offerCount = Offer::where('user_id', $user)->count();
        if ($this->offerCount > 5) {
            $this->messages['offer'][] = "You have more than 5 offers. Remove some to optimize.";
        }
        if ($this->offerCount == 0) {
            $this->messages['offer'][] = "You don't have any offers. Add more to optimize.";
        }

        // Example checks:
        // 1. Check menus
        $this->menuCount = Mainmenu::where('user_id', $user)->count();
        if ($this->menuCount > 7) {
            $this->messages['menu'][] = "You have more than 7 menus. Remove some to optimize.";
        }
        if ($this->menuCount == 0) {
            $this->messages['menu'][] = "You don't have any menus. Add more to optimize.";
        }

        // 2. Check categories
        $this->categoryCount = Categories::where('user_id', $user)->count();
        if ($this->categoryCount > 20) {
            $this->messages['category'][] = "You have less than 20 categories in each menu. Add more to optimize.";
        }
        if ($this->categoryCount == 0) {
            $this->messages['category'][] = "You don't have any categories. Add more to optimize.";
        }

                //Get the user's food items
                $foods = Food::with(['category.translation', 'translation'])
                ->where('user_id', $user)
                ->whereHas('translation', function ($query) {
                    $query->where('lang', $this->glang);
                })
                ->get();


        // 3. Check food names and descriptions
        // dd($foods);
        foreach ($foods as $food) {
            if (!empty($food->translation->name) && mb_strlen($food->translation->name) > 30) {
                $this->messages['name'][] = "Food name '{$food->translation->name}' is longer than 30 characters.";
            }
            if (!empty($food->translation->description) && mb_strlen($food->translation->description) > 250) {
                $this->messages['description'][] = "Food description '{$food->translation->description}' is longer than 250 characters.";
            }
            if ($food->sorm == 1) {
                $optionsData = json_decode($food->options, true);
                
                foreach ($optionsData as $language => $options) {
                    $optionsCount = count($options);
                    
                    if ($optionsCount === 1) {
                        $this->messages['option'][] = "Multi-food '{$food->translation->name}' in language '{$language}' has 1 option. Add more to optimize.";
                    }
                    if ($optionsCount > 5) {
                        $this->messages['option'][] = "Multi-food '{$food->translation->name}' in language '{$language}' has more than 5 options. Remove some to optimize.";
                    }
                }
            }
        }

        $this->showRequirements = true;
    }


    public function render()
    {
        return view('dashboard.livewire.support-menuFix-form');
    }
}

