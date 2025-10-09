{{-- Customer Plan Requests - Better UI --}}
@extends('layouts.customer')

@section('title', __('Available Plans'))

@section('content')

<!-- Success/Error Messages moved to top -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>{{ __('Please fix the following errors:') }}</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Available Plans') }}</h4>
                <p class="text-muted mb-0">{{ __('Choose the perfect plan for your business needs') }}</p>
            </div>
            <div>
                <a href="{{ route('customer.subscription.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Subscription') }}
                </a>
            </div>
        </div>
    </div>
</div>


@if($currentPlan)
<div class="alert alert-info mb-4">
    <div class="d-flex align-items-center">
        <i class="fas fa-info-circle me-3"></i>
        <div>
            <strong>{{ __('Current Plan') }}:</strong> {{ $currentPlan->name }}
            <span class="badge bg-primary ms-2">{{ __('Active') }}</span>
        </div>
    </div>
</div>
@endif

@if($availablePlans->count() > 0)
<div class="row g-3">
    @foreach($availablePlans as $plan)
        @php
            $isCurrentPlan = isset($currentPlan) && $currentPlan?->id === $plan->id;
            $planPrice = $plan->getPriceForCountry($customerCountry?->id);
            $price = $planPrice ? $planPrice->price : 0;
            $currency = $planPrice && $planPrice->currency ? $planPrice->currency->getSymbol(app()->getLocale()) : '$';
     
        @endphp

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card plan-card h-100 @if($isCurrentPlan) border-primary current-plan @endif">
                <div class="card-header text-center py-3 @if($isCurrentPlan) bg-primary text-white @endif">
                    <h5 class="mb-1">{{ $plan->name }}</h5>
                    @if($isCurrentPlan)
                        <span class="badge bg-light text-primary">{{ __('Current Plan') }}</span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column p-3">
                    <div class="text-center mb-2">
                        <h4 class="text-primary mb-0">
                            {{ $currency }}{{ number_format($price, 0) }}
                        </h4>
                        <small class="text-muted">/{{ ucfirst($plan->duration) }}</small>
                    </div>

                    @if($plan->features && $plan->features->count() > 0)
                        @php
                            $planFeature = $plan->features->first();
                            $activeFeatures = $planFeature ? $planFeature->activeFeatures() : [];
                        @endphp
                        <div class="plan-features mb-2 flex-grow-1">
                            <h6 class="text-muted mb-1 small">{{ __('Features') }}</h6>
                            <ul class="list-unstyled small">
                                <!-- Display max users -->
                                @if($planFeature && $planFeature->max_user > 0)
                                    <li class="mb-1">
                                        <i class="fas fa-users text-success me-2"></i>
                                        {{ __('Up to :count users', ['count' => $planFeature->max_user]) }}
                                    </li>
                                @endif

                                <!-- Display active modules/features -->
                                @if(count($activeFeatures) > 0)
                                    @foreach($activeFeatures as $feature)
                                        <li class="mb-1">
                                            <i class="fas fa-check text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                @else
                                    <!-- Fallback basic features -->
                                    <li class="mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        {{ __('Dashboard Access') }}
                                    </li>
                                    <li class="mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        {{ __('Basic Invoicing') }}
                                    </li>
                                    <li class="mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        {{ __('Profile Management') }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @else
                        <div class="plan-features mb-2 flex-grow-1">
                            <h6 class="text-muted mb-1 small">{{ __('Features') }}</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('Basic Plan Features') }}
                                </li>
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('Dashboard Access') }}
                                </li>
                                <li class="mb-1">
                                    <i class="fas fa-info-circle text-info me-2"></i>
                                    {{ __('Contact support for details') }}
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="mt-auto">
                        @if($isCurrentPlan)
                            <button class="btn btn-outline-primary w-100 btn-sm" disabled>
                                <i class="fas fa-check me-2"></i>{{ __('Current Plan') }}
                            </button>
                        @else
                            <form method="POST" action="{{ route('customer.plan-requests.store') }}"
                                  onsubmit="return confirmPlanRequest(this)">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <input type="hidden" name="order_type" value="{{ !$currentPlan ? 'new_subscription' : 'upgrade' }}">
                                <input type="hidden" name="country_id" value="{{ $customerCountry?->id ?? ''}}">

                                <button type="submit" class="btn btn-primary w-100 btn-sm">
                                    @if(!$currentPlan)
                                        <i class="fas fa-crown me-2"></i>{{ __('Subscribe Now') }}
                                    @else
                                        <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Now') }}
                                    @endif
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Custom Plan Card -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card plan-card h-100 border-dashed">
            <div class="card-header text-center py-3 bg-light">
                <h5 class="mb-1 text-muted">{{ __('Custom Plan') }}</h5>
                <span class="badge bg-secondary">{{ __('Tailored Solution') }}</span>
            </div>

            <div class="card-body d-flex flex-column p-3 text-center">
                <div class="mb-2">
                    <i class="fas fa-cogs fa-2x text-muted mb-2"></i>
                    <h5 class="text-muted mb-1">{{ __('Let\'s Discuss') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Need something specific?') }}</p>
                </div>

                <div class="plan-features mb-2 flex-grow-1">
                    <h6 class="text-muted mb-1 small">{{ __('What You Get') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ __('Personalized Features') }}
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ __('Custom Pricing') }}
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ __('Dedicated Support') }}
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ __('Flexible Terms') }}
                        </li>
                    </ul>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('public.contact') }}?subject={{ urlencode(__('Custom Plan Request')) }}"
                       class="btn btn-outline-primary w-100 btn-sm">
                        <i class="fas fa-comments me-2"></i>{{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-muted mb-4"></i>
                <h4 class="mb-3">{{ __('No Standard Plans Available') }}</h4>
                <p class="text-muted mb-4">{{ __('Currently, there are no standard subscription plans available. However, we can create a custom plan tailored to your specific needs.') }}</p>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('public.contact') }}?subject={{ urlencode(__('Custom Plan Request')) }}" class="btn btn-primary">
                        <i class="fas fa-comments me-2"></i>{{ __('Request Custom Plan') }}
                    </a>
                    <a href="{{ route('customer.subscription.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Subscription') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>

/* Plan Cards */
.plan-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 2px solid #e9ecef;
    min-height: 350px;
}

.plan-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.plan-card.border-primary {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.plan-card.current-plan {
    background: linear-gradient(135deg, #f8f9ff 0%, #e6f3ff 100%);
}

.plan-card.border-dashed {
    border: 2px dashed #dee2e6;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.plan-card.border-dashed:hover {
    border-color: #adb5bd;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
}

.plan-features ul li {
    padding: 0.1rem 0;
    font-size: 0.9rem;
}

/* Loading State */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .plan-card {
        min-height: auto;
        margin-bottom: 1rem;
    }

    .plan-card .card-body {
        padding: 1rem;
    }

    .plan-features ul li {
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .plan-card .card-header {
        padding: 0.75rem;
    }

    .plan-card .card-body {
        padding: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmPlanRequest(form) {
    const planName = form.closest('.plan-card').querySelector('h5').textContent;
    const confirmMessage = '{{ __("Are you sure you want to request the :plan plan?") }}'.replace(':plan', planName);

    if (!confirm(confirmMessage)) {
        return false;
    }

    // Add loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endpush
