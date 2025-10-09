@extends('staff.layouts.master')

@section('page-title')
    {{ __('Pending Orders') }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Header Actions --}}
    <div class="container mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Orders Awaiting Approval') }}</h4>
                <p class="text-muted mb-0">{{ __('Review and accept pending orders to create customer subscriptions') }}</p>
            </div>
            <div>
                <a href="{{ route('staff.orders.index', ['locale' => app()->getLocale()]) }}" 
                   class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>{{ __('Back to All Orders') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Pending Orders Table --}}
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-warning-subtle rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold text-warning">
                    <i class="fas fa-clock me-2"></i>{{ __('Pending Orders') }} ({{ $orders->total() }})
                </h5>
            </div>
            <div class="card-body p-0">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">{{ __('Order Details') }}</th>
                                    <th class="border-0">{{ __('Customer') }}</th>
                                    <th class="border-0">{{ __('Plan') }}</th>
                                    <th class="border-0 text-center">{{ __('Amount') }}</th>
                                    <th class="border-0 text-center">{{ __('Requested') }}</th>
                                    <th class="border-0 text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $order->order_id }}</div>
                                                <small class="text-muted">{{ $order->order_type_display }}</small>
                                                @if($order->previousPlan)
                                                    <br><small class="text-info">{{ __('From') }}: {{ $order->previousPlan->name }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $order->customer->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $order->customer->email ?? 'N/A' }}</small>
                                                @if($order->customer->phone)
                                                    <br><small class="text-muted">{{ $order->customer->phone }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge bg-info-subtle text-info fs-6">
                                                    {{ $order->plan->name ?? __('No Plan') }}
                                                </span>
                                                @if($order->plan)
                                                    <br><small class="text-muted">${{ number_format($order->plan->price, 2) }}/{{ $order->plan->duration }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-bold text-success">
                                                ${{ number_format($order->price, 2) }}
                                            </div>
                                            <small class="text-muted">{{ $order->currency->currency_name ?? 'USD' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-muted">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </div>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            <br><small class="text-info">{{ $order->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('staff.orders.show', ['locale' => app()->getLocale(), 'order' => $order]) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>{{ __('Review') }}
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#acceptModal{{ $order->id }}">
                                                    <i class="fas fa-check me-1"></i>{{ __('Accept') }}
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $order->id }}">
                                                    <i class="fas fa-x"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                @else
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-check-circle display-4 text-success mb-3"></i>
                            <h5>{{ __('No Pending Orders') }}</h5>
                            <p>{{ __('All orders have been processed. Great job!') }}</p>
                            <a href="{{ route('staff.orders.index', ['locale' => app()->getLocale()]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i>{{ __('View All Orders') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Accept Order Modals --}}
    @foreach($orders as $order)
        <!-- Accept Modal -->
        <div class="modal fade" id="acceptModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Accept Order') }} - {{ $order->order_id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('staff.orders.accept', ['locale' => app()->getLocale(), 'order' => $order]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('Accepting this order will create a subscription for the customer and generate an invoice.') }}
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>{{ __('Customer') }}:</strong><br>
                                    {{ $order->customer->name ?? 'N/A' }}<br>
                                    <small class="text-muted">{{ $order->customer->email ?? 'N/A' }}</small>
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('Plan') }}:</strong><br>
                                    {{ $order->plan->name ?? 'N/A' }}<br>
                                    <small class="text-muted">${{ number_format($order->price, 2) }}</small>
                                </div>
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
    @endforeach
@endsection
