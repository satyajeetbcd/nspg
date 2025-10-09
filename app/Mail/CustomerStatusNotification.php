<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $action; // 'activated', 'deactivated'
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, string $action, string $reason = null)
    {
        $this->customer = $customer;
        $this->action = $action;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->action) {
            'activated' => 'Account Activated - ' . config('app.name'),
            'deactivated' => 'Account Deactivated - ' . config('app.name'),
            default => 'Account Status Update - ' . config('app.name')
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-status',
            with: [
                'customer' => $this->customer,
                'action' => $this->action,
                'reason' => $this->reason,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}

