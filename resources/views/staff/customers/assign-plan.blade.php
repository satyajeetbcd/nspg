@extends('staff.layouts.master')

@section('page-title', __('Assign Plan'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-circle me-1"></i>{{ __('Assign Plan') }}
    </li>
@endsection

@section('page-title', __('Assign Plan to Customer'))

@section('content')
<div class="container">
    {{-- Breadcrumb Navigation --}}
    <div class="row mb-4">
        <div class="col-12">
            <nav class="breadcrumb-glass text-white rounded px-4 py-3 d-flex align-items-center justify-content-between">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item text-white">
                        <a href="{{ route('staff.dashboard', ['locale' => $uiLocale]) }}" class="text-white">
                            <i class="fas fa-house-door-fill me-1"></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item text-white">
                        <a href="{{ route('staff.customers.index', ['locale' => $uiLocale]) }}" class="text-white">
                            <i class="fas fa-people-fill me-1"></i> {{ __('Customers') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item text-white">
                        <a href="{{ route('staff.customers.show', ['locale' => $uiLocale, 'customer' => $customer]) }}" class="text-white">
                            <i class="fas fa-person me-1"></i> {{ $customer->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        <i class="fas fa-package me-1"></i> {{ __('Assign Plan') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Plan Assignment Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="fas fa-package me-2"></i>{{ __('Assign Plan to') }}: {{ $customer->name }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    {{-- Current Plan Information --}}
                    @php
                        $customerPlan = $customer->plan()->first();
                    @endphp
                    @if($customerPlan)
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>{{ __('Current Plan') }}
                            </h6>
                            <p class="mb-0">
                                <strong>{{ $customerPlan->name ?? 'Plan #' . $customerPlan->id }}</strong>
                                @if($customerPlan->description)
                                    - {{ $customerPlan->description }}
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ __('No Plan Assigned') }}
                            </h6>
                            <p class="mb-0">{{ __('This customer currently has no plan assigned.') }}</p>
                        </div>
                    @endif

                    <x-form id="assignPlanForm" action="{{ route('staff.customers.assign-plan.store', ['locale' => $uiLocale, 'customer' => $customer]) }}" method="POST" :axios="true">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Select Plan') }}</h6>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="plan_id" class="form-label">{{ __('Choose Plan') }} <span class="text-danger">*</span></label>
                                <select name="plan_id" id="plan_id" class="form-select" required>
                                    <option value="">{{ __('Select a plan...') }}</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ old('plan_id', $customerPlan?->id) == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name ?? 'Plan #' . $plan->id }}
                                            @if($plan->description)
                                                - {{ Str::limit($plan->description, 50) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('Please select a plan.') }}</div>
                            </div>

                            {{-- Plan Details Preview --}}
                            <div class="col-12 mb-4" id="planDetails" style="display: none;">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Plan Details') }}</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div id="planInfo">
                                            {{-- Plan details will be loaded here via JavaScript --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('staff.customers.show', ['locale' => $uiLocale, 'customer' => $customer]) }}" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-1"></i> {{ __('Assign Plan') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>

    {{-- Available Plans Overview --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="fas fa-list-ul me-2"></i>{{ __('Available Plans') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @forelse($plans as $plan)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">
                                            {{ $plan->name ?? 'Plan #' . $plan->id }}
                                            @if($customerPlan && $customerPlan->id == $plan->id)
                                                <span class="badge bg-success ms-2">{{ __('Current') }}</span>
                                            @endif
                                        </h6>
                                        @if($plan->description)
                                            <p class="card-text text-muted small">{{ Str::limit($plan->description, 100) }}</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                @if($plan->is_visible)
                                                    <span class="badge bg-success-subtle text-success">{{ __('Visible') }}</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">{{ __('Hidden') }}</span>
                                                @endif
                                            </small>
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="selectPlan({{ $plan->id }})">
                                                {{ __('Select') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-package display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('No Plans Available') }}</h5>
                                <p class="text-muted">{{ __('There are no plans available to assign.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Plan selection functionality
    function selectPlan(planId) {
        document.getElementById('plan_id').value = planId;
        loadPlanDetails(planId);
    }

    // Load plan details when selection changes
    document.getElementById('plan_id').addEventListener('change', function() {
        const planId = this.value;
        if (planId) {
            loadPlanDetails(planId);
        } else {
            document.getElementById('planDetails').style.display = 'none';
        }
    });

    function loadPlanDetails(planId) {
        // This would typically make an AJAX call to get plan details
        // For now, we'll show a simple message
        const planDetails = document.getElementById('planDetails');
        const planInfo = document.getElementById('planInfo');
        
        planInfo.innerHTML = `
            <div class="text-center">
                <i class="fas fa-package display-4 text-primary mb-3"></i>
                <h6>{{ __('Plan Selected') }}</h6>
                <p class="text-muted">{{ __('Plan details will be loaded here.') }}</p>
            </div>
        `;
        
        planDetails.style.display = 'block';
    }

    // Initialize plan details if a plan is already selected
    document.addEventListener('DOMContentLoaded', function() {
        const selectedPlan = document.getElementById('plan_id').value;
        if (selectedPlan) {
            loadPlanDetails(selectedPlan);
        }
    });
</script>
@endsection
