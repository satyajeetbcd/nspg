{{-- Customer Dashboard --}}
@extends('layouts.customer')

@section('breadcrumbs')
    <div class="d-flex flex-column">
        <h4 class="mb-1">{{ __('Welcome back, :name!', ['name' => $customer->name]) }}</h4>
        <p class="text-muted mb-0">
            @if($company)
                {{ __('Managing :company', ['company' => $company->company_name]) }}
            @else
                {{ __('Your customer dashboard') }}
            @endif
        </p>
    </div>
@endsection
@section('content')

{{-- Removed welcome hero card; moved welcome to header --}}

<div class="row">
    <!-- Plan Overview -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2"></i>{{ __('Current Plan') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        @if($currentPlan)
                            <h4 class="text-primary mb-2">{{ $currentPlan->name }}</h4>
                            <p class="text-muted mb-2">{{ $currentPlan->getDescriptionForLanguage($uiLocale) ?? __('Premium plan with advanced features') }}</p>

                            @if($currentSubscription)
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    <strong>{{ __('Expires') }}:</strong>
                                    {{ $currentSubscription->end_date ? $currentSubscription->end_date->format('M d, Y') : __('No expiration') }}
                                </p>

                                @if($currentSubscription->end_date && $currentSubscription->end_date->isFuture())
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>{{ __('Days Remaining') }}:</strong> {{ $currentSubscription->days_remaining }} {{ __('days') }}
                                    </p>
                                @endif
                            @endif
                        @else
                            <h4 class="text-muted mb-2">{{ __('No Active Plan') }}</h4>
                            <p class="text-muted mb-2">{{ __('You are currently on a free plan with limited features') }}</p>
                        @endif

                        @if($company)
                            <p class="text-muted mb-2">
                                <i class="fas fa-building me-2"></i>
                                <strong>{{ __('Company') }}:</strong> {{ $company->company_name }}
                            </p>
                            @if($company->vat_number)
                                <p class="text-muted mb-2">
                                    <i class="fas fa-id-card me-2"></i>
                                    <strong>{{ __('VAT') }}:</strong> {{ $company->vat_number }}
                                </p>
                            @endif
                        @endif

                        <p class="mb-2">
                            @if($currentPlan)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>{{ __('Active') }}
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ __('Free Plan') }}
                                </span>
                            @endif
                        </p>

                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar {{ $currentPlan ? 'bg-success' : 'bg-warning' }}"
                                 role="progressbar"
                                 style="width: {{ $progress }}%">
                            </div>
                        </div>
                        <small class="text-muted">{{ __('Plan Usage: :percentage%', ['percentage' => $progress]) }}</small>
                    </div>
                    <div class="col-md-4 text-end">
                        @if($currentPlan)
                            <a href="{{ route('customer.plan-requests.index') }}"
                               class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                            </a>
                        @else
                            <a href="{{ route('customer.plan-requests.index') }}"
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-crown me-2"></i>{{ __('Choose Plan') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Features -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list-check me-2"></i>{{ __('Plan Features') }}
                </h5>
            </div>
            <div class="card-body">
                @if($currentPlan)
                    <div class="row">
                        @foreach($modules as $name => $module)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 border rounded {{ !$module['value'] ? 'bg-light' : 'bg-light-success' }}">
                                    <div class="me-3">
                                        <i class="fas fa-{{ $module['value'] ? 'check-circle text-success' : 'times-circle text-muted' }} fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 {{ !$module['value'] ? 'text-muted' : 'text-success' }}">{{ __($name) }}</h6>
                                        <small class="text-muted">{{ __($module['tooltip']) }}</small>
                                        @if($name === 'Storage Limit')
                                            <div class="mt-1">
                                                <span class="badge {{ $module['value'] > 0 ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $module['value'] ? $module['value'] . ' GB' : '0 GB' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="mt-1">
                                                <span class="badge {{ $module['value'] ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $module['value'] ? __('Enabled') : __('Disabled') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($currentPlan->features && $currentPlan->features->first() && $currentPlan->features->first()->more_featrues)
                        @php
                            $additionalFeatures = $currentPlan->features->first()->more_featrues;
                        @endphp
                        @if(is_array($additionalFeatures) && count($additionalFeatures) > 0)
                            <div class="mt-4">
                                <h6 class="text-muted mb-3">{{ __('Additional Features') }}</h6>
                                <div class="row">
                                    @foreach($additionalFeatures as $feature)
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-check text-success me-2"></i>
                                                <span class="text-muted">{{ $feature }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('No Active Plan') }}</h5>
                        <p class="text-muted mb-3">{{ __('Subscribe to a plan to unlock all features') }}</p>
                        <a href="{{ route('customer.plan-requests.index') }}"
                           class="btn btn-primary">
                            <i class="fas fa-crown me-2"></i>{{ __('View Available Plans') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>{{ __('Quick Stats') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ $customer->invoices->count() }}</h4>
                            <small class="text-muted">{{ __('Total Invoices') }}</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success mb-1">{{ $customer->invoices->where('status', 'paid')->count() }}</h4>
                        <small class="text-muted">{{ __('Paid Invoices') }}</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning mb-1">{{ $customer->invoices->where('status', 'pending')->count() }}</h4>
                        <small class="text-muted">{{ __('Pending') }}</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info mb-1">{{ $customer->companies->count() }}</h4>
                        <small class="text-muted">{{ __('Companies') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>{{ __('Recent Activity') }}
                </h5>
            </div>
            <div class="card-body">
                @if($customer->invoices->count() > 0)
                    @foreach($customer->invoices->take(3) as $invoice)
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-file-invoice text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ __('Invoice') }} #{{ $invoice->id }}</h6>
                                <small class="text-muted">{{ $invoice->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                <span class="badge bg-success">{{ __('Paid') }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">{{ __('No recent activity') }}</p>
                    </div>
                @endif
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
                    <a href="{{ route('customer.profile.index', ) }}"
                       class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i>{{ __('Update Profile') }}
                    </a>
                    <a href="{{ route('customer.invoices.index', ) }}"
                       class="btn btn-outline-success">
                        <i class="fas fa-file-invoice me-2"></i>{{ __('View Invoices') }}
                    </a>
                    <a href="{{ route('customer.subscription.index', ) }}"
                       class="btn btn-outline-warning">
                        <i class="fas fa-credit-card me-2"></i>{{ __('Manage Subscription') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
