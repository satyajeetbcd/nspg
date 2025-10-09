@extends('staff.layouts.master')

@section('title', __('Analytics Dashboard'))

@section('content')
<div class="container-fluid position-relative mt-5" >
    <!-- Page Header -->
    <div class="staff-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="staff-page-title">
                    <i class="fas fa-graph-up me-2"></i>{{ __('Analytics Dashboard') }}
                </h1>
                <p class="staff-page-subtitle">{{ __('Advanced analytics and business intelligence') }}</p>
            </div>
       
        </div>
        <a href="{{ route('staff.reports.export', ['locale' => $uiLocale, 'type' => 'analytics']) }}" 
           class="staff-btn staff-btn-outline-primary">
            <i class="fas fa-download me-1"></i>{{ __('Export') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="staff-card mb-4">
        <div class="staff-card-body">
            <form method="GET" action="{{ route('staff.reports.analytics', ['locale' => $uiLocale]) }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Date From') }}</label>
                    <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Date To') }}</label>
                    <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Metric') }}</label>
                    <select class="form-select" name="metric">
                        <option value="">{{ __('All Metrics') }}</option>
                        <option value="conversion" {{ ($filters['metric'] ?? '') === 'conversion' ? 'selected' : '' }}>{{ __('Conversion Rate') }}</option>
                        <option value="retention" {{ ($filters['metric'] ?? '') === 'retention' ? 'selected' : '' }}>{{ __('Retention') }}</option>
                        <option value="churn" {{ ($filters['metric'] ?? '') === 'churn' ? 'selected' : '' }}>{{ __('Churn Rate') }}</option>
                        <option value="ltv" {{ ($filters['metric'] ?? '') === 'ltv' ? 'selected' : '' }}>{{ __('Lifetime Value') }}</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="staff-btn staff-btn-primary">
                        <i class="fas fa-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('staff.reports.analytics', ['locale' => $uiLocale]) }}" class="staff-btn staff-btn-outline-secondary">
                        <i class="fas fa-x-circle me-1"></i>{{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Analytics Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="staff-card">
                <div class="staff-card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="staff-avatar staff-avatar-lg bg-primary-subtle">
                                <i class="fas fa-arrow-up-right text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Conversion Rate') }}</h6>
                            <h3 class="mb-0">{{ $analytics['conversion_rate'] }}%</h3>
                            <small class="text-success">{{ __('Visitor to customer') }}</small>
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
                            <h6 class="mb-1">{{ __('Average Order Value') }}</h6>
                            <h3 class="mb-0">${{ number_format($analytics['average_order_value'], 2) }}</h3>
                            <small class="text-muted">{{ __('Per transaction') }}</small>
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
                                <i class="fas fa-person-heart text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Customer Lifetime Value') }}</h6>
                            <h3 class="mb-0">${{ number_format($analytics['customer_lifetime_value'], 2) }}</h3>
                            <small class="text-muted">{{ __('Average LTV') }}</small>
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
                                <i class="fas fa-arrow-down text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ __('Churn Rate') }}</h6>
                            <h3 class="mb-0">{{ $analytics['churn_rate'] }}%</h3>
                            <small class="text-warning">{{ __('Monthly churn') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversion Funnel -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-funnel me-2"></i>{{ __('Conversion Funnel') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <div class="row g-3">
                        @foreach($conversionFunnel as $index => $stage)
                            <div class="col-md-3">
                                <div class="text-center p-3 {{ $index === 0 ? 'bg-primary-subtle' : ($index === 1 ? 'bg-info-subtle' : ($index === 2 ? 'bg-warning-subtle' : 'bg-success-subtle')) }} rounded">
                                    <h4 class="mb-1 {{ $index === 0 ? 'text-primary' : ($index === 1 ? 'text-info' : ($index === 2 ? 'text-warning' : 'text-success')) }}">{{ number_format($stage['count']) }}</h4>
                                    <small class="text-muted">{{ $stage['stage'] }}</small>
                                    @if($index > 0)
                                        @php
                                            $previousCount = $conversionFunnel[$index - 1]['count'];
                                            $conversionRate = $previousCount > 0 ? round(($stage['count'] / $previousCount) * 100, 1) : 0;
                                        @endphp
                                        <div class="mt-2">
                                            <small class="text-muted">{{ $conversionRate }}% {{ __('conversion') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Retention Analysis -->
        <div class="col-xl-6">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-arrow-repeat me-2"></i>{{ __('Retention Analysis') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="retentionChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Churn Analysis -->
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
                                <h4 class="text-danger mb-1">{{ $churnAnalysis['monthly_churn'] }}%</h4>
                                <small class="text-muted">{{ __('Monthly Churn') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-warning-subtle rounded">
                                <h4 class="text-warning mb-1">{{ $churnAnalysis['quarterly_churn'] }}%</h4>
                                <small class="text-muted">{{ __('Quarterly Churn') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-info-subtle rounded">
                                <h4 class="text-info mb-1">{{ $churnAnalysis['annual_churn'] }}%</h4>
                                <small class="text-muted">{{ __('Annual Churn') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-success-subtle rounded">
                                <h4 class="text-success mb-1">{{ $churnAnalysis['retention_rate'] }}%</h4>
                                <small class="text-muted">{{ __('Retention Rate') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lifetime Value Analysis -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-graph-up me-2"></i>{{ __('Customer Lifetime Value Analysis') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-primary-subtle rounded">
                                <h4 class="text-primary mb-1">${{ number_format($lifetimeValue['average'], 2) }}</h4>
                                <small class="text-muted">{{ __('Average LTV') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-success-subtle rounded">
                                <h4 class="text-success mb-1">{{ number_format($lifetimeValue['total_customers']) }}</h4>
                                <small class="text-muted">{{ __('Total Customers') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-info-subtle rounded">
                                <h4 class="text-info mb-1">{{ number_format($lifetimeValue['high_value_customers']) }}</h4>
                                <small class="text-muted">{{ __('High Value Customers') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-pie-chart me-2"></i>{{ __('Customer Segments') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <canvas id="customerSegmentsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="row g-4">
        <div class="col-12">
            <div class="staff-card">
                <div class="staff-card-header">
                    <h5 class="staff-card-title">
                        <i class="fas fa-lightbulb me-2"></i>{{ __('Performance Insights') }}
                    </h5>
                </div>
                <div class="staff-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <h6 class="mb-0">{{ __('Strengths') }}</h6>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Good conversion rate of') }} {{ $analytics['conversion_rate'] }}%</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Strong retention rate of') }} {{ $churnAnalysis['retention_rate'] }}%</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Healthy average LTV of') }} ${{ number_format($analytics['customer_lifetime_value'], 2) }}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <h6 class="mb-0">{{ __('Areas for Improvement') }}</h6>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Churn rate could be reduced from') }} {{ $analytics['churn_rate'] }}%</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Focus on customer retention strategies') }}</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Improve onboarding process') }}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-target text-info me-2"></i>
                                    <h6 class="mb-0">{{ __('Recommendations') }}</h6>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Implement customer success program') }}</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Optimize pricing strategy') }}</small>
                                    </li>
                                    <li class="mb-1">
                                        <small class="text-muted">• {{ __('Enhance customer support') }}</small>
                                    </li>
                                </ul>
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
    // Retention Chart
    const retentionCtx = document.getElementById('retentionChart').getContext('2d');
    new Chart(retentionCtx, {
        type: 'line',
        data: {
            labels: ['{{ __("Month 1") }}', '{{ __("Month 3") }}', '{{ __("Month 6") }}', '{{ __("Month 12") }}'],
            datasets: [{
                label: '{{ __("Retention Rate") }}',
                data: [{{ $retentionAnalysis['month_1'] }}, {{ $retentionAnalysis['month_3'] }}, {{ $retentionAnalysis['month_6'] }}, {{ $retentionAnalysis['month_12'] }}],
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
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });

    // Customer Segments Chart
    const segmentsCtx = document.getElementById('customerSegmentsChart').getContext('2d');
    new Chart(segmentsCtx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __("High Value") }}', '{{ __("Regular") }}', '{{ __("Low Value") }}'],
            datasets: [{
                data: [
                    {{ $lifetimeValue['high_value_customers'] }}, 
                    {{ $lifetimeValue['total_customers'] - $lifetimeValue['high_value_customers'] - ($lifetimeValue['total_customers'] * 0.2) }}, 
                    {{ $lifetimeValue['total_customers'] * 0.2 }}
                ],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107']
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
