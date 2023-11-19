<?php
 
namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportErrorFormMailable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Owner\TelegramContactUs;
 
class SupportErrorLivewire extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $message;
    public $phone;
    public $sucessMessage;
    public $tele_id;
    public $data = [];
    // public $attachments = [];
    public function mount(){
        $this->tele_id = "-4084626386";
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
        return view('dashboard.livewire.support-error-form');
    }
}

