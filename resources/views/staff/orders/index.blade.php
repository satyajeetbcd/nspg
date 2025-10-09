@extends('staff.layouts.master')

@section('page-title')
    {{ __('Order Management') }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- KPI Summary --}}
    <div class="container mb-5 mt-5">
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-bag-check display-4 text-primary mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Total Orders') }}</h6>
                        <h3 class="fw-bold text-primary">{{ $orders->total() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-clock display-4 text-warning mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Pending') }}</h6>
                        <h3 class="fw-bold text-warning">{{ $orders->where('payment_status', 'pending')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-check-circle display-4 text-success mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Paid') }}</h6>
                        <h3 class="fw-bold text-success">{{ $orders->where('payment_status', 'paid')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-currency-dollar display-4 text-info mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Total Revenue') }}</h6>
                        <h3 class="fw-bold text-info">${{ number_format($orders->where('payment_status', 'paid')->sum('price'), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter and Actions --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2">
                    <a href="{{ route('staff.orders.pending', ['locale' => app()->getLocale()]) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-clock me-1"></i>{{ __('Pending Orders') }}
                        <span class="badge bg-light text-dark ms-1">{{ $orders->where('payment_status', 'pending')->count() }}</span>
                    </a>
                    <a href="{{ route('staff.orders.paid', ['locale' => app()->getLocale()]) }}" 
                       class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i>{{ __('Paid Orders') }}
                        <span class="badge bg-light text-dark ms-1">{{ $orders->where('payment_status', 'paid')->count() }}</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('staff.orders.export', ['locale' => app()->getLocale()]) }}" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-download me-1"></i>{{ __('Export CSV') }}
                </a>
            </div>
        </div>

        {{-- Orders Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-light rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold text-white">
                    <i class="fas fa-list-ul me-2"></i>{{ __('All Orders') }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">{{ __('Order ID') }}</th>
                                <th class="border-0">{{ __('Customer') }}</th>
                                <th class="border-0">{{ __('Plan') }}</th>
                                <th class="border-0 text-center">{{ __('Type') }}</th>
                                <th class="border-0 text-center">{{ __('Amount') }}</th>
                                <th class="border-0 text-center">{{ __('Status') }}</th>
                                <th class="border-0 text-center">{{ __('Date') }}</th>
                                <th class="border-0 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $loop->iteration }}</div>
                                            <small class="text-muted">#{{ $order->id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $order->customer->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $order->customer->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $order->plan->name ?? __('No Plan') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $order->order_type_display }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-semibold">
                                            ${{ number_format($order->price, 2) }}
                                        </div>
                                        <small class="text-muted">{{ $order->currency->currency_name ?? 'USD' }}</small>
                                    </td>
                                    <td class="text-center">
                                        @switch($order->payment_status)
                                            @case('pending')
                                                <span class="badge bg-warning">{{ __('Pending') }}</span>
                                                @break
                                            @case('paid')
                                                <span class="badge bg-success">{{ __('Paid') }}</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">{{ __('Cancelled') }}</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger">{{ __('Failed') }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="text-muted">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('staff.orders.show', ['locale' => app()->getLocale(), 'order' => $order]) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($order->payment_status === 'pending')
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#acceptModal{{ $order->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $order->id }}">
                                                    <i class="fas fa-x"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-bag-check display-4 mb-3"></i>
                                            <h5>{{ __('No orders found') }}</h5>
                                            <p>{{ __('Orders will appear here when customers place them.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages())
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Accept Order Modals --}}
    @foreach($orders as $order)
        @if($order->payment_status === 'pending')
            <!-- Accept Modal -->
            <div class="modal fade" id="acceptModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Accept Order') }} - {{ $order->order_id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('staff.orders.accept', ['locale' => $uiLocale, 'order' => $order]) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>{{ __('Accept this order and create subscription for the customer?') }}</p>
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
                                <button type="submit" class="btn btn-success">{{ __('Accept Order') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Reject Order') }} - {{ $order->order_id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('staff.orders.reject', ['locale' => app()->getLocale(), 'order' => $order]) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p class="text-danger">{{ __('Are you sure you want to reject this order?') }}</p>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Rejection Reason') }}</label>
                                    <textarea name="reason" class="form-control" rows="3" required placeholder="{{ __('Please provide a reason for rejection...') }}"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-danger">{{ __('Reject Order') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
