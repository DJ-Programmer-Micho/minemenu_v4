<?php
 
namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportErrorFormMailable;
 
class SupportErrorLivewire extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $message;
    public $phone;
    public $sucessMessage;
    public $attachments = [];
    public $data = [];
    

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
        // $this->validate(); // Validate the form fields as defined in the rules method
    
        $this->data['name'] = $this->name;
        $this->data['email'] = $this->email;
        $this->data['subject'] = $this->subject;
        $this->data['message'] = $this->message;
        $this->data['phone'] = $this->phone;
    
        // Store the uploaded files and get their paths
        $attachmentPaths = [];
        foreach ($this->attachments as $attachment) {
            $path = $attachment->store('attachments'); // 'attachments' is the directory where files will be stored
            $attachmentPaths[] = storage_path('app/' . $path); // Get the full path to the stored file
        }
    
        // Pass the attachment paths to the email
        $this->data['attachments'] = $attachmentPaths;
    
        $contact = $this->data;
        // dd($this->attachments);
        // Send the email with attachments
        Mail::to($this->email)->send(new SupportErrorFormMailable($contact, $attachmentPaths));
    
        // Perform any other actions you need (e.g., saving data)
    
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
        $this->attachments = [];
    }

    public function render()
    {
        return view('dashboard.livewire.support-error-form');
    }
}

