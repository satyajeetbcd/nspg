@extends('staff.layouts.master')

@section('title', __('Reports Overview'))

@section('content')
    <div class="container-fluid position-relative mt-5">
        <!-- Page Header -->
        <div class="staff-page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="staff-page-title">
                        <i class="fas fa-graph-up me-2"></i>{{ __('Reports Overview') }}
                    </h1>
                    <p class="staff-page-subtitle">{{ __('Comprehensive analytics and insights for your business') }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'overview']) }}"
                    class="staff-btn staff-btn-outline-primary">
                    <i class="fas fa-download me-1"></i>{{ __('Export') }}
                </a>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="staff-card">
                    <div class="staff-card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="staff-avatar staff-avatar-lg bg-primary-subtle">
                                    <i class="fas fa-people text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Customers') }}</h6>
                                <h3 class="mb-0">{{ number_format($stats['customers']['total']) }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> {{ $stats['customers']['growth_rate'] }}%
                                    {{ __('vs last month') }}
                                </small>
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
                                    <i class="fas fa-currency-dollar text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Revenue') }}</h6>
                                <h3 class="mb-0">${{ number_format($stats['revenue']['total'], 2) }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> {{ $stats['revenue']['growth_rate'] }}%
                                    {{ __('vs last month') }}
                                </small>
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
                                <div class="staff-avatar staff-avatar-lg bg-info-subtle">
                                    <i class="fas fa-receipt text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Invoices') }}</h6>
                                <h3 class="mb-0">{{ number_format($stats['invoices']['total']) }}</h3>
                                <small class="text-success">
                                    {{ $stats['invoices']['paid_rate'] }}% {{ __('paid rate') }}
                                </small>
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
                                    <i class="fas fa-box text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Active Plans') }}</h6>
                                <h3 class="mb-0">{{ number_format($stats['plans']['total']) }}</h3>
                                <small class="text-muted">
                                    {{ $stats['plans']['active_subscriptions'] }} {{ __('active subscriptions') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- Revenue Chart -->
            <div class="col-xl-8">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-graph-up me-2"></i>{{ __('Monthly Revenue Trend') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Plan Distribution -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-pie-chart me-2"></i>{{ __('Plan Distribution') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="planDistributionChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row g-4">
            <!-- Recent Customers -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-people me-2"></i>{{ __('Recent Customers') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        @if ($recentActivities['customers']->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentActivities['customers'] as $customer)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm bg-primary-subtle me-3">
                                                <i class="fas fa-person text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $customer->name }}</h6>
                                                <small class="text-muted">{{ $customer->email }}</small>
                                            </div>
                                            <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="staff-empty-state">
                                <i class="fas fa-people text-muted"></i>
                                <p class="text-muted">{{ __('No recent customers') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-receipt me-2"></i>{{ __('Recent Invoices') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        @if ($recentActivities['invoices']->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentActivities['invoices'] as $invoice)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm bg-success-subtle me-3">
                                                <i class="fas fa-receipt text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $invoice->customer?->name }}</h6>
                                                <small
                                                    class="text-muted">${{ number_format($invoice->amount, 2) }}</small>
                                            </div>
                                            <span
                                                class="staff-badge staff-badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="staff-empty-state">
                                <i class="fas fa-receipt text-muted"></i>
                                <p class="text-muted">{{ __('No recent invoices') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-box me-2"></i>{{ __('Recent Subscriptions') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        @if ($recentActivities['subscriptions']->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentActivities['subscriptions'] as $subscription)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm bg-info-subtle me-3">
                                                <i class="fas fa-box text-info"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $subscription->customer->name }}</h6>
                                                <small class="text-muted">{{ $subscription->plan->name ?? 'N/A' }}</small>
                                            </div>
                                            <small
                                                class="text-muted">{{ $subscription->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="staff-empty-state">
                                <i class="fas fa-box text-muted"></i>
                                <p class="text-muted">{{ __('No recent subscriptions') }}</p>
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
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($monthlyRevenue)->pluck('month')) !!},
                    datasets: [{
                        label: '{{ __('Revenue') }}',
                        data: {!! json_encode(collect($monthlyRevenue)->pluck('revenue')) !!},
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

            // Plan Distribution Chart
            const planCtx = document.getElementById('planDistributionChart').getContext('2d');
            new Chart(planCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($planDistribution)->pluck('plan_name')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($planDistribution)->pluck('count')) !!},
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40'
                        ]
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
        });
    </script>
@endpush
