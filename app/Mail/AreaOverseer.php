<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Address;

class AreaOverseer extends Mailable
{
    use Queueable, SerializesModels;

    public $EmailContent = "";
    public $FullName = "";
    public $FileLink = "";

    /**
     * Create a new message instance.
     */
    public function __construct($request)
    {
        // $this->EmailContent = $request->message;
        $this->EmailContent = "PDF REPORT HAS BEEN FINALIZED AND SUBMITTED TO THE SYSTEM BY " . Auth::user()->firstname . " " . Auth::user()->lastname . '. YOU MAY ACCESS THE REPORT DIRECTLY BY CLICKING THE LINK ABOVE.';
        $this->FullName = Auth::user()->firstname . " " . Auth::user()->lastname;
        $this->FileLink = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('uatapptesting@gmail.com', 'GENERATED EMAIL NOTIFICATION (APP TEST)'),
            subject: 'Pstr. ' . Auth::user()->firstname . " " . Auth::user()->lastname . ' Monthly Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.test',
            with: [
                'message' => $this->EmailContent,
            ],
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
