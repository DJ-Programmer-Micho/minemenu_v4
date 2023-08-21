<?php
 
namespace App\Http\Livewire\dashboard;
 
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
    public $videoFlag = false; 
    public $objectName; 
    public $objectVideoName; 
    // public $fileVideo; 
    public $tempImg;
    public $imgReader;

    protected $listeners = ['updateCroppedStartupImg' => 'handleCroppedImage'];
    // protected $videoUploadlisteners = ['videoUpload' => 'handleVideoUpload'];

    public function mount(){}

    public function handleCroppedImage($base64data)
    {
        if ($base64data){
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/setting/' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImg = $base64data;
            $this->imgFlag = true;
            if( $this->imgReader){
                Storage::disk('s3')->delete($this->imgReader);
                Storage::disk('s3')->put($this->objectName, $croppedImage);
            } else {
                Storage::disk('s3')->put($this->objectName, $croppedImage);
            }
            // $this->emit('imageUploaded', $this->objectName);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...405';
        }
    }

    public $uploadProgress;
    public $uploading = false;
    // public function handleVideoUpload($fileVideo)
    // {

    //     // sleep(1);
    //     if (!$this->uploading && $fileVideo) {
    //         $this->uploading = true;
    
    //         $microtime = str_replace('.', '', microtime(true));
    //         $customFilename = auth()->user()->name . '_' . date('Ymd') . $microtime . '.mp4';
    
    //         $fileContents = file_get_contents($fileVideo->getRealPath());
    
    //         $config = [
    //             'onUploadProgress' => function ($totalBytes, $uploadedBytes) {
    //                 $this->uploadProgress = round(($uploadedBytes / $totalBytes) * 100);
                   
    //                 info("Upload progress: {$this->uploadProgress}%");
    //             },
    //         ];
    // // dd($config);
    //         Storage::disk('s3')->put('rest/setting/' . $customFilename, $fileContents, $config);
    
    //         $this->uploading = false;
    //         $this->uploadProgress = 0;
    
    //         $this->videoFlag = true;
    //         $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Video uploaded successfully')]);
    //     } else {
    //         $this->videoFlag = false;
    //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Video did not upload')]);
    //     }



    //     $settings = Setting::firstOrNew(['user_id' => auth()->id()]);

    //     $settings->background_vid = $this->fileVideo;
    //     $settings->save();
    //     $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    // }





    public function saveSettings()
    {
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
 
    public function render()
    {
        return view('dashboard.livewire.setting-start-form');
    }
}