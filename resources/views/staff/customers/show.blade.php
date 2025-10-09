@extends('staff.layouts.master')

@section('page-title')
    {{ __('Customer Details') }} - {{ $customer->name }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Customer Details --}}
    <div class="container mt-4">
        <div class="row">
            {{-- Customer Information --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-person me-2"></i>{{ __('Customer Information') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.customers.edit', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Name') }}</label>
                                <div class="fw-semibold">{{ $customer->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Email') }}</label>
                                <div class="fw-semibold">{{ $customer->email ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Phone') }}</label>
                                <div class="fw-semibold">{{ $customer->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Status') }}</label>
                                <div>
                                    <span class="badge {{ $customer->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                                        {{ $customer->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Email Verified') }}</label>
                                <div>
                                    <span class="badge {{ $customer->email_verified_at ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} fs-6">
                                        {{ $customer->email_verified_at ? __('Verified') : __('Not Verified') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div>{{ $customer->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Last Updated') }}</label>
                                <div>{{ $customer->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Last Login') }}</label>
                                <div>{{ $customer->last_login_at ? $customer->last_login_at->format('M d, Y H:i') : 'Never' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Plan Information --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-package me-2"></i>{{ __('Plan Information') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.customers.assign-plan', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus-circle me-1"></i>{{ __('Assign Plan') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $customerPlan = $customer->plan()->first();
                        @endphp
                        @if($customerPlan)
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Current Plan') }}</label>
                                    <div>
                                        <span class="badge bg-info-subtle text-info fs-6">
                                            {{ $customerPlan->name ?? 'Plan #' . $customerPlan->id }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Plan Status') }}</label>
                                    <div>
                                        <span class="badge {{ $customerPlan->is_visible ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} fs-6">
                                            {{ $customerPlan->is_visible ? __('Visible') : __('Hidden') }}
                                        </span>
                                    </div>
                                </div>
                                @if($customerPlan->description)
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-muted">{{ __('Description') }}</label>
                                        <div class="text-muted">{{ $customerPlan->description }}</div>
                                    </div>
                                @endif
                                @if($customerPlan->duration)
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">{{ __('Duration') }}</label>
                                        <div class="text-capitalize">{{ $customerPlan->duration }}</div>
                                    </div>
                                @endif
                                @if($customerPlan->max_users)
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">{{ __('Max Users') }}</label>
                                        <div>{{ $customerPlan->max_users }}</div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-package display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('No Plan Assigned') }}</h5>
                                <p class="text-muted">{{ __('This customer does not have a plan assigned.') }}</p>
                                <a href="{{ route('staff.customers.assign-plan', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-1"></i>{{ __('Assign Plan Now') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions Panel --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-gear me-2"></i>{{ __('Actions') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('staff.customers.edit', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit Customer') }}
                            </a>
                            
                            @if($customer->is_active)
                                <form action="{{ route('staff.customers.deactivate', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-pause-circle me-1"></i>{{ __('Deactivate Customer') }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('staff.customers.activate', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-play-circle me-1"></i>{{ __('Activate Customer') }}
                                    </button>
                                </form>
                            @endif

                            @if(!$customer->email_verified_at)
                                <form action="{{ route('staff.customers.verify-email', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-info w-100">
                                        <i class="fas fa-envelope-check me-1"></i>{{ __('Verify Email') }}
                                    </button>
                                </form>
                            @endif

                            <hr>

                            {{-- Plan Management Actions --}}
                            <h6 class="fw-bold text-muted mb-3">{{ __('Plan Management') }}</h6>
                            
                            <a href="{{ route('staff.customers.assign-plan', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                               class="btn btn-outline-primary w-100">
                                <i class="fas fa-package me-1"></i>{{ __('Assign/Change Plan') }}
                            </a>
                            
                            @if($customerPlan)
                                <form action="{{ route('staff.customers.remove-plan', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                      method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-warning w-100" 
                                            onclick="return confirm('{{ __('Are you sure you want to remove the plan from this customer?') }}')">
                                        <i class="fas fa-package-x me-1"></i>{{ __('Remove Plan') }}
                                    </button>
                                </form>
                            @endif

                            <hr>

                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>{{ __('Delete Customer') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Customer Statistics --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-graph-up me-2"></i>{{ __('Statistics') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <i class="fas fa-file-invoice display-6 text-primary mb-2"></i>
                                    <h6 class="fw-semibold">{{ __('Invoices') }}</h6>
                                    <h4 class="fw-bold text-primary">{{ $customer->invoices()->count() }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <i class="fas fa-credit-card display-6 text-success mb-2"></i>
                                    <h6 class="fw-semibold">{{ __('Subscriptions') }}</h6>
                                    <h4 class="fw-bold text-success">{{ $customer->subscriptions()->count() }}</h4>
                                </div>
                            </div>
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
                    <h5 class="modal-title">{{ __('Delete Customer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this customer? This action cannot be undone.') }}</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ __('This will also delete all associated invoices and subscriptions.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('staff.customers.destroy', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

