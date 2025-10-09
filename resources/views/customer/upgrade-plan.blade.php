@extends('layouts.customer')

@section('title', __('Upgrade Plan'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Plan Upgrade') }}</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>{{ __('New Plan Request System') }}</strong><br>
                        {{ __('We\'ve improved our subscription management! Plan changes now go through our new order system for better tracking and payment processing.') }}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ __('Current Plan') }}</h5>
                            @if($currentPlan)
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $currentPlan->name }}</h6>
                                        <p class="text-muted">{{ $currentPlan->description }}</p>
                                        <p><strong>{{ __('Duration') }}:</strong> {{ ucfirst($currentPlan->duration) }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    {{ __('You don\'t have an active plan currently.') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5>{{ __('Requested Plan') }}</h5>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">{{ $plan->name }}</h6>
                                    <p class="text-muted">{{ $plan->description }}</p>
                                    <p><strong>{{ __('Price') }}:</strong> {{ $planPrice ? number_format($planPrice->price, 2) . ' ' . ($planPrice->currency->name ?? 'USD') : 'N/A' }}</p>
                                    <p><strong>{{ __('Duration') }}:</strong> {{ ucfirst($plan->duration) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>{{ __('How the New System Works') }}</h5>
                                    <ol>
                                        <li>{{ __('Submit a plan request') }}</li>
                                        <li>{{ __('Review order details and pricing') }}</li>
                                        <li>{{ __('Complete payment') }}</li>
                                        <li>{{ __('Your subscription is automatically updated') }}</li>
                                        <li>{{ __('Receive invoice for your records') }}</li>
                                    </ol>

                                    <div class="mt-3">
                                        <strong>{{ __('Benefits:') }}</strong>
                                        <ul class="list-unstyled mt-2">
                                            <li><i class="fas fa-check text-success"></i> {{ __('Complete order tracking') }}</li>
                                            <li><i class="fas fa-check text-success"></i> {{ __('Payment security') }}</li>
                                            <li><i class="fas fa-check text-success"></i> {{ __('Automatic invoice generation') }}</li>
                                            <li><i class="fas fa-check text-success"></i> {{ __('Order history and audit trail') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('customer.plan-requests.index', ) }}"
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-right"></i> {{ __('Continue with Plan Request') }}
                            </a>

                            <a href="{{ route('customer.subscription.index', ) }}"
                               class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to Subscription') }}
                            </a>
                        </div>
                    </div>

                    <!-- Quick upgrade form (for immediate processing) -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">{{ __('Quick Upgrade (Direct to Plan Request)') }}</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">{{ __('Skip the plan selection and create an order directly for this plan.') }}</p>

                                    <form action="{{ route('customer.plan-requests.store', ) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="country_id" value="{{ $customerCountry->id }}">
                                        <input type="hidden" name="order_type" value="{{ $currentPlan ? 'upgrade' : 'new_subscription' }}">

                                        <div class="form-group">
                                            <label for="notes">{{ __('Notes (Optional)') }}</label>
                                            <textarea name="notes" id="notes" class="form-control" rows="2"
                                                      placeholder="{{ __('Any specific requirements or notes...') }}">{{ __('Upgrade request from subscription page for plan: ') }}{{ $plan->name }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-shopping-cart"></i>
                                            {{ __('Create Order for') }} {{ $plan->name }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
