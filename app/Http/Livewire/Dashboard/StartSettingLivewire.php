<?php
 
namespace App\Http\Livewire\Dashboard;
 
use Livewire\Component;
use App\Models\Setting;
use App\Models\Setting_Translation;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class StartSettingLivewire extends Component
{
    use WithFileUploads;
    // FormLocal
    public $status;
    public $imgFlag = false; 
    public $objectName; 
    public $objectVideoName; 
    public $fileVideo; 
    public $tempImg;
    public $imgReader;

    protected $listeners = [
        'updateCroppedStartupImg' => 'handleCroppedImage',
        'simulationComplete' => 'handlesimulationComplete',
    ];

    public function mount(){
        $getVideo = Setting::where('user_id', auth()->id())->first();
        $this->objectVideoName =  $getVideo->background_vid ? $getVideo->background_vid  : null;
        $this->imgReader = $getVideo->background_img ? $getVideo->background_img : null;
        $this->status = $getVideo->intro_page ? $getVideo->intro_page : null;
    }
    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/' . auth()->user()->name . '/setting/' . auth()->user()->name.'_setting_'.date('Ydm') . $microtime . '.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImg = $base64data;
            $this->imgFlag = true;
            if( $this->imgReader){
                Storage::disk('s3')->delete($this->imgReader);
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img = $this->objectName;
                $settings->save();
            } else {
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img = $this->objectName;
                $settings->save();
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Image Uploaded Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }

    public function handlesimulationComplete(){
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Video Uploaded %100 successfully')]);
    }
    public function uploadVideo()
    {
        if ( $this->fileVideo) {
            if ($this->fileVideo->getSize() > 3000000) {
                return $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('The Video Size is more than 3MB')]);
            }
            $old_video = $this->objectVideoName;
            $microtime = str_replace('.', '', microtime(true));
            $customFilename = auth()->user()->name . '_vid_' . date('Ymd') . $microtime . '.mp4';
            $fileContents = file_get_contents($this->fileVideo->getRealPath());

            $this->dispatchBrowserEvent('fakeProgressBar');
            $this->objectVideoName = 'rest/' . auth()->user()->name . '/setting/' . $customFilename;
            // $this->objectVideoName = 'rest/setting/' . $customFilename;
            if($old_video){
                Storage::disk('s3')->delete($old_video);
                Storage::disk('s3')->put('rest/' . auth()->user()->name . '/setting/' . $customFilename, $fileContents);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_vid = $this->objectVideoName;
                $settings->save();
            } else {
                Storage::disk('s3')->put('rest/' . auth()->user()->name . '/setting/' . $customFilename, $fileContents);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_vid = $this->objectVideoName;
                $settings->save();
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => __('Video is uploading')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Video did not upload')]);
        }
    }

    public function saveStatus()
    {
        if($this->status){
            $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
            if($this->status == 'null'){
                $this->status = null;
            }
            $settings->intro_page = $this->status;
            $settings->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Status Updated successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Error, Status did not Update')]);
        }
    }
 
    public function render()
    {
        return view('dashboard.livewire.setting-start-form');
    }
}