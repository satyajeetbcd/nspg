@extends('staff.layouts.master')

@section('title', __('Plan Reports'))

@section('content')
    <div class="container-fluid position-relative mt-5">
        <!-- Page Header -->
        <div class="staff-page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="staff-page-title">
                        <i class="fas fa-box me-2"></i>{{ __('Plan Reports') }}
                    </h1>
                    <p class="staff-page-subtitle">{{ __('Plan performance and subscription analytics') }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'plans']) }}"
                    class="staff-btn staff-btn-outline-primary">
                    <i class="fas fa-download me-1"></i>{{ __('Export') }}
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="staff-card mb-4">
            <div class="staff-card-body">
                <form method="GET" action="{{ route('staff.reports.plans', ['locale' => $uiLocale]) }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Date From') }}</label>
                        <input type="date" class="form-control" name="date_from"
                            value="{{ $filters['date_from'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Date To') }}</label>
                        <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Plan') }}</label>
                        <select class="form-select" name="plan_id">
                            <option value="">{{ __('All Plans') }}</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    {{ ($filters['plan_id'] ?? '') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="staff-btn staff-btn-primary">
                            <i class="fas fa-funnel me-1"></i>{{ __('Apply Filters') }}
                        </button>
                        <a href="{{ route('staff.reports.plans', ['locale' => $uiLocale]) }}"
                            class="staff-btn staff-btn-outline-secondary">
                            <i class="fas fa-x-circle me-1"></i>{{ __('Clear') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Plan Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="staff-card">
                    <div class="staff-card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="staff-avatar staff-avatar-lg bg-primary-subtle">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Plans') }}</h6>
                                <h3 class="mb-0">{{ number_format($planStats['total_plans']) }}</h3>
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
                                    <i class="fas fa-people text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Subscriptions') }}</h6>
                                <h3 class="mb-0">{{ number_format($planStats['total_subscriptions']) }}</h3>
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
                                    <i class="fas fa-currency-dollar text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Total Revenue') }}</h6>
                                <h3 class="mb-0">${{ number_format($planStats['total_revenue'], 2) }}</h3>
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
                                    <i class="fas fa-graph-up text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Average Price') }}</h6>
                                <h3 class="mb-0">${{ number_format($planStats['average_price'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Performance Table -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-bar-chart me-2"></i>{{ __('Plan Performance') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="table-responsive">
                            <table class="staff-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Plan Name') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Subscriptions') }}</th>
                                        <th>{{ __('Revenue') }}</th>
                                        <th>{{ __('Performance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planPerformance as $plan)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="staff-avatar staff-avatar-sm bg-primary-subtle me-2">
                                                        <i class="fas fa-box text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $plan->name }}</h6>
                                                        <small class="text-muted">{{ $plan->duration }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($plan->price, 2) }}</td>
                                            <td>{{ number_format($plan->subscription_count) }}</td>
                                            <td>${{ number_format($plan->total_revenue, 2) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        @php
                                                            $maxRevenue = $planPerformance->max('total_revenue');
                                                            $percentage =
                                                                $maxRevenue > 0
                                                                    ? ($plan->total_revenue / $maxRevenue) * 100
                                                                    : 0;
                                                        @endphp
                                                        <div class="progress-bar" style="width: {{ $percentage }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ round($percentage, 1) }}%</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- Plan Revenue Chart -->
            <div class="col-xl-8">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-graph-up me-2"></i>{{ __('Plan Revenue Comparison') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="planRevenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Plan Subscriptions -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-pie-chart me-2"></i>{{ __('Plan Subscriptions') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="planSubscriptionsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Churn Analysis -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-arrow-down-circle me-2"></i>{{ __('Churn Analysis') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-danger-subtle rounded">
                                    <h4 class="text-danger mb-1">{{ $planChurn['total_churned'] }}</h4>
                                    <small class="text-muted">{{ __('Total Churned') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-warning-subtle rounded">
                                    <h4 class="text-warning mb-1">{{ $planChurn['churn_rate'] }}%</h4>
                                    <small class="text-muted">{{ __('Churn Rate') }}</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center p-3 bg-success-subtle rounded">
                                    <h4 class="text-success mb-1">{{ $planChurn['retention_rate'] }}%</h4>
                                    <small class="text-muted">{{ __('Retention Rate') }}</small>
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
                            <i class="fas fa-list-ul me-2"></i>{{ __('Recent Plan Subscriptions') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        @if ($planSubscriptions->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($planSubscriptions->take(5) as $subscription)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm bg-primary-subtle me-3">
                                                <i class="fas fa-box text-primary"></i>
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
            // Plan Revenue Chart
            const revenueCtx = document.getElementById('planRevenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($planRevenue)->pluck('name')) !!},
                    datasets: [{
                        label: '{{ __('Revenue') }}',
                        data: {!! json_encode(collect($planRevenue)->pluck('revenue')) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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

            // Plan Subscriptions Chart
            const subscriptionsCtx = document.getElementById('planSubscriptionsChart').getContext('2d');
            new Chart(subscriptionsCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($planPerformance)->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($planPerformance)->pluck('subscription_count')) !!},
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
