@extends('staff.layouts.master')

@section('page-title')
    {{ __('Subscription Details') }} - {{ $subscription->customer->name }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Subscription Details --}}
    <div class="container mt-4">
        <div class="row">
            {{-- Subscription Information --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-credit-card me-2"></i>{{ __('Subscription Information') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.subscriptions.edit', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit') }}
                            </a>
                            @if($subscription->status === 'active')
                                <form action="{{ route('staff.subscriptions.renew', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-arrow-repeat me-1"></i>{{ __('Renew') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Customer') }}</label>
                                <div>
                                    <div class="fw-semibold">{{ $subscription->customer->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $subscription->customer->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Plan') }}</label>
                                <div>
                                    <span class="badge bg-info-subtle text-info fs-6">
                                        {{ $subscription->plan->name ?? __('No Plan') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Status') }}</label>
                                <div>
                                    @php
                                        $statusClasses = [
                                            'active' => 'bg-success-subtle text-success',
                                            'grace_period' => 'bg-warning-subtle text-warning',
                                            'expired' => 'bg-danger-subtle text-danger'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClasses[$subscription->status] ?? 'bg-secondary-subtle text-secondary' }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Days Remaining') }}</label>
                                <div class="fw-bold fs-5 {{ $subscription->days_remaining < 7 ? 'text-danger' : ($subscription->days_remaining < 30 ? 'text-warning' : 'text-success') }}">
                                    {{ $subscription->days_remaining > 0 ? $subscription->days_remaining : 0 }} {{ __('days') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Start Date') }}</label>
                                <div class="fw-semibold">
                                    {{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('End Date') }}</label>
                                <div class="fw-semibold">
                                    {{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Grace Date') }}</label>
                                <div class="fw-semibold">
                                    {{ $subscription->grace_date ? $subscription->grace_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div>{{ $subscription->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subscription Features --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-star me-2"></i>{{ __('Subscription Features') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($subscription->subscriptionFeatures && $subscription->subscriptionFeatures->count() > 0)
                            <div class="row g-3">
                                @foreach($subscription->subscriptionFeatures as $feature)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle-fill text-success fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 fw-semibold">{{ $feature->feature_name }}</h6>
                                                <p class="mb-1 text-muted small">{{ $feature->feature_description }}</p>
                                                @if($feature->feature_limit)
                                                    <small class="text-info">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Limit: {{ $feature->feature_limit }}
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if($feature->is_enabled)
                                                    <span class="badge bg-success">{{ __('Enabled') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('Disabled') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-circle display-4 text-muted mb-3"></i>
                                <h6 class="text-muted">{{ __('No features assigned') }}</h6>
                                <p class="text-muted small">{{ __('This subscription does not have any features assigned yet.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions Panel --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white ">
                            <i class="fas fa-gear me-2"></i>{{ __('Actions') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('staff.subscriptions.edit', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit Subscription') }}
                            </a>
                            
                            @if($subscription->status === 'active')
                                <form action="{{ route('staff.subscriptions.renew', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-arrow-repeat me-1"></i>{{ __('Renew Subscription') }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('staff.subscriptions.cancel', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-x-circle me-1"></i>{{ __('Cancel Subscription') }}
                                    </button>
                                </form>
                            @endif

                            @if($subscription->status === 'grace_period')
                                <form action="{{ route('staff.subscriptions.extend-grace', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-info w-100">
                                        <i class="fas fa-clock me-1"></i>{{ __('Extend Grace Period') }}
                                    </button>
                                </form>
                            @endif

                            <hr>

                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>{{ __('Delete Subscription') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Status Timeline --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-clock-history me-2"></i>{{ __('Status Timeline') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">{{ __('Subscription Created') }}</h6>
                                    <small class="text-muted">{{ $subscription->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">{{ __('Started') }}</h6>
                                    <small class="text-muted">{{ $subscription->start_date->format('M d, Y') }}</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $subscription->status === 'active' ? 'bg-success' : 'bg-warning' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">{{ __('Expires') }}</h6>
                                    <small class="text-muted">{{ $subscription->end_date->format('M d, Y') }}</small>
                                </div>
                            </div>
                            
                            @if($subscription->grace_date)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-danger"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-semibold">{{ __('Grace Period Ends') }}</h6>
                                        <small class="text-muted">{{ $subscription->grace_date->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete Subscription') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this subscription? This action cannot be undone.') }}</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ __('This will also remove the plan assignment from the customer.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('staff.subscriptions.destroy', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -35px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .timeline-content h6 {
            margin-bottom: 5px;
        }
    </style>
@endsection

