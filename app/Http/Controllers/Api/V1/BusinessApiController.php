<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Food;
use App\Models\User;
use App\Models\Offer;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\Mainmenu;
use App\Models\Categories;
use App\Models\FoodRating;
use App\Models\RestRating;
use App\Models\Subscription;
use Illuminate\Http\Request; 
use App\Models\Setting_Translation;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class BusinessApiController extends Controller
{

    public function startUp(Request $request, $business_name){
        
        $request->session()->put('ShutDown', false);
        return redirect($business_name);
    }

    public function subscription(Request $request){
        try {        
            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userSettings = Subscription::where('user_id', $userProfile->id)->first();
                        
                return response()->json([
                    "status" => "true",
                    "userSetting" => $userSettings,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function setting(Request $request) {
        if ($request->route('business_name')) {
            $businessName = $request->route('business_name');   
            $userProfile = User::where('name', $businessName)->firstOrFail();
            
            // Fetch user settings for all languages
            $userSettings = Setting::with('translations')
            ->where('user_id', $userProfile->id)
            ->first();
            
            // Extract available languages from the first user setting
            $availableLanguages = $userSettings->languages;

            // Loop through each available language
            foreach ($availableLanguages as $lang) {
                // Initialize an array to store translations for the current language
                $translationsForLang = [];
    
                // Loop through each translation and filter translations for the current language
                foreach ($userSettings->translations as $translation) {
                    if ($translation->locale === $lang) {
                        $translationsForLang[] = [
                            'rest_name' => $translation->rest_name,
                            'address' => $translation->address,
                            'created_at' => $translation->created_at,
                            'updated_at' => $translation->updated_at
                        ];
                    }
                }
            }
    
            $uiColor = json_decode($userSettings->ui_color);
            // Return all user settings along with translations for all languages
            return response()->json([
                "status" => "true",
                'name' => $businessName,
                "userSettings" => $userSettings,
                "uiColor" => $uiColor,
                "message" => "User API MW Successfully"
            ]);
        }
    }

    public function appValidation(Request $request) {
        try {  
            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
        
                // Return all user settings along with translations for all languages
                return response()->json([
                    "status" => "true",
                    'valid' => $userProfile->app ?? 0,
                    'name' => $userProfile->name,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                'valid' => 0,
                "message" => "No Data Available"
            ]);
        }
    }

    public function menu(Request $request) {
        try {        
            $language = $request->input('lang');

            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;

                $menuData = Mainmenu::with(['translation' => function ($query) use ($language, $userLanguage) {
                    $query->where('lang', $language ?? $userLanguage);
                }])
                ->where('user_id', $userProfile->id )
                ->where('status', 1)
                ->get();
    

                return response()->json([
                    "status" => "true",
                    "menuData" => $menuData,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function category(Request $request) {
        try {        
            $language = $request->input('lang');
            $menuId = $request->input('menuId');

            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;

                $categoryData = Categories::with(['translation' => function ($query) use ($language, $userLanguage) {
                    $query->where('locale', $language ?? $userLanguage);
                }])
                ->where('menu_id', $menuId)
                ->where('user_id', $userProfile->id )
                ->where('status', 1)
                ->get();
    

                return response()->json([
                    "status" => "true",
                    "categoryData" => $categoryData,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function food(Request $request) {
        try {        
            $language = $request->input('lang');
            $catId = $request->input('catId');
    
            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;
    
                $categoryData = Food::with([
                    'translation' => function ($query) use ($language, $userLanguage) {
                        $query->where('lang', $language ?? $userLanguage);
                    },
                    'foodRatings' => function ($query) {
                        $query->selectRaw('food_id, AVG(rating) as average_rating, COUNT(*) as rating_count')
                              ->groupBy('food_id');
                    }
                ])
                ->where('cat_id', $catId)
                ->where('user_id', $userProfile->id)
                ->where('status', 1)
                ->get();
    
                // Filter options based on language if "sorm" is equal to 1
                $categoryData = $categoryData->map(function ($item) use ($language, $userLanguage) {
                    if ($item->sorm == 1 && $item->options) {
                        $options = json_decode($item->options, true); // Convert to associative array
                        $item->options = isset($options[$language ?? $userLanguage]) ? $options[$language ?? $userLanguage] : null;
                    }
                    return $item;
                });
                
                return response()->json([
                    "status" => "true",
                    "categoryData" => $categoryData,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function foodDetail(Request $request) {
        try {        
            $language = $request->input('lang');
            $foodId = $request->input('foodId');
    
            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;
    
                $categoryData = Food::with([
                    'translation' => function ($query) use ($language, $userLanguage) {
                        $query->where('lang', $language ?? $userLanguage);
                    },
                    'foodRatings' => function ($query) {
                        $query->selectRaw('food_id, AVG(rating) as average_rating, COUNT(*) as rating_count')
                              ->groupBy('food_id');
                    }
                ])
                ->where('id', $foodId)
                ->where('user_id', $userProfile->id)
                ->where('status', 1)
                ->first();
    
                if ($categoryData && $categoryData->sorm == 1 && $categoryData->options) {
                    $options = json_decode($categoryData->options, true); // Convert to associative array
                    $categoryData->options = isset($options[$language ?? $userLanguage]) ? $options[$language ?? $userLanguage] : null;
                }
    
                return response()->json([
                    "status" => "true",
                    "categoryData" => $categoryData,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function offer(Request $request) {
        try {        
            $language = $request->input('lang');
            // $menuId = $request->input('menuId');

            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;

                $offerData = Offer::with(['translation' => function ($query) use ($language, $userLanguage) {
                    $query->where('lang', $language ?? $userLanguage);
                }])
                ->where('user_id', $userProfile->id )
                ->where('status', 1)
                ->orderBy('priority', 'ASC')
                ->get();

                return response()->json([
                    "status" => "true",
                    "offerData" => $offerData,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }
    

    public function offerDetail(Request $request){
        try {        
            $language = $request->input('lang');
            $foodId = $request->input('offerId');

            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');   
                $userProfile = User::where('name', $businessName)->firstOrFail();
                $userLanguage = Setting::where('user_id', $userProfile->id)->first();
                $userLanguage = $userLanguage->default_lang;

                $offerDetail = Offer::with(['translation' => function ($query) use ($language, $userLanguage) {
                    $query->where('lang', $language ?? $userLanguage);
                }])
                ->where('id', $foodId)
                ->where('user_id', $userProfile->id )
                ->where('status', 1)
                ->first();
    
                // if ($offerDetail && $offerDetail->sorm == 1 && $offerDetail->options) {
                //     $options = json_decode($offerDetail->options, true); // Convert to associative array
                //     $offerDetail->options = isset($options[$language ?? $userLanguage]) ? $options[$language ?? $userLanguage] : null;
                // }

                return response()->json([
                    "status" => "true",
                    "offerDetail" => $offerDetail,
                    "message" => "User API MW Successfully"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "No Data Available"
            ]);
        }
    }

    public function submitFoodRating(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'food_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
    
        $phone = $request->input('phone');
        $foodId = $request->input('food_id');
        $rating = $request->input('rating');
    
        $customer = Customer::where('phone', $phone)->first();
    
        if (!$customer) {
            return response()->json([
                'e_number' => '103',
                'status' => 'false',
                'message' => 'Customer not found. Please register first.',
            ], 404);
        }
    
        $existingRating = FoodRating::where('customer_id', $customer->id)->where('food_id', $foodId)->first();
    
        if ($existingRating) {
            return response()->json([
                'e_number' => '102',
                'status' => 'false',
                'message' => 'Already Rated',
            ], 400);
        }
    
        FoodRating::create([
            'customer_id' => $customer->id,
            'food_id' => $foodId,
            'rating' => $rating,
        ]);
    
        return response()->json([
            'status' => 'true',
            'message' => 'Thank you for your rating!',
        ], 201);
    }

    public function registerCustomerAndRateFood(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|unique:customers,phone',
            'food_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Check if the phone number already exists
        $existingCustomer = Customer::where('phone', $request->input('phone'))->first();

        if ($existingCustomer) {
            return response()->json([
                'e_number' => '101',
                'status' => 'false',
                'message' => 'Phone number already exists.',
            ], 400);
        }

        $customer = Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'dob' => $request->input('dob'),
            'phone' => $request->input('phone'),
        ]);

        FoodRating::create([
            'customer_id' => $customer->id,
            'food_id' => $request->input('food_id'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Customer registered and rating submitted successfully!',
        ], 201);
    }

    
    public function submitRestRating(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'user_id' => 'required|integer',
            'staff' => 'required|numeric|min:1|max:5',
            'service' => 'required|numeric|min:1|max:5',
            'environment' => 'required|numeric|min:1|max:5',
            'experience' => 'required|numeric|min:1|max:5',
            'cleaning' => 'required|numeric|min:1|max:5',
            'note' => 'nullable|string',
        ]);

        $phone = $request->input('phone');
        $userId = $request->input('user_id');
        $staff = $request->input('staff');
        $service = $request->input('service');
        $environment = $request->input('environment');
        $experience = $request->input('experience');
        $cleaning = $request->input('cleaning');
        $note = $request->input('note');

        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json([
                'e_number' => '103',
                'status' => 'false',
                'message' => 'Customer not found. Please register first.',
            ], 404);
        }

        $existingRating = RestRating::where('customer_id', $customer->id)->where('user_id', $userId)->first();

        if ($existingRating) {
            return response()->json([
                'e_number' => '102',
                'status' => 'false',
                'message' => 'Already Rated',
            ], 400);
        }

        RestRating::create([
            'customer_id' => $customer->id,
            'user_id' => $userId,
            'staff' => $staff,
            'service' => $service,
            'environment' => $environment,
            'experience' => $experience,
            'cleaning' => $cleaning,
            'note' => $note,
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Thank you for your rating!',
        ], 201);
    }


    
    public function registerCustomerAndRateRest(Request $request)
{
    // Validate the request data
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'dob' => 'required|date',
        'phone' => 'required|string',
        'user_id' => 'required|integer',
        'staff' => 'required|numeric|min:1|max:5',
        'service' => 'required|numeric|min:1|max:5',
        'environment' => 'required|numeric|min:1|max:5',
        'experience' => 'required|numeric|min:1|max:5',
        'cleaning' => 'required|numeric|min:1|max:5',
        'note' => 'nullable|string',
    ]);

    // Check if the phone number already exists
    $existingCustomer = Customer::where('phone', $request->input('phone'))->first();

    if ($existingCustomer) {
        return response()->json([
            'e_number' => '101',
            'status' => 'false',
            'message' => 'Phone number already exists.',
        ], 400);
    }

    try {
        // Create the new customer
        $customer = Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'dob' => $request->input('dob'),
            'phone' => $request->input('phone'),
        ]);

        // Create the restaurant rating
        RestRating::create([
            'customer_id' => $customer->id,
            'user_id' => $request->input('user_id'),
            'staff' => $request->input('staff'),
            'service' => $request->input('service'),
            'environment' => $request->input('environment'),
            'experience' => $request->input('experience'),
            'cleaning' => $request->input('cleaning'),
            'note' => $request->input('note'),
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Customer registered and restaurant rating submitted successfully!',
        ], 201);

    } catch (\Exception $e) {
        // Log the error for debugging
        // \Log::error('Error registering customer and submitting rating: ' . $e->getMessage());

        return response()->json([
            'e_number' => '104',
            'status' => 'false',
            'message' => 'An error occurred. Please try again later.',
        ], 500);
    }
}

    











    public function generateManifest($business_name)
    {
        // Fetch business-specific information (e.g., from your database)
        // $user = User::where('name', $business_name)->first();
        // $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $user = App::make('userProfile');
        $setting = App::make('userSettings');
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
        $color = json_decode($setting->ui_color);

        if (!$user || !$setting) {
            abort(404); // Handle cases where the user or setting is not found
        }
        // Generate the dynamic manifest data based on $businessInfo
        $manifestData = [
            'name' => "Mine Menu |" . $setting_name,
            'short_name' => $setting_name,
            'icons' => [
                [
                    "src" => app('cloudfront').$setting->background_img_avatar,
                    "type" => "image/svg+xml",
                    "sizes" => "256x256"
                ]
                ],
            "id"=> "http://" . $business_name,
            "start_url"=> "http://" . $business_name,
            "background_color"=> $color->selectedMainBackground ?? '#ffffff',
            "display"=> "fullscreen",
            // "display"=> "standalone",
            "scope"=> "/",
            "theme_color"=> $color->selectedNavbarTop ?? '#ffffff',
            "shortcuts"=> [
                [
                  "name"=> "Check The New Update",
                  "short_name"=> "Update",
                  "description"=> "Join To Mine Mneu NOW!",
                  "url"=> "https://minemenu.com",
                  "icons"=> [[ "src"=> app('cloudfront').$setting->background_img_header, "sizes"=> "192x192" ]]
                ],
                [
                  "name"=> "Get Menu For 14 Days Free Trial",
                  "short_name"=> "FREE MENU",
                  "description"=> "Register to the free menu",
                  "url"=> "https://minemenu.com/pricing",
                  "icons"=> [[ "src"=> app('cloudfront').$setting->background_img_header, "sizes"=> "192x192" ]]
                ]
              ],
        ];

        // Return the manifest data as JSON
        return response()->json($manifestData)->header('Content-Type', 'application/json'); 
    }
}
