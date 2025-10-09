<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanAssignmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $plan;
    public $action; // 'assigned', 'upgraded', 'downgraded', 'removed'

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, Plan $plan = null, string $action = 'assigned')
    {
        $this->customer = $customer;
        $this->plan = $plan;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->action) {
            'assigned' => 'Plan Assigned - ' . config('app.name'),
            'upgraded' => 'Plan Upgraded - ' . config('app.name'),
            'downgraded' => 'Plan Changed - ' . config('app.name'),
            'removed' => 'Plan Removed - ' . config('app.name'),
            default => 'Plan Update - ' . config('app.name')
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
            view: 'emails.plan-assignment',
            with: [
                'customer' => $this->customer,
                'plan' => $this->plan,
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

