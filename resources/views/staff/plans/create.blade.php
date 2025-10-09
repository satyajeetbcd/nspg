{{-- 
==============================================================================
Create Plan Blade Template
Description: This page allows staff to create a new plan in the ERP system.
             It includes creating:
             - Plan details (name, max users, description)
             - Plan duration (monthly/yearly)
             - Plan modules/features selection
             - Dynamic pricing per country and currency
Author: Your Name
Created: 2025-09-17
Version: 1.0
============================================================================== 
--}}

@extends('staff.layouts.master')

@section('page-title', __('Create Plan'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-circle me-1"></i>{{ __('Create Plan') }}
    </li>
@endsection

@section('page-title', __('Create New Plan'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div
                class="breadcrumb-glass text-white rounded-4 px-4 py-3 shadow d-flex align-items-center justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('staff.dashboard') }}" class="text-white text-decoration-none fw-semibold">
                                <i class="fas fa-house-door-fill me-1"></i> {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('staff.plans.index') }}" class="text-white text-decoration-none fw-semibold">
                                <i class="fas fa-arrow-up-right-circle me-1"></i> {{ __('Plans') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('Create Plan') }}
                        </li>
                    </ol>
                </nav>
                <h5 class="mb-0 fw-bold text-white">
                    <i class="fas fa-speedometer2 me-2 text-white"></i>{{ __('Super Admin Panel') }}
                </h5>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container position-relative">
        {{-- =========================================
        Card Wrapper
        Provides a styled white card container with padding and shadow
    ========================================== --}}
        <div class="shadow-sm rounded-4 bg-white p-4">

            {{-- =========================================
            Create Plan Form
            Uses standard form with POST method
            Submits to staff.plans.store route
        ========================================== --}}
            <form id="planForm" action="{{ route('staff.plans.store') }}" method="POST">
                @csrf

                {{-- =========================================
                Plan Name Input
            ========================================== --}}
                <div class="col-12 form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') }}" placeholder="{{ __('Plan Name') }}" required>
                    <label for="name">{{ __('Plan Name') }}</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- =========================================
                Max Users Input
            ========================================== --}}
                <div class="col-12 form-floating mb-3">
                    <input type="number" class="form-control @error('max_user') is-invalid @enderror" name="max_user"
                        id="max_users" value="{{ old('max_user', 1) }}" placeholder="{{ __('Max Users') }}" min="1"
                        required>
                    <label for="max_users">{{ __('Max Users') }}</label>
                    @error('max_user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- =========================================
                Description Textarea
            ========================================== --}}
                <div class="col-12 form-floating mb-3">
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                        placeholder="{{ __('Description') }}" style="height: 150px;">{{ old('description') }}</textarea>
                    <label for="description">{{ __('Description') }}</label>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- =========================================
                Plan Duration / Period Selection
                Allows selecting monthly or yearly plan duration
            ========================================== --}}
                <div class="col-12 form-floating mb-3">
                    <select name="period" class="form-select @error('period') is-invalid @enderror" id="period"
                        required>
                        <option value="" class="text-center" disabled selected>{{ __('Select Period') }}</option>
                        <option value="month" {{ old('period') === 'month' ? 'selected' : '' }}>
                            {{ __('Monthly') }}
                        </option>
                        <option value="year" {{ old('period') === 'year' ? 'selected' : '' }}>
                            {{ __('Yearly') }}
                        </option>
                    </select>
                    <label for="period">{{ __('Period') }}</label>
                    @error('period')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- =========================================
                Features / Modules Section
                Displays all available modules for selection
            ========================================== --}}
                <h5 class="mt-4">{{ __('Available Modules') }}</h5>
                <div class="shadow-sm rounded-4 p-4 mb-4">
                    <div class="row">
                        @php
                            $availableModules = ['Accounts', 'CRM', 'POS', 'HRM', 'Project', 'Manufacture'];
                            $selectedModules = old('basic_features', []);
                        @endphp

                        @foreach ($availableModules as $module)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="form-check">
                                    <label class="form-check-label fw-semibold" for="module_{{ strtolower($module) }}">
                                        {{ $module }}
                                    </label>
                                    <input class="form-check-input bg-dark" type="checkbox" name="basic_features[]"
                                        value="{{ $module }}" id="module_{{ strtolower($module) }}"
                                        {{ in_array($module, $selectedModules) ? 'checked' : '' }}>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('basic_features')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- =========================================
                Plan Prices Section
                Allows adding pricing per country and currency
            ========================================== --}}
                <h5 class="mt-4">{{ __('Plan Prices') }}</h5>
                <div class="card shadow-sm rounded-4 p-4 mb-4">
                    <div id="prices-list" data-countries='@json($countries)' class="row g-3 mb-3">
                        {{-- Price rows will be added dynamically --}}
                    </div>

                    {{-- Add Price Button --}}
                    <button type="button" class="btn btn-outline-success" id="add-price">
                        <i class="fas fa-plus-circle me-1"></i> {{ __('Add Price') }}
                    </button>
                </div>

                {{-- =========================================
                Form Action Buttons
                Save changes or cancel
            ========================================== --}}
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> {{ __('Create Plan') }}
                    </button>
                    <a href="{{ route('staff.plans.index') }}" class="btn btn-light">
                        <i class="fas fa-x-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- =========================================
    Scripts Section
    Handles dynamic price addition and form validation
========================================= --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let priceIndex = 0;
                const countries = @json($countries);
                const currencies = @json($currencies);

                // Add price row function
                function addPriceRow() {
                    const priceRow = `
            <div class="col-md-12 price-item-wrapper" data-index="${priceIndex}">
                <div class="row g-2 align-items-end border rounded p-3 shadow-sm bg-light">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Country') }}</label>
                        <select name="prices[${priceIndex}][country]" class="form-select country-select" required>
                            <option value="">{{ __('Select Country') }}</option>
                            ${countries.map(country => 
                                `<option value="${country.id}" data-currency="${country.currency_id}">${country.name}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Currency') }}</label>
                        <select name="prices[${priceIndex}][currency]" class="form-select currency-select" required>
                            ${currencies.map(currency => 
                                `<option value="${currency.id}">${currency.name} ${currency.symbol}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Price') }}</label>
                        <input type="number" step="0.01" name="prices[${priceIndex}][amount]" 
                               class="form-control" required>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger remove-price">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

                    document.getElementById('prices-list').insertAdjacentHTML('beforeend', priceRow);
                    priceIndex++;
                }

                // Add price button event
                document.getElementById('add-price').addEventListener('click', addPriceRow);

                // Remove price button event (delegated)
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-price')) {
                        e.target.closest('.price-item-wrapper').remove();
                    }
                });

                // Auto-update currency when country changes
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('country-select')) {
                        const currencySelect = e.target.closest('.price-item-wrapper').querySelector(
                            '.currency-select');
                        const selectedCurrencyId = e.target.selectedOptions[0]?.dataset.currency;

                        if (selectedCurrencyId) {
                            currencySelect.value = selectedCurrencyId;
                        }
                    }
                });

                // Add initial price row
                addPriceRow();
            });
        </script>
    @endpush
@endsection
