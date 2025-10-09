<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $subscription;
    public $action; // 'created', 'renewed', 'cancelled', 'expired'

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, Subscription $subscription, string $action = 'created')
    {
        $this->customer = $customer;
        $this->subscription = $subscription;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->action) {
            'created' => 'New Subscription Created - ' . config('app.name'),
            'renewed' => 'Subscription Renewed - ' . config('app.name'),
            'cancelled' => 'Subscription Cancelled - ' . config('app.name'),
            'expired' => 'Subscription Expired - ' . config('app.name'),
            default => 'Subscription Update - ' . config('app.name')
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
            view: 'emails.subscription-notification',
            with: [
                'customer' => $this->customer,
                'subscription' => $this->subscription,
                'action' => $this->action,
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

