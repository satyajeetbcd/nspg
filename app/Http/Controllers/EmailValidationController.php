<?php

namespace App\Http\Controllers;

use App\Models\EmailAttempt;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailValidationController extends Controller
{
    /**
     * Validate email token and redirect to appropriate action
     */
    public function validateToken(Request $request, $token)
    {
        $emailAttempt = EmailAttempt::validateAndUseToken($token);
        
        if (!$emailAttempt) {
            return redirect()->route('public.home', ['locale' => app()->getLocale()])
                ->with('error', 'Invalid or expired email link.');
        }

        // Log the successful validation
        \Log::info("Email token validated successfully", [
            'email' => $emailAttempt->email,
            'type' => $emailAttempt->type,
            'action' => $emailAttempt->action,
            'customer_id' => $emailAttempt->customer_id,
        ]);

        // Redirect based on email type and action
        switch ($emailAttempt->type) {
            case 'plan_assignment':
                return $this->handlePlanAssignmentValidation($emailAttempt);
                
            case 'customer_status':
                return $this->handleCustomerStatusValidation($emailAttempt);
                
            case 'subscription':
                return $this->handleSubscriptionValidation($emailAttempt);
                
            case 'invoice':
                return $this->handleInvoiceValidation($emailAttempt);
                
            default:
                return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
                    ->with('success', 'Email link validated successfully.');
        }
    }

    /**
     * Handle plan assignment email validation
     */
    private function handlePlanAssignmentValidation(EmailAttempt $emailAttempt)
    {
        $customer = Customer::find($emailAttempt->customer_id);
        $plan = $emailAttempt->related_id ? Plan::find($emailAttempt->related_id) : null;

        if (!$customer) {
            return redirect()->route('public.home', ['locale' => app()->getLocale()])
                ->with('error', 'Customer not found.');
        }

        $message = match($emailAttempt->action) {
            'assigned' => 'Plan assignment confirmed successfully.',
            'upgraded' => 'Plan upgrade confirmed successfully.',
            'downgraded' => 'Plan change confirmed successfully.',
            'removed' => 'Plan removal confirmed successfully.',
            default => 'Plan update confirmed successfully.'
        };

        return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
            ->with('success', $message);
    }

    /**
     * Handle customer status email validation
     */
    private function handleCustomerStatusValidation(EmailAttempt $emailAttempt)
    {
        $customer = Customer::find($emailAttempt->customer_id);

        if (!$customer) {
            return redirect()->route('public.home', ['locale' => app()->getLocale()])
                ->with('error', 'Customer not found.');
        }

        $message = match($emailAttempt->action) {
            'activated' => 'Account activation confirmed successfully.',
            'deactivated' => 'Account deactivation confirmed successfully.',
            default => 'Account status update confirmed successfully.'
        };

        return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
            ->with('success', $message);
    }

    /**
     * Handle subscription email validation
     */
    private function handleSubscriptionValidation(EmailAttempt $emailAttempt)
    {
        $customer = Customer::find($emailAttempt->customer_id);
        $subscription = $emailAttempt->related_id ? Subscription::find($emailAttempt->related_id) : null;

        if (!$customer) {
            return redirect()->route('public.home', ['locale' => app()->getLocale()])
                ->with('error', 'Customer not found.');
        }

        $message = match($emailAttempt->action) {
            'created' => 'Subscription creation confirmed successfully.',
            'renewed' => 'Subscription renewal confirmed successfully.',
            'cancelled' => 'Subscription cancellation confirmed successfully.',
            'expired' => 'Subscription expiration confirmed successfully.',
            default => 'Subscription update confirmed successfully.'
        };

        return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
            ->with('success', $message);
    }

    /**
     * Handle invoice email validation
     */
    private function handleInvoiceValidation(EmailAttempt $emailAttempt)
    {
        $customer = Customer::find($emailAttempt->customer_id);
        $invoice = $emailAttempt->related_id ? Invoice::find($emailAttempt->related_id) : null;

        if (!$customer) {
            return redirect()->route('public.home', ['locale' => app()->getLocale()])
                ->with('error', 'Customer not found.');
        }

        $message = match($emailAttempt->action) {
            'pending' => 'Invoice notification confirmed successfully.',
            'paid' => 'Invoice payment confirmation received successfully.',
            'overdue' => 'Invoice overdue notification confirmed successfully.',
            default => 'Invoice update confirmed successfully.'
        };

        return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
            ->with('success', $message);
    }

    /**
     * Check if token is valid (API endpoint)
     */
    public function checkToken(Request $request, $token)
    {
        $isValid = EmailAttempt::isTokenValid($token);
        
        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Token is valid' : 'Token is invalid or expired'
        ]);
    }

    /**
     * Get email attempt statistics (for admin/staff)
     */
    public function getStats(Request $request)
    {
        $stats = [
            'total_attempts' => EmailAttempt::count(),
            'used_attempts' => EmailAttempt::where('is_used', true)->count(),
            'expired_attempts' => EmailAttempt::where('expires_at', '<', now())->count(),
            'active_attempts' => EmailAttempt::where('expires_at', '>', now())
                ->where('is_used', false)
                ->count(),
        ];

        return response()->json($stats);
    }
}
