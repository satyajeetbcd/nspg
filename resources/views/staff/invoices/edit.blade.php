@extends('staff.layouts.master')

@section('page-title')
    {{ __('Edit Invoice') }} - #{{ $invoice->code }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Edit Invoice Form --}}
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-pencil-square me-2"></i>{{ __('Edit Invoice Details') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <x-form id="invoiceForm" action="{{ route('staff.invoices.update', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" method="POST" :axios="true">
                            @method('PUT')
                            <div class="row g-3">
                                {{-- Invoice Code (Read-only) --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hash me-1"></i>{{ __('Invoice Code') }}
                                    </label>
                                    <input type="text" class="form-control" value="#{{ $invoice->code }}" readonly>
                                    <div class="form-text">{{ __('Invoice code cannot be changed') }}</div>
                                </div>

                                {{-- Customer Selection --}}
                                <div class="col-md-6">
                                    <label for="customer_id" class="form-label fw-semibold">
                                        <i class="fas fa-person me-1"></i>{{ __('Customer') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="customer_id" id="customer_id" class="form-select" required>
                                        <option value="">{{ __('Select Customer') }}</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
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
                                                    data-prices='@json($plan->prices)'
                                                    {{ $invoice->plan_id == $plan->id ? 'selected' : '' }}>
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
                                            <option value="{{ $currency->currency_id }}" {{ $invoice->currency_id == $currency->currency_id ? 'selected' : '' }}>
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
                                               step="0.01" min="0" value="{{ $invoice->amount }}" required>
                                        <span class="input-group-text" id="currency_symbol">$</span>
                                    </div>
                                    <div class="invalid-feedback">{{ __('Please enter a valid amount.') }}</div>
                                </div>

                                {{-- Due Date --}}
                                <div class="col-md-6">
                                    <label for="due_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-1"></i>{{ __('Due Date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="due_date" id="due_date" class="form-control" 
                                           value="{{ $invoice->due_date ? (is_string($invoice->due_date) ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : $invoice->due_date->format('Y-m-d')) : '' }}" required>
                                    <div class="invalid-feedback">{{ __('Please select a due date.') }}</div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold">
                                        <i class="fas fa-flag me-1"></i>{{ __('Status') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                                        <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                        <option value="refunded" {{ $invoice->status == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                                    </select>
                                </div>

                                {{-- Created Date (Read-only) --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-plus me-1"></i>{{ __('Created Date') }}
                                    </label>
                                    <input type="text" class="form-control" value="{{ $invoice->created_at->format('M d, Y H:i') }}" readonly>
                                </div>

                                {{-- Submit Buttons --}}
                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('staff.invoices.show', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>{{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check-lg me-1"></i>{{ __('Update Invoice') }}
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
            const currencySelect = document.getElementById('currency_id');
            const currencySymbol = document.getElementById('currency_symbol');

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

            currencySelect.addEventListener('change', updateCurrencySymbol);
            
            // Set initial currency symbol
            updateCurrencySymbol();
        });
    </script>
@endsection
