@extends('layouts.customer')

@section('title', __('Order Details'))

@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('My Orders'), 'url' => route('customer.orders.index', app()->getLocale())],
            ['label' => __('Order') . ' #' . ($order->order_id ?? $order->id)],
        ]
    ])
@endsection

@section('content')

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Order Details') }} - #{{ $order->order_id }}</h4>
                <p class="text-muted mb-0">{{ __('View and manage your order information') }}</p>
            </div>
            <div>
                <span class="badge bg-{{ $order->isPaid() ? 'success' : ($order->isPending() ? 'warning' : 'danger') }} fs-6">
                    <i class="fas fa-{{ $order->isPaid() ? 'check-circle' : ($order->isPending() ? 'clock' : 'times-circle') }} me-1"></i>
                    {{ $order->payment_status_display }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>{{ __('Order Information') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted"><strong>{{ __('Order ID') }}:</strong></td>
                                <td><code>{{ $order->order_id }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted"><strong>{{ __('Order Type') }}:</strong></td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $order->order_type_display }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted"><strong>{{ __('Order Date') }}:</strong></td>
                                <td>@userTime($order->created_at, 'M d, Y H:i')</td>
                            </tr>
                            @if($order->txn_id)
                            <tr>
                                <td class="text-muted"><strong>{{ __('Transaction ID') }}:</strong></td>
                                <td><code>{{ $order->txn_id }}</code></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted"><strong>{{ __('Payment Status') }}:</strong></td>
                                <td>
                                    <span class="badge bg-{{ $order->isPaid() ? 'success' : ($order->isPending() ? 'warning' : 'danger') }}">
                                        {{ $order->payment_status_display }}
                                    </span>
                                </td>
                            </tr>
                            @if($order->paid_at)
                            <tr>
                                <td class="text-muted"><strong>{{ __('Paid At') }}:</strong></td>
                                <td>@userTime($order->paid_at, 'M d, Y H:i')</td>
                            </tr>
                            @endif
                            @if($order->payment_type)
                            <tr>
                                <td class="text-muted"><strong>{{ __('Payment Method') }}:</strong></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>{{ __('Order Items') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="me-3">
                                <i class="fas fa-gem fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $order->plan->name ?? $order->plan_name ?? 'Unknown Plan' }}</h6>
                                <p class="text-muted mb-1">{{ $order->plan->description ?? 'Premium subscription plan' }}</p>
                                @if($order->plan)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ ucfirst($order->plan->duration) }} {{ __('subscription') }}
                                    </small>
                                @endif
                            </div>
                            <div class="text-end">
                                <h5 class="mb-0 text-primary">
                @if($order->currency)
                    {{ $order->currency->getSymbol('en') }}{{ number_format($order->price, 2) }}
                @else
                    ${{ number_format($order->price, 2) }}
                @endif
                                </h5>
                                @if($order->plan && $order->plan->duration !== 'lifetime')
                                    <small class="text-muted">/{{ ucfirst($order->plan->duration) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($order->previousPlan)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>{{ __('Previous Plan') }}:</strong> {{ $order->previousPlan->name }}
                        </div>
                    </div>
                </div>
                @endif

                @if($order->plan && $order->plan->features && $order->plan->features->count() > 0)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-muted mb-2">{{ __('Plan Features') }}</h6>
                        <div class="row">
                            @php
                                $planFeature = $order->plan->features->first();
                                $activeFeatures = $planFeature ? $planFeature->activeFeatures() : [];
                            @endphp
                            @if($planFeature && $planFeature->max_user > 0)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-users text-success me-2"></i>
                                        <span>{{ __('Up to') }} {{ $planFeature->max_user }} {{ __('users') }}</span>
                                    </div>
                                </div>
                            @endif
                            @foreach($activeFeatures as $feature)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <span>{{ $feature }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($order->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note me-2"></i>{{ __('Notes') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    {{ $order->notes }}
                </div>
            </div>
        </div>
        @endif

        @if($order->invoice)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-invoice me-2"></i>{{ __('Invoice') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <i class="fas fa-file-invoice me-2"></i>
                    {{ __('Invoice generated') }}:
                    <a href="{{ route('customer.invoices.show', ['invoice' => $order->invoice]) }}"
                       class="alert-link fw-bold">{{ __('View Invoice') }} #{{ $order->invoice->code }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Payment Section -->
    <div class="col-lg-4">
        @if($order->isPending())
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card me-2"></i>{{ __('Complete Payment') }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.orders.payment', ['order' => $order]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">{{ __('Payment Method') }}</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="">{{ __('Select Payment Method') }}</option>
                            <option value="credit_card">{{ __('Credit Card') }}</option>
                            <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                            <option value="paypal">{{ __('PayPal') }}</option>
                            <option value="stripe">{{ __('Stripe') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transaction_id" class="form-label">{{ __('Transaction ID (Optional)') }}</label>
                        <input type="text" name="transaction_id" id="transaction_id" class="form-control"
                               placeholder="{{ __('Enter transaction ID if available') }}">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-credit-card me-2"></i>{{ __('Process Payment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Order Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>{{ __('Actions') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Orders') }}
                    </a>

                    @if($order->isPending())
                    <form action="{{ route('customer.orders.cancel', ['order' => $order]) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('{{ __('Are you sure you want to cancel this order?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-times me-2"></i>{{ __('Cancel Order') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
