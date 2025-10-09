{{-- Customer Plan --}}
@extends('layouts.customer')

@section('page-title', __('Plan Details'))
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Plan Details') }}</h4>
                <p class="text-muted mb-0">{{ __('View your current plan and available upgrades') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="comparePlans()" class="btn btn-outline-info">
                    <i class="fas fa-balance-scale me-2"></i>{{ __('Compare Plans') }}
                </button>
                <button onclick="contactSales()" class="btn btn-outline-warning">
                    <i class="fas fa-phone me-2"></i>{{ __('Contact Sales') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Current Plan -->
    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">{{ __('Current Plan') }}</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-gem fa-3x text-primary"></i>
                </div>
                <h4 class="text-primary mb-2">{{ __('Free Plan') }}</h4>
                <h2 class="text-primary mb-3">$0<small class="text-muted">/month</small></h2>

                <div class="mb-4">
                    <span class="badge bg-success fs-6 mb-2">
                        <i class="fas fa-check-circle me-1"></i>{{ __('Active') }}
                    </span>
                    <p class="text-muted mb-0">{{ __('No expiration date') }}</p>
                </div>

                @if($company)
                    <div class="text-start mb-4">
                        <h6 class="text-muted">{{ __('Company Details') }}</h6>
                        <p class="mb-1"><strong>{{ __('Company') }}:</strong> {{ $company->company_name }}</p>
                        @if($company->vat_number)
                            <p class="mb-0"><strong>{{ __('VAT') }}:</strong> {{ $company->vat_number }}</p>
                        @endif
                    </div>
                @endif

                <div class="d-grid">
                    <button class="btn btn-outline-primary" onclick="upgradePlan()">
                        <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Plans -->
    <div class="col-lg-8">
        <div class="row">
            <!-- Professional Plan -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-info">
                    <div class="card-header bg-info text-white text-center">
                        <h5 class="mb-0">{{ __('Professional') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-rocket fa-2x text-info"></i>
                        </div>
                        <h3 class="text-info mb-3">$29<small class="text-muted">/month</small></h3>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('All Free Plan Features') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Advanced Analytics') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Priority Support') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('API Access') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Custom Reports') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('10GB Storage') }}
                            </li>
                        </ul>

                        <div class="d-grid">
                            <button class="btn btn-info" onclick="selectPlan('professional')">
                                <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade to Professional') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-warning">
                    <div class="card-header bg-warning text-white text-center">
                        <h5 class="mb-0">{{ __('Enterprise') }}</h5>
                        <span class="badge bg-danger">{{ __('Most Popular') }}</span>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-crown fa-2x text-warning"></i>
                        </div>
                        <h3 class="text-warning mb-3">$99<small class="text-muted">/month</small></h3>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('All Professional Features') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Custom Integrations') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('24/7 Support') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('White-label Options') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Advanced Security') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                {{ __('Unlimited Storage') }}
                            </li>
                        </ul>

                        <div class="d-grid">
                            <button class="btn btn-warning" onclick="selectPlan('enterprise')">
                                <i class="fas fa-crown me-2"></i>{{ __('Upgrade to Enterprise') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Comparison -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-balance-scale me-2"></i>{{ __('Plan Comparison') }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Features') }}</th>
                                <th class="text-center">{{ __('Free') }}</th>
                                <th class="text-center">{{ __('Professional') }}</th>
                                <th class="text-center">{{ __('Enterprise') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ __('Dashboard Access') }}</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('Profile Management') }}</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('Invoice Management') }}</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('Advanced Analytics') }}</td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('API Access') }}</td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('Priority Support') }}</td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('24/7 Support') }}</td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>{{ __('Custom Integrations') }}</td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-times text-muted"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function upgradePlan() {
        // Show upgrade modal
        const modal = new bootstrap.Modal(document.getElementById('upgradeModal'));
        modal.show();
    }

    function selectPlan(planType) {
        // Handle plan selection
        if (confirm(`{{ __("Are you sure you want to upgrade to the :plan plan?", ["plan" => ""]) }}${planType}?`)) {
            // Simulate plan upgrade process
            showToast(`{{ __("Upgrading to :plan plan...", ["plan" => ""]) }}${planType}`, 'info');

            // Redirect to payment or confirmation page
            setTimeout(() => {
                window.location.href = '{{ route("customer.subscription.index") }}';
            }, 2000);
        }
    }

    function comparePlans() {
        // Scroll to comparison table
        document.querySelector('.table-responsive').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function contactSales() {
        // Open contact form or redirect
        window.location.href = '{{ route("public.contact") }}';
    }

    function showToast(message, type = 'info') {
        const toast = new bootstrap.Toast(document.getElementById('toast'));
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toast').className = `toast position-fixed top-0 end-0 p-3 toast-${type}`;
        toast.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any additional functionality
        console.log('Plan page loaded');
    });
</script>
@endpush

<!-- Upgrade Modal -->
<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upgradeModalLabel">{{ __('Upgrade Your Plan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                    <h4>{{ __('Ready to upgrade?') }}</h4>
                    <p class="text-muted">{{ __('Choose the plan that best fits your needs.') }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white text-center">
                                <h5 class="mb-0">{{ __('Professional') }}</h5>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-info">$29<small class="text-muted">/month</small></h3>
                                <button class="btn btn-info w-100" onclick="selectPlan('professional')">
                                    {{ __('Choose Professional') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-white text-center">
                                <h5 class="mb-0">{{ __('Enterprise') }}</h5>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-warning">$99<small class="text-muted">/month</small></h3>
                                <button class="btn btn-warning w-100" onclick="selectPlan('enterprise')">
                                    {{ __('Choose Enterprise') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast position-fixed top-0 end-0 p-3" style="z-index: 9999" id="toast">
    <div class="toast-header">
        <i class="fas fa-info-circle text-primary me-2"></i>
        <strong class="me-auto">{{ __('Notification') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="toastMessage">
        {{ __('Message') }}
    </div>
</div>
