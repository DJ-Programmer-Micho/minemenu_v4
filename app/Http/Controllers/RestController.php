<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{
    // PAGE VIEW
    public function dashboard(){
        return view('dashboard.rest.pages.dashboard.index');
    } // END FUNCTION (DASHBOARD)
    public function mainmenu(){
        return view('dashboard.rest.pages.menu.index');
    } // END FUNCTION (DASHBOARD)
    public function category(){
        return view('dashboard.rest.pages.category.index');
    } // END FUNCTION (DASHBOARD)
    public function food(){
        return view('dashboard.rest.pages.food.index');
    } // END FUNCTION (DASHBOARD)
    public function languageSetting(){
        return view('dashboard.rest.pages.setting.languageSetting');
    } // END FUNCTION (DASHBOARD)
    public function nameSetting(){
        return view('dashboard.rest.pages.setting.nameSetting');
    } // END FUNCTION (DASHBOARD)
    public function menuSetting(){
        return view('dashboard.rest.pages.setting.menuSetting');
    } // END FUNCTION (DASHBOARD)
    public function startSetting(){
        return view('dashboard.rest.pages.setting.startSetting');
    } // END FUNCTION (DASHBOARD)

    // HARD PROCESS
    public function uploadVideo(Request $request)
    {
        dd(';asd');
        $file = $request->file('video');
        if ($file) {
            // Perform your file upload to S3 here
            // ...
                $microtime = str_replace('.', '', microtime(true));
                $customFilename = auth()->user()->name . '_' . date('Ymd') . $microtime . '.mp4';
        
                $fileContents = file_get_contents($file->getRealPath());
        
        // dd($config);
                Storage::disk('s3')->put('rest/setting/' . $customFilename, $fileContents);
        
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Video uploaded successfully')]);
            } else {
            
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Video did not upload')]);
            }



            return response()->json(['message' => 'Upload successful']);
        }
}
