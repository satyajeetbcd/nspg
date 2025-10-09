<?php

namespace App\Services;

use App\Email;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\EmailAttempt;
use Illuminate\Support\Facades\View;

class MailjetEmailService
{
    use Email;

    /**
     * Send plan assignment notification email
     */
    public function sendPlanAssignmentEmail(Customer $customer, Plan $plan = null, string $action = 'assigned')
    {
        // Check if we can send this email (max 2 attempts)
        if (!EmailAttempt::canSendEmail($customer->email, 'plan_assignment', $action, $customer->id, $plan?->id, 'plan')) {
            \Log::info("Email limit reached for plan assignment: {$customer->email} - {$action}");
            return false;
        }

        // Create email attempt record
        $emailAttempt = EmailAttempt::createAttempt(
            $customer->email, 
            'plan_assignment', 
            $action, 
            $customer->id, 
            $plan?->id, 
            'plan',
            24 // 24 hours expiration
        );

        if (!$emailAttempt) {
            \Log::warning("Failed to create email attempt for plan assignment: {$customer->email}");
            return false;
        }

        $subject = match($action) {
            'assigned' => 'Plan Assigned - ' . config('app.name'),
            'upgraded' => 'Plan Upgraded - ' . config('app.name'),
            'downgraded' => 'Plan Changed - ' . config('app.name'),
            'removed' => 'Plan Removed - ' . config('app.name'),
            default => 'Plan Update - ' . config('app.name')
        };

        $htmlBody = view('emails.plan-assignment', [
            'customer' => $customer,
            'plan' => $plan,
            'action' => $action,
            'token' => $emailAttempt->token,
            'expires_at' => $emailAttempt->expires_at,
            'attempt_count' => $emailAttempt->attempt_count,
        ])->render();

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send customer status notification email
     */
    public function sendCustomerStatusEmail(Customer $customer, string $action, string $reason = null)
    {
        // Check if we can send this email (max 2 attempts)
        if (!EmailAttempt::canSendEmail($customer->email, 'customer_status', $action, $customer->id)) {
            \Log::info("Email limit reached for customer status: {$customer->email} - {$action}");
            return false;
        }

        // Create email attempt record
        $emailAttempt = EmailAttempt::createAttempt(
            $customer->email, 
            'customer_status', 
            $action, 
            $customer->id,
            null,
            null,
            24 // 24 hours expiration
        );

        if (!$emailAttempt) {
            \Log::warning("Failed to create email attempt for customer status: {$customer->email}");
            return false;
        }

        $subject = match($action) {
            'activated' => 'Account Activated - ' . config('app.name'),
            'deactivated' => 'Account Deactivated - ' . config('app.name'),
            default => 'Account Status Update - ' . config('app.name')
        };

        $htmlBody = view('emails.customer-status', [
            'customer' => $customer,
            'action' => $action,
            'reason' => $reason,
            'token' => $emailAttempt->token,
            'expires_at' => $emailAttempt->expires_at,
            'attempt_count' => $emailAttempt->attempt_count,
        ])->render();

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send subscription notification email
     */
    public function sendSubscriptionEmail(Customer $customer, Subscription $subscription, string $action = 'created')
    {
        // Check if we can send this email (max 2 attempts)
        if (!EmailAttempt::canSendEmail($customer->email, 'subscription', $action, $customer->id, $subscription->id, 'subscription')) {
            \Log::info("Email limit reached for subscription: {$customer->email} - {$action}");
            return false;
        }

        // Create email attempt record
        $emailAttempt = EmailAttempt::createAttempt(
            $customer->email, 
            'subscription', 
            $action, 
            $customer->id, 
            $subscription->id, 
            'subscription',
            24 // 24 hours expiration
        );

        if (!$emailAttempt) {
            \Log::warning("Failed to create email attempt for subscription: {$customer->email}");
            return false;
        }

        $subject = match($action) {
            'created' => 'New Subscription Created - ' . config('app.name'),
            'renewed' => 'Subscription Renewed - ' . config('app.name'),
            'cancelled' => 'Subscription Cancelled - ' . config('app.name'),
            'expired' => 'Subscription Expired - ' . config('app.name'),
            default => 'Subscription Update - ' . config('app.name')
        };

        $htmlBody = view('emails.subscription-notification', [
            'customer' => $customer,
            'subscription' => $subscription,
            'action' => $action,
            'token' => $emailAttempt->token,
            'expires_at' => $emailAttempt->expires_at,
            'attempt_count' => $emailAttempt->attempt_count,
        ])->render();

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send invoice notification email
     */
    public function sendInvoiceEmail(Customer $customer, Invoice $invoice)
    {
        $action = $invoice->status; // 'pending', 'paid', 'overdue'
        
        // Check if we can send this email (max 2 attempts)
        if (!EmailAttempt::canSendEmail($customer->email, 'invoice', $action, $customer->id, $invoice->id, 'invoice')) {
            \Log::info("Email limit reached for invoice: {$customer->email} - {$action}");
            return false;
        }

        // Create email attempt record
        $emailAttempt = EmailAttempt::createAttempt(
            $customer->email, 
            'invoice', 
            $action, 
            $customer->id, 
            $invoice->id, 
            'invoice',
            24 // 24 hours expiration
        );

        if (!$emailAttempt) {
            \Log::warning("Failed to create email attempt for invoice: {$customer->email}");
            return false;
        }

        $subject = 'Invoice #' . $invoice->code . ' - ' . config('app.name');

        $htmlBody = view('emails.invoice-notification', [
            'invoice' => $invoice,
            'customer' => $customer,
            'plan' => $invoice->plan,
            'currency' => $invoice->currency,
            'token' => $emailAttempt->token,
            'expires_at' => $emailAttempt->expires_at,
            'attempt_count' => $emailAttempt->attempt_count,
        ])->render();

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send welcome email to new customer
     */
    public function sendWelcomeEmail(Customer $customer)
    {
        $subject = 'Welcome to ' . config('app.name');

        $htmlBody = $this->welcomeEmailTemplate($customer);

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send email verification email
     */
    public function sendVerificationEmail(Customer $customer)
    {
        $subject = 'Verify Your Email Address - ' . config('app.name');

        $htmlBody = $this->verificationTemplate($customer);

        return $this->sendEmail($customer, $subject, $htmlBody);
    }

    /**
     * Send subscription activated email
     */
    public function sendSubscriptionActivatedEmail(Customer $customer, Plan $plan, string $workspaceName = null)
    {
        return $this->subscriptionActivatedEmail($customer, $plan, $workspaceName);
    }
}
