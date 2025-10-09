{{-- Customer Billing --}}
@extends('layouts.customer')

@section('page-title', __('Billing Information'))
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Billing Information') }}</h4>
                <p class="text-muted mb-0">{{ __('Manage your payment methods and billing details') }}</p>
            </div>
            <div>
                <a href="{{ route('customer.subscription.index', ) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Subscription') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Current Billing Status -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>{{ __('Billing Status') }}
                </h5>
            </div>
            <div class="card-body">
                @if($currentSubscription)
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Current Plan') }}</h6>
                            <p class="mb-1">{{ $currentSubscription->plan->name }}</p>

                            <h6 class="text-muted mt-3">{{ __('Billing Cycle') }}</h6>
                            <p class="mb-1">{{ __(ucfirst($currentSubscription->plan->duration)) }}</p>

                            <h6 class="text-muted mt-3">{{ __('Status') }}</h6>
                            <span class="badge bg-{{ $currentSubscription->status === 'active' ? 'success' : ($currentSubscription->status === 'grace_period' ? 'warning' : 'danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $currentSubscription->status)) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Started') }}</h6>
                            <p class="mb-1">{{ $currentSubscription->start_date->format('M d, Y') }}</p>

                            @if($nextBillingDate)
                                <h6 class="text-muted mt-3">{{ __('Next Billing Date') }}</h6>
                                <p class="mb-1">{{ $nextBillingDate->format('M d, Y') }}</p>
                            @endif

                            @if($currentSubscription->days_remaining > 0)
                                <h6 class="text-muted mt-3">{{ __('Days Remaining') }}</h6>
                                <p class="mb-1">{{ $currentSubscription->days_remaining }} {{ __('days') }}</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <h5>{{ __('No Active Subscription') }}</h5>
                        <p class="text-muted">{{ __('You are currently on a free plan with no billing required.') }}</p>
                        <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                            <i class="fas fa-rocket me-2"></i>{{ __('View Plans') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Billing History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>{{ __('Billing History') }}
                </h5>
            </div>
            <div class="card-body">
                @if($customer->invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Invoice') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Plan') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->invoices()->latest()->limit(10)->get() as $invoice)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">#{{ $invoice->code }}</span>
                                        </td>
                                        <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                        <td>{{ $invoice->plan->name ?? __('N/A') }}</td>
                                        <td>
                                            @if($invoice->plan)
                                                @php
                                                    $customerCountry = \App\Models\Country::where('code', 'SA')->first() ?: \App\Models\Country::first();
                                                    $planPrice = $invoice->plan->getPriceForCountry($customerCountry->id);
                                                    $price = $planPrice ? $planPrice->price : 0;
                                                    $currency = $planPrice && $planPrice->currency ? $planPrice->currency->getSymbol(app()->getLocale()) : '$';
                                                @endphp
                                                {{ $currency }}{{ number_format($price, 2) }}
                                            @else
                                                $0.00
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ __('Paid') }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('customer.subscription.invoice', ['invoice' => $invoice->id]) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>{{ __('View') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                        <h5>{{ __('No Billing History') }}</h5>
                        <p class="text-muted">{{ __('You have no billing history yet.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card me-2"></i>{{ __('Payment Methods') }}
                </h5>
            </div>
            <div class="card-body">
                @if(count($paymentMethods) > 0)
                    @foreach($paymentMethods as $method)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">**** **** **** {{ $method['last4'] }}</h6>
                                    <small class="text-muted">{{ $method['brand'] }} • {{ $method['exp_month'] }}/{{ $method['exp_year'] }}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('No payment methods added') }}</p>
                    </div>
                @endif

                <div class="d-grid">
                    <button class="btn btn-outline-primary" onclick="addPaymentMethod()">
                        <i class="fas fa-plus me-2"></i>{{ __('Add Payment Method') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                    </a>
                    <a href="{{ route('customer.subscription.history', ) }}" class="btn btn-outline-info">
                        <i class="fas fa-history me-2"></i>{{ __('View All History') }}
                    </a>
                    <button class="btn btn-outline-warning" onclick="contactSupport()">
                        <i class="fas fa-headset me-2"></i>{{ __('Contact Support') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function addPaymentMethod() {
        // Show payment method modal
        const modal = new bootstrap.Modal(document.getElementById('paymentMethodModal'));
        modal.show();
    }

    function contactSupport() {
        // Open support contact form or redirect
        window.location.href = '{{ route("public.contact") }}';
    }
</script>
@endpush

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentMethodModalLabel">{{ __('Add Payment Method') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                    <h5>{{ __('Payment Method Setup') }}</h5>
                    <p class="text-muted">{{ __('Add a payment method for future upgrades and billing.') }}</p>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Card Number') }}</label>
                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Expiry Date') }}</label>
                                <input type="text" class="form-control" placeholder="MM/YY">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('CVV') }}</label>
                                <input type="text" class="form-control" placeholder="123">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Cardholder Name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('Full Name') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="showMessage()">{{ __('Add Payment Method') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
function showMessage() {
    alert('{{ __("Payment method functionality will be integrated with payment gateway") }}');
    bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal')).hide();
}
</script>
