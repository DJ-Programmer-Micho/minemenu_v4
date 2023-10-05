<?php

namespace App\Exports;

use App\Models\Plan;
use App\Models\PlanChange;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersActivityExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $planFilter_send;
    protected $searchFilter_send;
    protected $dateRange_send;
    public $mainLink;

    public function __construct($planFilter_send,$searchFilter_send,$dateRange_send)
    {
        $this->planFilter_send = $planFilter_send;
        $this->searchFilter_send = $searchFilter_send;
        $this->dateRange_send = $dateRange_send;
        $this->mainLink = env('APP_URL');
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Business Name',
            'Old Plan',
            'New Plan',
            'Date',
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
        
        $exportData = PlanChange::with(['user', 'user.profile', 'user.settings'])
            ->orderBy('change_date', 'DESC')
            ->when($this->planFilter_send, function ($query) {
                $query->whereHas('user', function ($subquery) {
                    $subquery->where('new_plan_id', $this->planFilter_send);
                });
            })
            ->when($this->searchFilter_send, function ($query) {
                $query->whereHas('user', function ($subquery) {
                    $subquery->where('name', 'like', '%' . $this->searchFilter_send . '%');
                });
            })
            ->when($this->dateRange_send, function ($query) {
                list($startDate, $endDate) = explode(' - ', $this->dateRange_send);
                $query->whereBetween('change_date', [$startDate, $endDate]);
            })
            ->get();
    
        $exportedData = [];
    
        foreach ($exportData as $item) {
            $exportedData[] = [
                'ID' => $item->id,
                'User ID' => $item->user->id,
                'Business Name' => $item->user->name,
                'Old Plan' => $planNames[$item->old_plan_id] ?? 'Error',
                'New Plan' => $planNames[$item->new_plan_id] ?? 'Error',
                'Date' => $item->change_date,
                'View Resturant' => $this->mainLink.$item->user->name, // Replace with the actual value
            ];
        }
    
        return collect($exportedData);
    }
    
}
