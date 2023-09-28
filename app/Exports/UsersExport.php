<?php

namespace App\Exports;

use App\Models\Food;
use App\Models\User;
use App\Models\Mainmenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $locale;

    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    public function headings(): array
    {
        return [
            'Menu ID',
            'Menu Name' . '(' . $this->locale . ')',
            'Category ID',
            'Category Name' . '(' . $this->locale . ')',
            'Food ID',
            'Food Name' . '(' . $this->locale . ')',
            'Food Description' . '(' . $this->locale . ')',
            'Food Price',
            'Food Old Price',
            'Food Options' . '(' . $this->locale . ')',
        ];
    }

    public function collection()
    {
        $menus = Mainmenu::with([
            'translation' => function ($query) {
                $query->where('lang', $this->locale); // English translations of menus
            },
            'categories.translation' => function ($query) {
                $query->where('locale', $this->locale); // English translations of categories
            },
            'categories.food.translation' => function ($query) {
                $query->where('lang', $this->locale); // English translations of foods
            },
        ])->where('user_id', auth()->id())->get();
    
        $exportData = [];
    
        foreach ($menus as $menu) {
            $menuName = $menu->translation ? $menu->translation->name : '-';
    
            if (count($menu->categories) === 0) {
                // If there are no categories, add menuName, '-' for category, and '--' for food
                $exportData[] = [
                    'Menu ID' => $menu->id,
                    'Menu Name (en)' => $menuName,
                    'Category ID' => '-',
                    'Category Name (en)' => '-',
                    'Food ID' => '--',
                    'Food Name (en)' => '--',
                    'Food Description (en)' => '-',
                    'Food Price' => '-',
                    'Food Old Price' => '-',
                    'Food Option Key (en)' => '-',
                    'Food Option Value (en)' => '-',
                ];
            } else {
                foreach ($menu->categories as $category) {
                    $categoryName = $category->translation ? $category->translation->name : '-';
    
                    if (count($category->food) === 0) {
                        // If there are no food, add menuName, categoryName, '-' for food
                        $exportData[] = [
                            'Menu ID' => $menu->id,
                            'Menu Name (en)' => $menuName,
                            'Category ID' => $category->id,
                            'Category Name (en)' => $categoryName,
                            'Food ID' => '-',
                            'Food Name (en)' => '--',
                            'Food Description (en)' => '-',
                            'Food Price' => '-',
                            'Food Old Price' => '-',
                            'Food Option Key (en)' => '-',
                            'Food Option Value (en)' => '-',
                        ];
                    } else {
                        foreach ($category->food as $food) {
                            $foodName = $food->translation ? $food->translation->name : '-';
                            $foodDescription = $food->translation ? $food->translation->description : '-';
                            $foodPrice = $food->price ?? '-';
                            $foodOldPrice = $food->old_price ?? '-';
    
                            // Decode the food options JSON
                            $foodOptions = json_decode($food->options, true);
    
                            if ($foodOptions) {
                                foreach ($foodOptions[$this->locale] as $option) {
                                    // Add a row for each food option key and value
                                    $exportData[] = [
                                        'Menu ID' => $menu->id,
                                        'Menu Name (en)' => $menuName,
                                        'Category ID' => $category->id,
                                        'Category Name (en)' => $categoryName,
                                        'Food ID' => $food->id,
                                        'Food Name (en)' => $foodName,
                                        'Food Description (en)' => $foodDescription,
                                        'Food Price' => $foodPrice,
                                        'Food Old Price' => $foodOldPrice,
                                        'Food Option Key (en)' => $option['key'],
                                        'Food Option Value (en)' => $option['value'],
                                    ];
                                }
                            } else {
                                // If food options are missing, add placeholders
                                $exportData[] = [
                                    'Menu ID' => $menu->id,
                                    'Menu Name (en)' => $menuName,
                                    'Category ID' => $category->id,
                                    'Category Name (en)' => $categoryName,
                                    'Food ID' => $food->id,
                                    'Food Name (en)' => $foodName,
                                    'Food Description (en)' => $foodDescription,
                                    'Food Price' => $foodPrice,
                                    'Food Old Price' => $foodOldPrice,
                                    'Food Option Key (en)' => '-',
                                    'Food Option Value (en)' => '-',
                                ];
                            }
                        }
                    }
                }
            }
        }
    
        return collect($exportData);
    }
    
}
