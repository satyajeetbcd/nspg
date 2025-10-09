{{-- Customer Subscription History --}}
@extends('layouts.customer')

@section('page-title', __('Subscription History'))
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Subscription History') }}</h4>
                <p class="text-muted mb-0">{{ __('View your complete subscription and billing history') }}</p>
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
    <!-- Subscription History -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2"></i>{{ __('Subscription History') }}
                </h5>
            </div>
            <div class="card-body">
                @if($subscriptionHistory->count() > 0)
                    <div class="timeline">
                        @foreach($subscriptionHistory as $subscription)
                            <div class="timeline-item mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <div class="timeline-marker">
                                            <i class="fas fa-{{ $subscription->status === 'active' ? 'check-circle text-success' : ($subscription->status === 'grace_period' ? 'exclamation-circle text-warning' : 'times-circle text-danger') }} fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $subscription->plan->name }}</h6>
                                                        <p class="text-muted mb-2">{{ $subscription->plan->description }}</p>
                                                        <div class="d-flex gap-3">
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>
                                                                {{ $subscription->start_date->format('M d, Y') }} -
                                                                {{ $subscription->end_date->format('M d, Y') }}
                                                            </small>
                                                            <small class="text-muted">
                                                                <i class="fas fa-clock me-1"></i>
                                                                {{ $subscription->end_date->diffInDays($subscription->start_date) }} {{ __('days') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-{{ $subscription->status === 'active' ? 'success' : ($subscription->status === 'grace_period' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                                                        </span>
                                                        @if($subscription->plan->features->count() > 0)
                                                            <div class="mt-2">
                                                                <small class="text-muted">
                                                                    {{ $subscription->plan->features->first()->activeFeatures() ? count($subscription->plan->features->first()->activeFeatures()) : 0 }} {{ __('features') }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $subscriptionHistory->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5>{{ __('No Subscription History') }}</h5>
                        <p class="text-muted">{{ __('You haven\'t had any subscriptions yet.') }}</p>
                        <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                            <i class="fas fa-rocket me-2"></i>{{ __('Browse Plans') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Invoice History Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>{{ __('Recent Invoices') }}
                </h5>
            </div>
            <div class="card-body">
                @if($invoiceHistory->count() > 0)
                    @foreach($invoiceHistory->take(5) as $invoice)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <h6 class="mb-1">#{{ $invoice->code }}</h6>
                                <small class="text-muted">{{ $invoice->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">{{ __('Paid') }}</span>
                                <div>
                                    <small class="text-muted">
                                        @if($invoice->plan)
                                            @php
                                                $planPrice = $invoice->plan->prices()->first();
                                                $price = $planPrice ? $planPrice->price : 0;
                                                $currency = $planPrice && $planPrice->currency ? $planPrice->currency->symbol : '$';
                                            @endphp
                                            {{ $currency }}{{ number_format($price, 2) }}
                                        @else
                                            $0.00
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($invoiceHistory->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('customer.invoices.index', ) }}" class="btn btn-sm btn-outline-primary">
                                {{ __('View All Invoices') }}
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">{{ __('No invoices yet') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>{{ __('Summary') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <h5 class="text-primary mb-1">{{ $subscriptionHistory->count() }}</h5>
                        <small class="text-muted">{{ __('Total Subscriptions') }}</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success mb-1">{{ $invoiceHistory->count() }}</h5>
                        <small class="text-muted">{{ __('Total Invoices') }}</small>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <h6 class="text-muted mb-2">{{ __('Member Since') }}</h6>
                    <p class="mb-0">{{ $customer->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: relative;
    z-index: 2;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 50px;
    left: calc(8.33% + 15px);
    width: 2px;
    height: calc(100% - 30px);
    background: #dee2e6;
    z-index: 1;
}

@media (max-width: 767px) {
    .timeline-item:not(:last-child)::after {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Subscription history page loaded');
    });
</script>
@endpush



