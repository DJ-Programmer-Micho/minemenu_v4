<?php
 
namespace App\Http\Livewire\Dashboard;

// use App\Models\Setting;
use Livewire\Component;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\SupportContactUsFormMailable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Owner\TelegramContactUs;
use Livewire\WithFileUploads; // Import the trait


class SupportContactUsLivewire extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $message;
    public $phone;
    public $sucessMessage;
    public $guestIdentifier;
    public $deviceIdentifier;
    public $ohNo;
    public $tele_id;
    public $data = [];
    // public $attachments = [];
    public function mount(){
        $this->tele_id = "-1002046515204";
    }

    protected function rules()
    {

        $rules['name'] = ['required'];
        $rules['email'] = ['required|email'];
        $rules['subject'] = ['required'];
        $rules['message'] = ['required'];
        $rules['phone'] = ['required'];
        return $rules;
    }

    public function submitForm()
    {
        $this->data['name'] = $this->name;
        $this->data['email'] = $this->email;
        $this->data['subject'] = $this->subject;
        $this->data['message'] = $this->message;
        $this->data['phone'] = $this->phone;

        $contact = $this->data;
        try {
            $this->guestIdentifier = $_SERVER['REMOTE_ADDR'];
            $this->deviceIdentifier = $_SERVER['HTTP_USER_AGENT'];
        }
        catch (\Exception $e) {
            $this->ohNo = 'error ' + $e;
        }
        try{
            Notification::route('toTelegram', null)
            ->notify(new TelegramContactUs(
                auth()->user()->id,
                auth()->user()->name,
                $this->name,
                $this->email,
                $this->subject,
                $this->message,
                $this->phone,

                // $this->guestIdentifier,
                'a',
                // $this->deviceIdentifier,
                'b',
                // $this->ohNo,
                'c',
                'c',
                'c',

                $this->tele_id
            ));
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Message Send Successfully')]);
            $this->resetForm();
        }  catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('An error occurred while sending Notification.')]);
        }


        // Mail::to($this->email)->send(new SupportContactUsFormMailable($contact));
        // Perform any other actions you need (e.g., sending emails, saving data)

       


        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('All Done :)')]);
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
        $this->phone = '';
        // $this->attachments = [];
    }

    public function render()
    {
        return view('dashboard.livewire.support-contactUs-form');
    }
}

