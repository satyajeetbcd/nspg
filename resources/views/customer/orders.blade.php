{{-- Customer Orders Index --}}
@extends('layouts.customer')

@section('title', __('My Orders'))

@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('My Orders')],
        ]
    ])
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('My Orders') }}</h4>
                <p class="text-muted mb-0">{{ __('View and manage your subscription orders') }}</p>
            </div>
            <div>
                <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('New Order') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<div id="alert-container">
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

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Pending Orders -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-clock me-2 text-warning"></i>{{ __('Pending Orders') }}
        </h5>
    </div>
    <div class="card-body">
        @if(isset($pendingOrders) && $pendingOrders->count() > 0)
            <div class="row">
                @foreach($pendingOrders as $order)
                    <div class="col-md-6 mb-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $order->plan->name ?? 'Unknown Plan' }}</h6>
                                    <span class="badge bg-warning">{{ $order->payment_status_display }}</span>
                                </div>
                                <p class="text-muted mb-2">
                                    <strong>{{ __('Order #') }}:</strong> {{ $order->order_id }}
                                </p>
                                <p class="text-muted mb-2">
                                    <strong>{{ __('Amount') }}:</strong>
                                        @if($order->currency)
                                            {{ $order->currency->getSymbol('en') }}{{ number_format($order->price, 2) }}
                                        @else
                                            ${{ number_format($order->price, 2) }}
                                        @endif
                                </p>
                                <p class="text-muted mb-3">
                                    <strong>{{ __('Created') }}:</strong> @userTime($order->created_at, 'M d, Y H:i')
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>{{ __('View Details') }}
                                    </a>
                                    <form action="{{ route('customer.orders.payment', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-credit-card me-1"></i>{{ __('Pay Now') }}
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger cancel-order-btn"
                                            data-order-id="{{ $order->id }}"
                                            data-order-number="{{ $order->order_id }}"
                                            data-cancel-url="{{ route('customer.orders.cancel', $order->id) }}">
                                        <i class="fas fa-times me-1"></i>{{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-muted mb-2">{{ __('No Pending Orders') }}</h5>
                <p class="text-muted mb-3">{{ __('You have no pending orders at the moment. All your orders are up to date!') }}</p>
                <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Create New Order') }}
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Order History -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>{{ __('Order History') }}
        </h5>
    </div>
    <div class="card-body">
        @if(isset($orders) && $orders->count() > 0)
            @php
                $hasNonPendingOrders = false;
                foreach($orders as $order) {
                    $isPendingOrder = isset($pendingOrders) && $pendingOrders->contains('id', $order->id);
                    if (!$isPendingOrder) {
                        $hasNonPendingOrders = true;
                        break;
                    }
                }
            @endphp

            @if($hasNonPendingOrders)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Plan') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $isPendingOrder = isset($pendingOrders) && $pendingOrders->contains('id', $order->id);
                                @endphp
                                @if(!$isPendingOrder)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_id }}</strong>
                                        </td>
                                        <td>{{ $order->plan->name ?? 'Unknown Plan' }}</td>
                                        <td>
                                        @if($order->currency)
                                            {{ $order->currency->getSymbol('en') }}{{ number_format($order->price, 2) }}
                                        @else
                                            ${{ number_format($order->price, 2) }}
                                        @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->isPaid() ? 'success' : ($order->isPending() ? 'warning' : 'danger') }}">
                                                {{ $order->payment_status_display }}
                                            </span>
                                        </td>
                                        <td>@userTime($order->created_at, 'M d, Y')</td>
                                        <td>
                                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($order->isPending())
                                                <button type="button" class="btn btn-sm btn-outline-danger cancel-order-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-order-number="{{ $order->order_id }}"
                                                        data-cancel-url="{{ route('customer.orders.cancel', $order->id) }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted mb-2">{{ __('No Order History') }}</h5>
                    <p class="text-muted mb-3">{{ __('You haven\'t completed any orders yet. Start by creating your first order!') }}</p>
                    <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('Create New Order') }}
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">{{ __('No Orders Found') }}</h5>
                <p class="text-muted mb-3">{{ __('You haven\'t placed any orders yet. Browse our plans and get started!') }}</p>
                <a href="{{ route('customer.plan-requests.index') }}" class="btn btn-primary">
                    <i class="fas fa-rocket me-2"></i>{{ __('Browse Plans') }}
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle order cancellation with AJAX
    document.querySelectorAll('.cancel-order-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const orderNumber = this.getAttribute('data-order-number');

            // Show confirmation dialog
            if (confirm('{{ __("Are you sure you want to cancel order") }} #' + orderNumber + '?')) {
                // Disable button and show loading state
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                // Make AJAX request
                const url = this.getAttribute('data-cancel-url');
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showAlert('success', data.message || '{{ __("Order cancelled successfully") }}');

                        // Remove the order row from the table
                        const orderRow = this.closest('tr') || this.closest('.col-md-6');
                        if (orderRow) {
                            orderRow.style.transition = 'opacity 0.3s';
                            orderRow.style.opacity = '0';
                            setTimeout(() => {
                                orderRow.remove();

                                // Check if there are no more orders and show empty state
                                const remainingOrders = document.querySelectorAll('tbody tr, .col-md-6');
                                if (remainingOrders.length === 0) {
                                    location.reload(); // Reload to show empty state
                                }
                            }, 300);
                        }
                    } else {
                        // Show error message
                        showAlert('danger', data.message || '{{ __("Failed to cancel order") }}');

                        // Re-enable button
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-times"></i>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', '{{ __("An error occurred while cancelling the order") }}');

                    // Re-enable button
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-times"></i>';
                });
            }
        });
    });

    // Function to show alerts
    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert alert into the dedicated alert container
        const alertContainer = document.getElementById('alert-container');
        if (alertContainer) {
            alertContainer.appendChild(alertDiv);
        }

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endpush
