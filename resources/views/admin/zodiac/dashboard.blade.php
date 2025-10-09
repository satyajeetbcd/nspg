@extends('layouts.app')

@section('title')
    Zodiac System Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Zodiac System Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Zodiac System</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Customers</p>
                            <h4 class="mb-0">{{ $stats['total_customers'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                                                            <div class="mini-stat-icon avatar-sm rounded-circle badge-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="fa fa-users font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Transactions</p>
                            <h4 class="mb-0">{{ $stats['total_transactions'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                                                            <div class="mini-stat-icon avatar-sm rounded-circle badge-success align-self-center">
                                <span class="avatar-title">
                                    <i class="fa fa-credit-card font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Completed Payments</p>
                            <h4 class="mb-0">{{ $stats['completed_transactions'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                                                            <div class="mini-stat-icon avatar-sm rounded-circle badge-info align-self-center">
                                <span class="avatar-title">
                                    <i class="fa fa-check-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Revenue</p>
                            <h4 class="mb-0">₹{{ number_format($stats['total_revenue'], 2) }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                                                            <div class="mini-stat-icon avatar-sm rounded-circle badge-warning align-self-center">
                                <span class="avatar-title">
                                    <i class="fa fa-rupee font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Zodiac Sign Popularity -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Zodiac Sign Popularity</h4>
                </div>
                <div class="card-body">
                    @if($stats['zodiac_signs']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Zodiac Sign</th>
                                        <th>Transactions</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['zodiac_signs'] as $zodiac)
                                        <tr>
                                            <td>
                                                                                                    <span class="badge badge-primary">{{ ucfirst($zodiac->zodiac_sign) }}</span>
                                            </td>
                                            <td>{{ $zodiac->count }}</td>
                                            <td>{{ number_format(($zodiac->count / $stats['total_transactions']) * 100, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No transactions yet</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Transactions</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.zodiac.transactions') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recent_transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_transactions as $transaction)
                                        <tr>
                                            <td>
                                                <small class="text-muted">{{ $transaction->order_id }}</small>
                                            </td>
                                            <td>{{ $transaction->customer->name ?? 'N/A' }}</td>
                                            <td>₹{{ number_format($transaction->product_price, 2) }}</td>
                                            <td>
                                                @if($transaction->payment_status == 'completed')
                                                    <span class="badge badge-success">Completed</span>
                                                @elseif($transaction->payment_status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($transaction->payment_status == 'failed')
                                                    <span class="badge badge-danger">Failed</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($transaction->payment_status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No transactions yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.zodiac.transactions') }}" class="btn btn-primary w-100 mb-3">
                                <i class="fa fa-credit-card me-2"></i>View Transactions
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.zodiac.customers') }}" class="btn btn-success w-100 mb-3">
                                <i class="fa fa-users me-2"></i>Manage Customers
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/') }}" target="_blank" class="btn btn-info w-100 mb-3">
                                <i class="fa fa-external-link me-2"></i>View Landing Page
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary w-100 mb-3">
                                <i class="fa fa-arrow-left me-2"></i>Back to Main Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
