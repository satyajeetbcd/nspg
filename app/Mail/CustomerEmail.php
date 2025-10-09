<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Log;

class CustomerEmail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public Customer $customer)
    {
        $this->customer = $customer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('jeffrey@example.com', 'Jeffrey Way'),
            subject: 'Confirmation Email',
        );
    }

    public function content(): Content
    {
        Log::info('Customer confirmation email sent successfully for: ' . $this->customer->name);
        return new Content(
            view: 'mail.customer_email',
            with: [
                'customer' => $this->customer,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
