@extends('staff.layouts.master')

@section('title', __('Customer Reports'))

@section('content')
    <div class="container-fluid position-relative mt-5">
        <!-- Page Header -->
        <div class="staff-page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="staff-page-title">
                        <i class="fas fa-people me-2"></i>{{ __('Customer Reports') }}
                    </h1>
                    <p class="staff-page-subtitle">{{ __('Detailed customer analytics and insights') }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'customers']) }}"
                    class="staff-btn staff-btn-outline-primary">
                    <i class="fas fa-download me-1"></i>{{ __('Export') }}
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="staff-card mb-4">
            <div class="staff-card-body">
                <form method="GET" action="{{ route('staff.reports.customers', ['locale' => $uiLocale]) }}"
                    class="row g-3">
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
                        <label class="form-label">{{ __('Status') }}</label>
                        <select class="form-select" name="status">
                            <option value="">{{ __('All Statuses') }}</option>
                            <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>
                                {{ __('Active') }}</option>
                            <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>
                                {{ __('Inactive') }}</option>
                        </select>
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
                    <div class="col-12">
                        <button type="submit" class="staff-btn staff-btn-primary">
                            <i class="fas fa-funnel me-1"></i>{{ __('Apply Filters') }}
                        </button>
                        <a href="{{ route('staff.reports.customers', ['locale' => $uiLocale]) }}"
                            class="staff-btn staff-btn-outline-secondary">
                            <i class="fas fa-x-circle me-1"></i>{{ __('Clear') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Statistics -->
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
                                <h3 class="mb-0">{{ number_format($customerStats['total']) }}</h3>
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
                                <h6 class="mb-1">{{ __('Active Customers') }}</h6>
                                <h3 class="mb-0">{{ number_format($customerStats['active']) }}</h3>
                                <small
                                    class="text-muted">{{ round(($customerStats['active'] / max($customerStats['total'], 1)) * 100, 1) }}%</small>
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
                                    <i class="fas fa-envelope-check text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Verified Customers') }}</h6>
                                <h3 class="mb-0">{{ number_format($customerStats['verified']) }}</h3>
                                <small
                                    class="text-muted">{{ round(($customerStats['verified'] / max($customerStats['total'], 1)) * 100, 1) }}%</small>
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
                                    <i class="fas fa-people-fill text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ __('Inactive Customers') }}</h6>
                                <h3 class="mb-0">{{ number_format($customerStats['inactive']) }}</h3>
                                <small
                                    class="text-muted">{{ round(($customerStats['inactive'] / max($customerStats['total'], 1)) * 100, 1) }}%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- Customer Growth Chart -->
            <div class="col-xl-8">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-graph-up me-2"></i>{{ __('Customer Growth') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="customerGrowthChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Customers by Plan -->
            <div class="col-xl-4">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-pie-chart me-2"></i>{{ __('Customers by Plan') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <canvas id="customersByPlanChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers by Country -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-globe me-2"></i>{{ __('Customers by Country') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        <div class="table-responsive">
                            <table class="staff-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Customers') }}</th>
                                        <th>{{ __('Percentage') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customerByCountry as $country)
                                        <tr>
                                            <td>{{ $country['country'] }}</td>
                                            <td>{{ number_format($country['count']) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar"
                                                            style="width: {{ ($country['count'] / max($customerStats['total'], 1)) * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ round(($country['count'] / max($customerStats['total'], 1)) * 100, 1) }}%</small>
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

            <!-- Top Customers -->
            <div class="col-xl-6">
                <div class="staff-card">
                    <div class="staff-card-header">
                        <h5 class="staff-card-title">
                            <i class="fas fa-trophy me-2"></i>{{ __('Top Customers by Revenue') }}
                        </h5>
                    </div>
                    <div class="staff-card-body">
                        @if ($topCustomers->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($topCustomers as $customer)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm bg-primary-subtle me-3">
                                                <i class="fas fa-person text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $customer->name }}</h6>
                                                <small class="text-muted">{{ $customer->email }}</small>
                                            </div>
                                            <div class="text-end">
                                                <h6 class="mb-0">${{ number_format($customer->total_revenue, 2) }}</h6>
                                                <small class="text-muted">{{ __('Total Revenue') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="staff-empty-state">
                                <i class="fas fa-trophy text-muted"></i>
                                <p class="text-muted">{{ __('No customer data available') }}</p>
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
            // Customer Growth Chart
            const growthCtx = document.getElementById('customerGrowthChart').getContext('2d');
            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($customerGrowth)->pluck('month')) !!},
                    datasets: [{
                        label: '{{ __('New Customers') }}',
                        data: {!! json_encode(collect($customerGrowth)->pluck('count')) !!},
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

            // Customers by Plan Chart
            const planCtx = document.getElementById('customersByPlanChart').getContext('2d');
            new Chart(planCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($customerByPlan)->pluck('plan_name')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($customerByPlan)->pluck('count')) !!},
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
