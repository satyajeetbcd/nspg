@extends('staff.layouts.master')

@section('title', __('Revenue Reports'))

@section('content')
    <div class="container-fluid position-relative mt-5">
        <!-- Page Header -->
        <div class="staff-page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="staff-page-title">
                        <i class="fas fa-currency-dollar me-2"></i>{{ __('Revenue Reports') }}
                    </h1>
                    <p class="staff-page-subtitle">{{ __('Comprehensive revenue analytics and financial insights') }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'revenue']) }}"
                    class="staff-btn staff-btn-outline-primary">
                    <i class="fas fa-download me-1"></i>{{ __('Export') }}
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="staff-card mb-4">
            <div class="staff-card-body">
                <form method="GET" action="{{ route('staff.reports.revenue', ['locale' => $uiLocale]) }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Date From') }}</label>
                        <input type="date" class="form-control" name="date_from"
                            value="{{ $filters['date_from'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Date To') }}</label>
                        <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Currency') }}</label>
                        <select class="form-select" name="currency_id">
                            <option value="">{{ __('All Currencies') }}</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    {{ ($filters['currency_id'] ?? '') == $currency->id ? 'selected' : '' }}>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="staff-btn staff-btn-primary">
                            <i class="fas fa-funnel me-1"></i>{{ __('Apply Filters') }}
                        </button>
                        <a href="{{ route('staff.reports.revenue', ['locale' => $uiLocale]) }}"
                            class="staff-btn staff-btn-outline-secondary">
                            <i class="fas fa-x-circle me-1"></i>{{ __('Clear') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Revenue Statistics -->
        <div class="row g-4 mb-4">
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
                                <h3 class="mb-0">${{ number_format($revenueStats['total'], 2) }}</h3>
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
                                <h6 class="mb-1">{{ __('Total Transactions') }}</h6>
                                <h3 class="mb-0">{{ number_format($revenueStats['count']) }}</h3>
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
                                <div class="staff-avatar staff-avatar-lg bg-primary-subtle">
                                    <i class="fas fa-graph-up text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Average Order Value') }}</h6>
                                <h3 class="mb-0">${{ number_format($revenueStats['average'], 2) }}</h3>
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
                                    <i class="fas fa-arrow-up text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Growth Rate') }}</h6>
                                <h3 class="mb-0">{{ $revenueStats['growth_rate'] }}%</h3>
                                <small class="text-success">{{ __('vs last period') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- Revenue by Month -->
            <div class="col-xl-8">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-graph-up me-2"></i>{{ __('Revenue by Month') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="revenueByMonthChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue by Plan -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-pie-chart me-2"></i>{{ __('Revenue by Plan') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="revenueByPlanChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Country -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-globe me-2"></i>{{ __('Revenue by Country') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="table-responsive">
                            <table class="staff-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Revenue') }}</th>
                                        <th>{{ __('Percentage') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revenueByCountry as $country)
                                        <tr>
                                            <td>{{ $country->country ?? 'Unknown' }}</td>
                                            <td>${{ number_format($country->revenue, 2) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar"
                                                            style="width: {{ ($country->revenue / max($revenueStats['total'], 1)) * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ round(($country->revenue / max($revenueStats['total'], 1)) * 100, 1) }}%</small>
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

            <!-- Payment Methods -->
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-credit-card me-2"></i>{{ __('Payment Methods') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="table-responsive">
                            <table class="staff-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Payment Method') }}</th>
                                        <th>{{ __('Count') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentMethods as $method)
                                        <tr>
                                            <td>{{ $method['method'] }}</td>
                                            <td>{{ number_format($method['count']) }}</td>
                                            <td>${{ number_format($method['amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recurring vs One-time Revenue -->
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-arrow-repeat me-2"></i>{{ __('Recurring vs One-time Revenue') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="recurringVsOneTimeChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-bar-chart me-2"></i>{{ __('Revenue Summary') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-success-subtle rounded">
                                    <h4 class="text-success mb-1">
                                        ${{ number_format($recurringVsOneTime['recurring'], 2) }}</h4>
                                    <small class="text-muted">{{ __('Recurring Revenue') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-info-subtle rounded">
                                    <h4 class="text-info mb-1">${{ number_format($recurringVsOneTime['one_time'], 2) }}
                                    </h4>
                                    <small class="text-muted">{{ __('One-time Revenue') }}</small>
                                </div>
                            </div>
                        </div>
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
            // Revenue by Month Chart
            const revenueCtx = document.getElementById('revenueByMonthChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($revenueByMonth)->pluck('month')) !!},
                    datasets: [{
                        label: '{{ __('Revenue') }}',
                        data: {!! json_encode(collect($revenueByMonth)->pluck('revenue')) !!},
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

            // Revenue by Plan Chart
            const planCtx = document.getElementById('revenueByPlanChart').getContext('2d');
            new Chart(planCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($revenueByPlan)->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($revenueByPlan)->pluck('revenue')) !!},
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

            // Recurring vs One-time Chart
            const recurringCtx = document.getElementById('recurringVsOneTimeChart').getContext('2d');
            new Chart(recurringCtx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __('Recurring') }}', '{{ __('One-time') }}'],
                    datasets: [{
                        data: [{{ $recurringVsOneTime['recurring'] }},
                            {{ $recurringVsOneTime['one_time'] }}
                        ],
                        backgroundColor: ['#28a745', '#17a2b8']
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
