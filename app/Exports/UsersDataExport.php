<?php

namespace App\Exports;

use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersDataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $planFilter_send;
    protected $searchFilter_send;
    protected $dateRange_send;
    protected $countryFilter_send;
    public $mainLink;

    public function __construct($planFilter_send,$searchFilter_send,$dateRange_send,$countryFilter_send)
    {
        $this->planFilter_send = $planFilter_send;
        $this->searchFilter_send = $searchFilter_send;
        $this->dateRange_send = $dateRange_send;
        $this->countryFilter_send = $countryFilter_send;
        $this->mainLink = env('APP_URL');
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Business Name',
            'Current Plan',
            'Registered Date',
            'View Resturant',
        ];
    }

    public function collection()
    {
        $plans = Plan::get();
        $planNames = [];
        foreach ($plans as $plan) {
            $planNames[$plan->id] = $plan->name['en'] ?? 'Error';
        }
        
        $uniqueCountries = Profile::distinct()->pluck('country')->filter()->values()->toArray();

        $exportData = User::with(['profile', 'settings','subscription'])
            ->where('role', 3)
            ->orderBy('created_at', 'DESC')
            ->when($this->planFilter_send, function ($query) {
                $query->whereHas('subscription', function ($subquery) {
                    $subquery->where('plan_id', $this->planFilter_send);
                });
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchFilter_send . '%')
                    ->orWhereHas('profile', function ($subquery) {
                        $subquery->where('fullName', 'like', '%' . $this->searchFilter_send . '%');
                    })
                    ->orWhereHas('profile', function ($subquery) {
                        $subquery->where('country', 'like', '%' . $this->searchFilter_send . '%');
                    })
                    ->orWhereHas('profile', function ($subquery) {
                        $subquery->where('address', 'like', '%' . $this->searchFilter_send . '%');
                    });
            })
            ->when($this->countryFilter_send, function ($query) use ($uniqueCountries) {
                if (in_array($this->countryFilter_send, $uniqueCountries)) {
                    $query->whereHas('profile', function ($subquery) {
                        $subquery->where('country', $this->countryFilter_send);
                    });
                }
            })
            ->when($this->dateRange_send, function ($query) {
                list($startDate, $endDate) = explode(' - ', $this->dateRange_send);
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();
    
        $exportedData = [];
    
        foreach ($exportData as $index => $item) {
            $exportedData[] = [
                'ID' => $index + 1,
                'User ID' => $item->id,
                'Business Name' => $item->name,
                'Current Plan' => $planNames[$item->subscription->plan_id] ?? 'Error',
                'Date' => $item->created_at,
                'View Resturant' => $this->mainLink.$item->name, // Replace with the actual value
            ];
        }
    
        return collect($exportedData);
    }
    
}
