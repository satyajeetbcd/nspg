@extends('staff.layouts.master')

@section('page-title')
    {{ __('Edit Subscription') }} - {{ $subscription->customer->name }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Edit Subscription Form --}}
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-pencil-square me-2"></i>{{ __('Edit Subscription Details') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <x-form id="subscriptionForm" action="{{ route('staff.subscriptions.update', ['locale' => app()->getLocale(), 'subscription' => $subscription]) }}" method="POST" :axios="true">
                            @method('PUT')
                            <div class="row g-3">
                                {{-- Customer Selection --}}
                                <div class="col-md-6">
                                    <label for="customer_id" class="form-label fw-semibold">
                                        <i class="fas fa-person me-1"></i>{{ __('Customer') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="customer_id" id="customer_id" class="form-select" required>
                                        <option value="">{{ __('Select Customer') }}</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $subscription->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('Please select a customer.') }}</div>
                                </div>

                                {{-- Plan Selection --}}
                                <div class="col-md-6">
                                    <label for="plan_id" class="form-label fw-semibold">
                                        <i class="fas fa-package me-1"></i>{{ __('Plan') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="plan_id" id="plan_id" class="form-select" required>
                                        <option value="">{{ __('Select Plan') }}</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" 
                                                    data-duration="{{ $plan->duration }}"
                                                    {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                                                {{ $plan->name ?? 'Plan #' . $plan->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('Please select a plan.') }}</div>
                                </div>

                                {{-- Start Date --}}
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-plus me-1"></i>{{ __('Start Date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" 
                                           value="{{ $subscription->start_date ? $subscription->start_date->format('Y-m-d') : '' }}" required>
                                    <div class="invalid-feedback">{{ __('Please select a start date.') }}</div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-check me-1"></i>{{ __('End Date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" 
                                           value="{{ $subscription->end_date ? $subscription->end_date->format('Y-m-d') : '' }}" required>
                                    <div class="invalid-feedback">{{ __('Please select an end date.') }}</div>
                                </div>

                                {{-- Grace Date --}}
                                <div class="col-md-6">
                                    <label for="grace_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-x me-1"></i>{{ __('Grace Date') }}
                                    </label>
                                    <input type="date" name="grace_date" id="grace_date" class="form-control" 
                                           value="{{ $subscription->grace_date ? $subscription->grace_date->format('Y-m-d') : '' }}">
                                    <div class="form-text">{{ __('Optional: Date when subscription expires after grace period') }}</div>
                                </div>

                                {{-- Duration Helper --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-info-circle me-1"></i>{{ __('Quick Duration') }}
                                    </label>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDuration('month')">
                                            {{ __('1 Month') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDuration('3months')">
                                            {{ __('3 Months') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDuration('year')">
                                            {{ __('1 Year') }}
                                        </button>
                                    </div>
                                </div>

                                {{-- Current Status --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-flag me-1"></i>{{ __('Current Status') }}
                                    </label>
                                    <div>
                                        @php
                                            $statusClasses = [
                                                'active' => 'bg-success-subtle text-success',
                                                'grace_period' => 'bg-warning-subtle text-warning',
                                                'expired' => 'bg-danger-subtle text-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusClasses[$subscription->status] ?? 'bg-secondary-subtle text-secondary' }} fs-6">
                                            {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Created Date (Read-only) --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-plus me-1"></i>{{ __('Created Date') }}
                                    </label>
                                    <input type="text" class="form-control" value="{{ $subscription->created_at->format('M d, Y H:i') }}" readonly>
                                </div>

                                {{-- Submit Buttons --}}
                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('staff.subscriptions.show', ['locale' => app()->getLocale(), 'subscription' => $subscription]) }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>{{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check-lg me-1"></i>{{ __('Update Subscription') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const graceDateInput = document.getElementById('grace_date');
            const planSelect = document.getElementById('plan_id');

            // Auto-calculate end date based on plan duration
            planSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const duration = selectedOption.dataset.duration;
                
                if (duration && startDateInput.value) {
                    calculateEndDate(duration);
                }
            });

            startDateInput.addEventListener('change', function() {
                if (planSelect.value) {
                    const selectedOption = planSelect.options[planSelect.selectedIndex];
                    const duration = selectedOption.dataset.duration;
                    calculateEndDate(duration);
                }
            });

            function calculateEndDate(duration) {
                const startDate = new Date(startDateInput.value);
                let endDate = new Date(startDate);

                switch (duration) {
                    case 'month':
                        endDate.setMonth(endDate.getMonth() + 1);
                        break;
                    case 'year':
                        endDate.setFullYear(endDate.getFullYear() + 1);
                        break;
                    default:
                        endDate.setMonth(endDate.getMonth() + 1);
                }

                endDateInput.value = endDate.toISOString().split('T')[0];
                
                // Set grace date to 7 days after end date
                const graceDate = new Date(endDate);
                graceDate.setDate(graceDate.getDate() + 7);
                graceDateInput.value = graceDate.toISOString().split('T')[0];
            }

            // Quick duration buttons
            window.setDuration = function(period) {
                const startDate = new Date(startDateInput.value);
                let endDate = new Date(startDate);

                switch (period) {
                    case 'month':
                        endDate.setMonth(endDate.getMonth() + 1);
                        break;
                    case '3months':
                        endDate.setMonth(endDate.getMonth() + 3);
                        break;
                    case 'year':
                        endDate.setFullYear(endDate.getFullYear() + 1);
                        break;
                }

                endDateInput.value = endDate.toISOString().split('T')[0];
                
                // Set grace date to 7 days after end date
                const graceDate = new Date(endDate);
                graceDate.setDate(graceDate.getDate() + 7);
                graceDateInput.value = graceDate.toISOString().split('T')[0];
            };
        });
    </script>
@endsection

