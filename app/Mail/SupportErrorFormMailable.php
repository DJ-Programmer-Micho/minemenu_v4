<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupportErrorFormMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct($contact, $attachments)
    {
        $this->contact = $contact;
        // $this->attachments = json_decode($attachments);
        $this->attachments = $attachments;
        
 
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Support Contact Us Form Mailable',
        );
    }

    public function build()
    {
        $message = $this->view('dashboard.mails.suppport-error');
        // dd($this->attachments);
        // Attach each uploaded file
        $i = 0;
        // foreach ($this->attachments as $attachmentPath) {
        //     foreach ( $attachmentPath as $singleFile) {
        //         // dd($this->attachments);
        //         $fileContents = file_get_contents($singleFile);
        //         $message->attachData($fileContents, 'attachment_' . $i . '.jpg', [
        //             'mime' => 'image/jpeg', // Replace with the correct MIME type of your attachment
        //         ]);
        //         $i++;
        //     }
        // }

        if (!empty($this->attachments)) {
    foreach ($this->attachments as $attachmentPath) {
        $fileContents = file_get_contents($attachmentPath);
        $message->attachData($fileContents, 'attachment_' . $i . '.jpg', [
            'mime' => 'image/jpeg', // Replace with the correct MIME type of your attachment
        ]);
        $i++;
    }
}


        return $message;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'dashboard.mails.suppport-error',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
