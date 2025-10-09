@extends('staff.layouts.master')

@section('page-title')
    {{ __('Create Invoice') }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Create Invoice Form --}}
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-file-plus me-2"></i>{{ __('Invoice Details') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <x-form id="invoiceForm" action="{{ route('staff.invoices.store') }}" method="POST" :axios="true">
                            <div class="row g-3">
                                {{-- Customer Selection --}}
                                <div class="col-md-6">
                                    <label for="customer_id" class="form-label fw-semibold">
                                        <i class="fas fa-person me-1"></i>{{ __('Customer') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="customer_id" id="customer_id" class="form-select" required>
                                        <option value="">{{ __('Select Customer') }}</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
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
                                            <option value="{{ $plan->id }}" data-prices='@json($plan->prices)'>
                                                {{ $plan->name ?? 'Plan #' . $plan->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('Please select a plan.') }}</div>
                                </div>

                                {{-- Currency Selection --}}
                                <div class="col-md-6">
                                    <label for="currency_id" class="form-label fw-semibold">
                                        <i class="fas fa-currency-exchange me-1"></i>{{ __('Currency') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="currency_id" id="currency_id" class="form-select" required>
                                        <option value="">{{ __('Select Currency') }}</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->currency_id }}">
                                                {{ $currency->currencyLanguages->first()?->name ?? $currency->getNameForLanguage() ?? 'Currency #' . $currency->currency_id }}
                                                ({{ $currency->currencyLanguages->first()?->symbol ?? $currency->getSymbol() ?? '$' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('Please select a currency.') }}</div>
                                </div>

                                {{-- Amount --}}
                                <div class="col-md-6">
                                    <label for="amount" class="form-label fw-semibold">
                                        <i class="fas fa-currency-dollar me-1"></i>{{ __('Amount') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" name="amount" id="amount" class="form-control" 
                                               step="0.01" min="0" placeholder="0.00" required>
                                        <span class="input-group-text" id="currency_symbol">$</span>
                                    </div>
                                    <div class="form-text">{{ __('Leave empty to use plan price') }}</div>
                                    <div class="invalid-feedback">{{ __('Please enter a valid amount.') }}</div>
                                </div>

                                {{-- Due Date --}}
                                <div class="col-md-6">
                                    <label for="due_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-1"></i>{{ __('Due Date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="due_date" id="due_date" class="form-control" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    <div class="invalid-feedback">{{ __('Please select a due date.') }}</div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold">
                                        <i class="fas fa-flag me-1"></i>{{ __('Status') }}
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" selected>{{ __('Pending') }}</option>
                                        <option value="paid">{{ __('Paid') }}</option>
                                        <option value="cancelled">{{ __('Cancelled') }}</option>
                                        <option value="refunded">{{ __('Refunded') }}</option>
                                    </select>
                                </div>

                                {{-- Submit Buttons --}}
                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('staff.invoices.index') }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>{{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-lg me-1"></i>{{ __('Create Invoice') }}
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
            const planSelect = document.getElementById('plan_id');
            const currencySelect = document.getElementById('currency_id');
            const amountInput = document.getElementById('amount');
            const currencySymbol = document.getElementById('currency_symbol');

            // Auto-fill amount when plan and currency are selected
            function updateAmount() {
                const selectedPlan = planSelect.options[planSelect.selectedIndex];
                const selectedCurrency = currencySelect.value;
                
                if (selectedPlan && selectedCurrency) {
                    const prices = JSON.parse(selectedPlan.dataset.prices || '[]');
                    const price = prices.find(p => p.currency_id == selectedCurrency);
                    
                    if (price && !amountInput.value) {
                        amountInput.value = price.price;
                    }
                }
            }

            // Update currency symbol
            function updateCurrencySymbol() {
                const selectedOption = currencySelect.options[currencySelect.selectedIndex];
                if (selectedOption && selectedOption.text) {
                    const symbol = selectedOption.text.match(/\(([^)]+)\)/);
                    if (symbol) {
                        currencySymbol.textContent = symbol[1];
                    }
                }
            }

            planSelect.addEventListener('change', updateAmount);
            currencySelect.addEventListener('change', function() {
                updateAmount();
                updateCurrencySymbol();
            });

            // Set default due date to 30 days from now
            const dueDateInput = document.getElementById('due_date');
            const defaultDate = new Date();
            defaultDate.setDate(defaultDate.getDate() + 30);
            dueDateInput.value = defaultDate.toISOString().split('T')[0];
        });
    </script>
@endsection
