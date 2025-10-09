{{-- Customer Subscription --}}
@extends('layouts.customer')

@section('page-title', __('Subscription Management'))
@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('My Subscription')],
        ]
    ])
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Subscription Management') }}</h4>
                <p class="text-muted mb-0">{{ __('Manage your subscription and billing') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="viewBillingHistory()" class="btn btn-outline-info">
                    <i class="fas fa-history me-2"></i>{{ __('Billing History') }}
                </button>
                <button onclick="contactSupport()" class="btn btn-outline-warning">
                    <i class="fas fa-headset me-2"></i>{{ __('Contact Support') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Current Subscription -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2"></i>{{ __('Current Subscription') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                @if($currentPlan)
                                    <i class="fas fa-gem fa-2x text-primary"></i>
                                @else
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                                @endif
                            </div>
                            <div>
                                @if($currentPlan)
                                    <h4 class="mb-1">{{ $currentPlan->name }}</h4>
                                    <p class="text-muted mb-0">{{ $currentPlan->getDescriptionForLanguage($uiLocale) ?? __('Premium plan with advanced features') }}</p>
                                @else
                                    <h4 class="mb-1">{{ __('No Active Subscription') }}</h4>
                                    <p class="text-muted mb-0">{{ __('Subscribe to a plan to access all features') }}</p>
                                @endif
                            </div>
                        </div>

                        @if($company)
                            <div class="mb-3">
                                <h6 class="text-muted">{{ __('Company Information') }}</h6>
                                <p class="mb-1">
                                    <strong>{{ __('Company') }}:</strong> {{ $company->company_name }}
                                </p>
                                @if($company->vat_number)
                                    <p class="mb-1">
                                        <strong>{{ __('VAT Number') }}:</strong> {{ $company->vat_number }}
                                    </p>
                                @endif
                                @if($company->address)
                                    <p class="mb-0">
                                        <strong>{{ __('Address') }}:</strong> {{ $company->address }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex align-items-center gap-3">
                            @if($currentSubscription)
                                @if($currentSubscription->status === 'active')
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('Active') }}
                                    </span>
                                @elseif($currentSubscription->status === 'grace_period')
                                    <span class="badge bg-warning fs-6">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ __('Grace Period') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times-circle me-1"></i>{{ __('Expired') }}
                                    </span>
                                @endif

                                @if($currentSubscription->end_date)
                                    <span class="badge bg-info fs-6">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ __('Expires') }}: @userTime($currentSubscription->end_date, 'M d, Y')
                                    </span>
                                @endif

                                @if($currentSubscription->days_remaining > 0)
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $currentSubscription->days_remaining }} {{ __('days left') }}
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ __('No Subscription') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-center">
                            @if($currentPlan && isset($customerCountry))
                                @php
                                    $planPrice = $currentPlan->getPriceForCountry($customerCountry->id);
                                    $price = $planPrice ? $planPrice->price : 0;
                                    $currency = $planPrice && $planPrice->currency ? $planPrice->currency->getSymbol('en') : '$';
                                @endphp
                                <h3 class="text-primary mb-1">{{ $currency }}{{ number_format($price, 0) }}</h3>
                                <p class="text-muted mb-3">{{ __('per') }} {{ __(Str::camel($currentPlan->duration)) }}</p>
                            @else
                                <h3 class="text-muted mb-1">--</h3>
                                <p class="text-muted mb-3">{{ __('No Plan Selected') }}</p>
                            @endif

                            @if($availablePlans->count() > 0)
                                @if($currentPlan)
                                    <button class="btn btn-outline-primary btn-lg" onclick="upgradePlan()">
                                        <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                                    </button>
                                @else
                                    <button class="btn btn-primary btn-lg" onclick="upgradePlan()">
                                        <i class="fas fa-rocket me-2"></i>{{ __('Choose a Plan') }}
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Features -->
        @if($currentPlan)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list-check me-2"></i>{{ __('Plan Features') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($currentPlan->features && $currentPlan->features->count() > 0)
                        @php
                            $planFeature = $currentPlan->features->first();
                            $activeFeatures = $planFeature ? $planFeature->activeFeatures() : [];
                            $inactiveFeatures = $planFeature ? $planFeature->inactiveFeatures() : [];

                            // Add additional features from plan feature more_features JSON
                            $moreFeatures = $planFeature && $planFeature->more_featrues ? $planFeature->more_featrues : [];
                            if (is_array($moreFeatures)) {
                                $activeFeatures = array_merge($activeFeatures, $moreFeatures);
                            }
                        @endphp

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">{{ __('Included Features') }}</h6>
                                <ul class="list-unstyled">
                                    @if($planFeature && $planFeature->max_user > 0)
                                        <li class="mb-2">
                                            <i class="fas fa-users text-success me-2"></i>
                                            {{ __('Up to') }} {{ $planFeature->max_user }} {{ __('users') }}
                                        </li>
                                    @endif

                                    @foreach($activeFeatures as $feature)
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">{{ __('Premium Features') }}</h6>
                                <ul class="list-unstyled">
                                    @foreach($inactiveFeatures as $feature)
                                        <li class="mb-2">
                                            <i class="fas fa-times text-muted me-2"></i>
                                            <span class="text-muted">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Usage Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>{{ __('Usage Statistics') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ $customer->invoices->count() }}</h4>
                            <small class="text-muted">{{ __('Total Invoices') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-success mb-1">{{ $customer->companies->count() }}</h4>
                            <small class="text-muted">{{ __('Companies') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-info mb-1">0</h4>
                            <small class="text-muted">{{ __('Storage Used (GB)') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning mb-1">0</h4>
                        <small class="text-muted">{{ __('API Calls') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($currentPlan)
                        <button class="btn btn-primary" onclick="upgradePlan()">
                            <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                        </button>
                    @else
                        <button class="btn btn-primary" onclick="upgradePlan()">
                            <i class="fas fa-rocket me-2"></i>{{ __('Choose a Plan') }}
                        </button>
                    @endif
                    <button class="btn btn-outline-info" onclick="viewBillingHistory()">
                        <i class="fas fa-history me-2"></i>{{ __('Billing History') }}
                    </button>
                    <button class="btn btn-outline-warning" onclick="contactSupport()">
                        <i class="fas fa-headset me-2"></i>{{ __('Contact Support') }}
                    </button>
                    @if($currentSubscription)
                        <form method="POST" action="{{ route('customer.subscription.cancel', ) }}"
                              onsubmit="return confirm('{{ __('Are you sure you want to cancel your subscription? This action cannot be undone.') }}')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>{{ __('Cancel Subscription') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card me-2"></i>{{ __('Billing Information') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-credit-card fa-3x text-muted"></i>
                    <p class="text-muted mt-2">{{ __('No payment method required') }}</p>
                </div>
                <div class="d-grid">
                    <button class="btn btn-outline-primary btn-sm" onclick="addPaymentMethod()">
                        <i class="fas fa-plus me-2"></i>{{ __('Add Payment Method') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Next Billing -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>{{ __('Next Billing') }}
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($currentPlan)
                        <i class="fas fa-calendar-check fa-3x text-primary"></i>
                    @else
                        <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                    @endif
                </div>
                @if($currentPlan)
                    <h5 class="text-primary">{{ __('Next Billing Date') }}</h5>
                    <p class="text-muted mb-0">{{ __('Your next billing cycle will be processed automatically.') }}</p>
                @else
                    <h5 class="text-warning">{{ __('No Active Subscription') }}</h5>
                    <p class="text-muted mb-0">{{ __('Subscribe to a plan to start your billing cycle.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function upgradePlan() {
        // Redirect to plans page
        window.location.href = '{{ route("customer.plan-requests.index") }}';
    }

    function viewBillingHistory() {
        // Redirect to billing history
        window.location.href = '{{ route("customer.subscription.billing") }}';
    }

    function contactSupport() {
        // Open support contact form or redirect
        window.location.href = '{{ route("public.contact") }}';
    }

    function addPaymentMethod() {
        // Show payment method modal
        const modal = new bootstrap.Modal(document.getElementById('paymentMethodModal'));
        modal.show();
    }

    function showToast(message, type = 'info') {
        const toast = new bootstrap.Toast(document.getElementById('toast'));
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toast').className = `toast position-fixed top-0 end-0 p-3 toast-${type}`;
        toast.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any additional functionality
        console.log('Subscription page loaded');
    });
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
                <button type="button" class="btn btn-primary">{{ __('Add Payment Method') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast position-fixed top-0 end-0 p-3" style="z-index: 9999" id="toast">
    <div class="toast-header">
        <i class="fas fa-info-circle text-primary me-2"></i>
        <strong class="me-auto">{{ __('Notification') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="toastMessage">
        {{ __('Message') }}
    </div>
</div>
