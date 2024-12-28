<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskerPerformanceReport extends Mailable
{
    use Queueable, SerializesModels;

    public $taskerDetails;

    public function __construct($taskerDetails)
    {
        $this->taskerDetails = $taskerDetails; // Pass tasker details to the email
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tasker Performance Report',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.tasker-performance-report',
            with: ['taskerDetails' => $this->taskerDetails] // Pass data to the view
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
