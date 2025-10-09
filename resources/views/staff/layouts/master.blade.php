{{-- Modern Admin Dashboard --}}
@extends('staff.layouts.master')

@section('page-title', __('Admin Dashboard'))

@section('content')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
    font-weight: 600;
}
</style>
    {{-- Welcome Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="staff-page-title mb-1">Welcome back, {{ auth()->guard('staff')->user()->name ?? 'Admin' }}!</h1>
                            <p class="staff-page-subtitle mb-0">Here's what's happening with your business today.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickActionsModal">
                                <i class="fas fa-plus me-2"></i>Quick Actions
                            </button>
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="staff-stats-card staff-fade-in">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-users text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="staff-stats-number text-primary">{{ number_format($stats['customers']['total']) }}</div>
                        <div class="staff-stats-label">Total Customers</div>
                        <small class="{{ $stats['customers']['growth_rate'] >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas fa-arrow-{{ $stats['customers']['growth_rate'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($stats['customers']['growth_rate']) }}% from last month
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="staff-stats-card staff-fade-in">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-dollar-sign text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="staff-stats-number text-success">${{ number_format($stats['revenue']['total'], 2) }}</div>
                        <div class="staff-stats-label">Total Revenue</div>
                        <small class="{{ $stats['revenue']['growth_rate'] >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas fa-arrow-{{ $stats['revenue']['growth_rate'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($stats['revenue']['growth_rate']) }}% from last month
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="staff-stats-card staff-fade-in">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-file-invoice text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="staff-stats-number text-warning">{{ number_format($stats['invoices']['total']) }}</div>
                        <div class="staff-stats-label">Total Invoices</div>
                        <small class="text-info">
                            <i class="fas fa-percentage me-1"></i>
                            {{ $stats['invoices']['paid_rate'] }}% paid rate
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="staff-stats-card staff-fade-in">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-box text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="staff-stats-number text-info">{{ number_format($stats['plans']['total']) }}</div>
                        <div class="staff-stats-label">Total Plans</div>
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $stats['plans']['active_subscriptions'] }} active subscriptions
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Revenue Overview
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Customer Distribution
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="customerChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity & Quick Stats --}}
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Activity
                    </h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="staff-card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                        <div class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                            <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $activity->description }}</div>
                                    <small class="text-muted">
                                        @if(isset($activity->user))
                                            {{ $activity->user->name ?? $activity->user->email }}
                                            @if(isset($activity->user->plan) && $activity->user->plan)
                                                - {{ $activity->user->plan->name ?? 'Plan' }}
                                            @endif
                                        @endif
                                    </small>
                            </div>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="list-group-item d-flex justify-content-center align-items-center border-0 px-0">
                                <div class="text-muted">
                                    <i class="fas fa-inbox me-2"></i>No recent activity
                        </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Quick Stats
                    </h5>
                </div>
                <div class="staff-card-body">
                    @php
                        $systemHealth = app(\App\Http\Controllers\Staff\DashboardController::class)->getSystemHealth();
                    @endphp
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Database Status</span>
                        <span class="staff-badge staff-badge-{{ $systemHealth['database']['status'] === 'healthy' ? 'success' : 'danger' }}">
                            {{ $systemHealth['database']['status'] === 'healthy' ? 'Online' : 'Offline' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Storage Usage</span>
                        <span class="staff-badge staff-badge-{{ $systemHealth['storage']['status'] === 'healthy' ? 'success' : ($systemHealth['storage']['status'] === 'warning' ? 'warning' : 'danger') }}">
                            {{ $systemHealth['storage']['message'] }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Email Service</span>
                        <span class="staff-badge staff-badge-{{ $systemHealth['email']['status'] === 'healthy' ? 'success' : ($systemHealth['email']['status'] === 'warning' ? 'warning' : 'danger') }}">
                            {{ $systemHealth['email']['status'] === 'healthy' ? 'Configured' : 'Not Configured' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Cache Status</span>
                        <span class="staff-badge staff-badge-{{ $systemHealth['cache']['status'] === 'healthy' ? 'success' : 'danger' }}">
                            {{ $systemHealth['cache']['status'] === 'healthy' ? 'Working' : 'Not Working' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total Customers</span>
                        <span class="text-primary fw-bold">{{ number_format($stats['customers']['total']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Data Tables --}}
    <div class="row mb-4">
        <div class="col-xl-6 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Recent Customers
                    </h5>
                    <a href="{{ route('staff.customers.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="staff-card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCustomers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($customer->name ?? $customer->email, 0, 1)) }}
                                                </div>
                                                {{ $customer->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            @if($customer->is_active === 1)
                                                <span class="badge bg-success">Active</span>
                                            @elseif($customer->is_active === 0)
                                                <span class="badge bg-danger">Inactive</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $customer->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fas fa-inbox me-2"></i>No customers found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4">
            <div class="staff-card staff-fade-in">
                <div class="staff-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>Recent Invoices
                    </h5>
                    <a href="{{ route('staff.invoices.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="staff-card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="{{ route('staff.invoices.show', $invoice->id) }}" class="text-decoration-none">
                                                #{{ $invoice->id }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->customer->name ?? $invoice->customer->email ?? 'N/A' }}</td>
                                        <td class="fw-bold">${{ number_format($invoice->amount, 2) }}</td>
                                        <td>
                                            @switch($invoice->status)
                                                @case('paid')
                                                    <span class="badge bg-success">Paid</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                    @break
                                                @case('overdue')
                                                    <span class="badge bg-danger">Overdue</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($invoice->status) }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fas fa-inbox me-2"></i>No invoices found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions Modal --}}
    <div class="modal fade" id="quickActionsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('staff.customers.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-user-plus fs-2 mb-2"></i>
                                <span>Add Customer</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('staff.invoices.create') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-file-invoice fs-2 mb-2"></i>
                                <span>Create Invoice</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('staff.plans.create') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-box fs-2 mb-2"></i>
                                <span>Add Plan</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('staff.reports.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-chart-bar fs-2 mb-2"></i>
                                <span>View Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
