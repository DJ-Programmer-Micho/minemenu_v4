<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\AdsTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdsController extends Controller
{
    // public function dynamicUrl($id){
    //     try {
    //         $request = Request();
    //         $ip = $request->ip();
    //         $deviceIdentifier = $request->userAgent();
    //         $visitDate = now()->format('Y-m-d');
    //         $visittime = now()->format('H:i:s');
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }

    //     $data = Ads::find($id);
        
    //     $scans = $data->scans;
    //     $scans = $scans + 1;
    //     Ads::where('id', $id)->update([
    //         "scans" => $scans
    //     ]);


    //     AdsTracker::create([
    //         'name' => $data->name,
    //         'redirect_url' => $data->redirect_url,
    //         'ip_Address' => $ip,
    //         'device_identifier' => $deviceIdentifier,
    //         'visit_date' => $visitDate,
    //         'visit_time' => $visittime,
    //     ]);

    //     return Redirect::to($data->redirect_url);
    // }

    public function dynamicUrl($id)
    {
        $data = Ads::find($id);

        if ($data) {
            $this->updateScans($id);
            $this->trackVisit($data);

            return redirect()->to($data->redirect_url);
        }

        abort(404);
    }

    protected function updateScans($id)
    {
        Ads::where('id', $id)->increment('scans');
    }

    protected function trackVisit($data)
    {
        AdsTracker::create([
            'name' => $data->name,
            'redirect_url' => $data->redirect_url,
            'ip_Address' => request()->ip(),
            'device_identifier' => request()->userAgent(),
            'visit_date' => now()->format('Y-m-d'),
            'visit_time' => now()->format('H:i:s'),
        ]);
    }

}
