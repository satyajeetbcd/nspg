@extends('staff.layouts.master')

@section('page-title')
    {{ __('Order Details') }} - {{ $order->order_id }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Order Details --}}
    <div class="container mt-4">
        <div class="row">
            {{-- Order Information --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-bag-check me-2"></i>{{ __('Order Information') }}
                        </h5>
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }} fs-6">
                            {{ $order->payment_status_display }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Order ID') }}</label>
                                <div class="fw-bold">{{ $order->order_id }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Order Type') }}</label>
                                <div>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $order->order_type_display }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Amount') }}</label>
                                <div class="fw-bold text-success fs-5">
                                    ${{ number_format($order->price, 2) }}
                                    <small class="text-muted">{{ $order->currency->currency_name ?? 'USD' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Payment Type') }}</label>
                                <div>{{ $order->payment_type ?? __('Not specified') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div>{{ $order->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            @if($order->paid_at)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Paid Date') }}</label>
                                    <div>{{ $order->paid_at->format('M d, Y H:i') }}</div>
                                </div>
                            @endif
                            @if($order->txn_id)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Transaction ID') }}</label>
                                    <div class="font-monospace">{{ $order->txn_id }}</div>
                                </div>
                            @endif
                            @if($order->notes)
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">{{ __('Notes') }}</label>
                                    <div class="bg-light p-3 rounded">{{ $order->notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-person me-2"></i>{{ __('Customer Information') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Name') }}</label>
                                <div class="fw-bold">{{ $order->customer->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Email') }}</label>
                                <div>{{ $order->customer->email ?? 'N/A' }}</div>
                            </div>
                            @if($order->customer->phone)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Phone') }}</label>
                                    <div>{{ $order->customer->phone }}</div>
                                </div>
                            @endif
                            @if($order->customer->country)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Country') }}</label>
                                    <div>{{ $order->customer->country }}</div>
                                </div>
                            @endif
                            <div class="col-12">
                                <a href="{{ route('staff.customers.show', ['locale' => $uiLocale, 'customer' => $order->customer]) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Customer Details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Plan Information --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-package me-2"></i>{{ __('Plan Information') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Plan Name') }}</label>
                                <div class="fw-bold">{{ $order->plan->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Duration') }}</label>
                                <div>{{ $order->plan->duration ?? 'N/A' }}</div>
                            </div>
                            @if($order->previousPlan)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">{{ __('Previous Plan') }}</label>
                                    <div>{{ $order->previousPlan->name }}</div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Plan Price') }}</label>
                                <div class="fw-bold">${{ number_format($order->plan->price ?? 0, 2) }}</div>
                            </div>
                            @if($order->plan->description)
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">{{ __('Description') }}</label>
                                    <div>{{ $order->plan->description }}</div>
                                </div>
                            @endif
                            <div class="col-12">
                                <a href="{{ route('staff.plans.show', ['locale' => $uiLocale, 'plan' => $order->plan]) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Plan Details') }}
                                </a>
                            </div>
                        </div>
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
                        @if($order->payment_status === 'pending')
                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-success" 
                                        data-bs-toggle="modal" data-bs-target="#acceptModal">
                                    <i class="fas fa-check me-1"></i>{{ __('Accept Order') }}
                                </button>
                                <button type="button" class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#markPaidModal">
                                    <i class="fas fa-credit-card me-1"></i>{{ __('Mark as Paid') }}
                                </button>
                                <button type="button" class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-x me-1"></i>{{ __('Reject Order') }}
                                </button>
                            </div>
                        @elseif($order->payment_status === 'paid')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ __('This order has been paid and processed.') }}
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ __('This order has been cancelled or failed.') }}
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('staff.orders.index', ['locale' => $uiLocale]) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Orders') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Related Information --}}
                @if($order->subscription)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-light rounded-top-4 py-3">
                            <h5 class="mb-0 fw-bold text-white">
                                <i class="fas fa-arrow-repeat me-2"></i>{{ __('Created Subscription') }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('staff.subscriptions.show', ['locale' => $uiLocale, 'subscription' => $order->subscription]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Subscription') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($order->invoice)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-light rounded-top-4 py-3">
                            <h5 class="mb-0 fw-bold text-white">
                                <i class="fas fa-receipt me-2"></i>{{ __('Generated Invoice') }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('staff.invoices.show', ['locale' => $uiLocale, 'invoice' => $order->invoice]) }}" 
                                   class="btn btn-outline-info">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Invoice') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Accept Order Modal --}}
    <div class="modal fade" id="acceptModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Accept Order') }} - {{ $order->order_id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('staff.orders.accept', ['locale' => $uiLocale, 'order' => $order]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('Accepting this order will create a subscription for the customer and generate an invoice.') }}
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Type') }}</label>
                            <select name="payment_type" class="form-select" required>
                                <option value="cash">{{ __('Cash') }}</option>
                                <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                                <option value="check">{{ __('Check') }}</option>
                                <option value="other">{{ __('Other') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('Optional notes about this acceptance...') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>{{ __('Accept & Create Subscription') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Mark as Paid Modal --}}
    <div class="modal fade" id="markPaidModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Mark Order as Paid') }} - {{ $order->order_id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('staff.orders.mark-paid', ['locale' => $uiLocale, 'order' => $order]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Transaction ID') }}</label>
                            <input type="text" name="transaction_id" class="form-control" placeholder="{{ __('Enter transaction ID if available...') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Type') }}</label>
                            <select name="payment_type" class="form-select" required>
                                <option value="card">{{ __('Credit/Debit Card') }}</option>
                                <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                                <option value="paypal">{{ __('PayPal') }}</option>
                                <option value="other">{{ __('Other') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-credit-card me-1"></i>{{ __('Mark as Paid') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Order Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Reject Order') }} - {{ $order->order_id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('staff.orders.reject', ['locale' => $uiLocale, 'order' => $order]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ __('This action cannot be undone. The customer will be notified.') }}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Rejection Reason') }}</label>
                            <textarea name="reason" class="form-control" rows="3" required placeholder="{{ __('Please provide a reason for rejection...') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-x me-1"></i>{{ __('Reject Order') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
