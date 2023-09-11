<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportContactUsFormMailable;
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
    public $data = [];
    // public $attachments = [];
    

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
 
        Mail::to($this->email)->send(new SupportContactUsFormMailable($contact));
        // Perform any other actions you need (e.g., sending emails, saving data)

       
        $this->resetForm();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Your message has been sent successfully.')]);
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

