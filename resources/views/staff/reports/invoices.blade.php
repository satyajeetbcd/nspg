@extends('staff.layouts.master')

@section('title', __('Invoice Reports'))

@section('content')
<div class="container-fluid position-relative mt-5">
    <!-- Page Header -->
    <div class="staff-page-header">
        <div class="d-flex justify-content-between align-items-center" >
            <div>
                <h1 class="staff-page-title">
                    <i class="fas fa-receipt me-2"></i>{{ __('Invoice Reports') }}
                </h1>
                <p class="staff-page-subtitle">{{ __('Invoice analytics and payment tracking') }}</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'invoices']) }}" 
               class="staff-btn staff-btn-outline-primary">
                <i class="fas fa-download me-1"></i>{{ __('Export') }}
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="staff-card mb-4">
        <div class="staff-card-body">
            <form method="GET" action="{{ route('staff.reports.invoices', ['locale' => $uiLocale]) }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Date From') }}</label>
                    <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Date To') }}</label>
                    <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="paid" {{ ($filters['status'] ?? '') === 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="overdue" {{ ($filters['status'] ?? '') === 'overdue' ? 'selected' : '' }}>{{ __('Overdue') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Customer') }}</label>
                    <select class="form-select" name="customer_id">
                        <option value="">{{ __('All Customers') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ ($filters['customer_id'] ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="staff-btn staff-btn-primary">
                        <i class="fas fa-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('staff.reports.invoices', ['locale' => $uiLocale]) }}" class="staff-btn staff-btn-outline-secondary">
                        <i class="fas fa-x-circle me-1"></i>{{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoice Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="staff-card">
                <div class="staff-card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="staff-avatar staff-avatar-lg bg-primary-subtle">
                                <i class="fas fa-receipt text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Total Invoices') }}</h6>
                            <h3 class="mb-0">{{ number_format($invoiceStats['total']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="staff-card">
                <div class="staff-card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="staff-avatar staff-avatar-lg bg-success-subtle">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Paid Invoices') }}</h6>
                            <h3 class="mb-0">{{ number_format($invoiceStats['paid']) }}</h3>
                            <small class="text-success">{{ $invoiceStats['paid_rate'] }}% {{ __('paid rate') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="staff-card">
                <div class="staff-card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="staff-avatar staff-avatar-lg bg-warning-subtle">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Pending Invoices') }}</h6>
                            <h3 class="mb-0">{{ number_format($invoiceStats['pending']) }}</h3>
                            <small class="text-muted">{{ __('Awaiting payment') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="staff-card">
                <div class="staff-card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="staff-avatar staff-avatar-lg bg-danger-subtle">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Overdue Invoices') }}</h6>
                            <h3 class="mb-0">{{ number_format($invoiceStats['overdue']) }}</h3>
                            <small class="text-danger">{{ __('Requires attention') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-currency-dollar me-2"></i>{{ __('Revenue Summary') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-success-subtle rounded">
                                <h4 class="text-success mb-1">${{ number_format($invoiceStats['paid_amount'], 2) }}</h4>
                                <small class="text-muted">{{ __('Paid Amount') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-info-subtle rounded">
                                <h4 class="text-info mb-1">${{ number_format($invoiceStats['total_amount'], 2) }}</h4>
                                <small class="text-muted">{{ __('Total Amount') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-pie-chart me-2"></i>{{ __('Invoice Status Distribution') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="invoiceStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Invoice by Month -->
        <div class="col-xl-8">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-graph-up me-2"></i>{{ __('Invoice Trends') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="invoiceByMonthChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Trends -->
        <div class="col-xl-4">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-credit-card me-2"></i>{{ __('Payment Trends') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="paymentTrendsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Invoices -->
    <div class="row g-4">
        <div class="col-12">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Overdue Invoices') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    @if($overdueInvoices->count() > 0)
                        <div class="table-responsive">
                            <table class="staff-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Invoice ID') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Plan') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Days Overdue') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($overdueInvoices as $invoice)
                                        <tr>
                                            <td>#{{ $invoice->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="staff-avatar staff-avatar-sm bg-primary-subtle me-2">
                                                        <i class="fas fa-person text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $invoice->customer->name }}</h6>
                                                        <small class="text-muted">{{ $invoice->customer->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $invoice->plan->name ?? 'N/A' }}</td>
                                            <td>${{ number_format($invoice->amount, 2) }}</td>
                                            <td>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                @if($invoice->due_date)
                                                    <span class="staff-badge staff-badge-danger">
                                                        {{ $invoice->due_date->diffInDays(now()) }} {{ __('days') }}
                                                    </span>
                                                @else
                                                    <span class="staff-badge staff-badge-secondary">{{ __('N/A') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="staff-dropdown">
                                                    <button class="staff-btn staff-btn-sm staff-btn-outline-secondary dropdown-toggle" 
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-three-dots"></i>
                                                    </button>
                                                    <ul class="staff-dropdown-menu">
                                                        <li>
                                                            <a href="{{ route('staff.invoices.show', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                                                               class="staff-dropdown-item">
                                                                <i class="fas fa-eye text-info"></i>
                                                                {{ __('View') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('staff.invoices.edit', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                                                               class="staff-dropdown-item">
                                                                <i class="fas fa-pencil text-warning"></i>
                                                                {{ __('Edit') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $overdueInvoices->links() }}
                        </div>
                    @else
                        <div class="staff-empty-state">
                            <i class="fas fa-check-circle text-success"></i>
                            <p class="text-muted">{{ __('No overdue invoices found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Invoice Status Chart
    const statusCtx = document.getElementById('invoiceStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __("Paid") }}', '{{ __("Pending") }}', '{{ __("Overdue") }}'],
            datasets: [{
                data: [{{ $invoiceStats['paid'] }}, {{ $invoiceStats['pending'] }}, {{ $invoiceStats['overdue'] }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Invoice by Month Chart
    const monthCtx = document.getElementById('invoiceByMonthChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($invoiceByMonth)->pluck('month')) !!},
            datasets: [{
                label: '{{ __("Invoice Count") }}',
                data: {!! json_encode(collect($invoiceByMonth)->pluck('count')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Payment Trends Chart
    const paymentCtx = document.getElementById('paymentTrendsChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($paymentTrends)->pluck('month')) !!},
            datasets: [{
                label: '{{ __("Paid Amount") }}',
                data: {!! json_encode(collect($paymentTrends)->pluck('paid_amount')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
