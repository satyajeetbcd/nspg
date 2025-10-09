{{-- 
==============================================================================
Edit Plan Blade Template
Description: This page allows staff to edit an existing plan in the ERP system.
             It includes editing:
             - Plan details (name, max users, description)
             - Plan duration (monthly/yearly)
             - Plan modules/features selection
             - Dynamic pricing per country and currency
Author: Your Name
Created: 2025-09-17
Version: 1.0
============================================================================== 
--}}

<div class="container mt-4">

    {{-- =========================================
        Card Wrapper
        Provides a styled white card container with padding and shadow
    ========================================== --}}
    <div class="shadow-sm rounded-4 bg-white p-4">

        {{-- =========================================
            Edit Plan Form
            Uses custom Blade <x-form> component with Axios support
            Submits to staff.plans.update route
        ========================================== --}}
        <x-form id="planForm" action="{{ route('staff.plans.update', ['locale' => $uiLocale, 'plan' => $plan->id]) }}" method="POST" :axios="true">
            @method('POST')

            {{-- =========================================
                Plan Name Input
            ========================================== --}}
            <div class="col-12 form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" value="{{ $plan->name }}"
                    placeholder="{{ __('Plan Name') }}">
                <label for="name">{{ __('Plan Name') }}</label>
                <div class="invalid-feedback"></div>
            </div>

            {{-- =========================================
                Max Users Input
            ========================================== --}}
            <div class="col-12 form-floating mb-3">
                <input type="text" class="form-control" name="max_user" id="max_users" value="{{ $plan->max_users }}"
                    placeholder="{{ __('Max Users') }}">
                <label for="max_users">{{ __('Max Users') }}</label>
                <div class="invalid-feedback"></div>
            </div>

            {{-- =========================================
                Description Textarea
            ========================================== --}}
            <div class="col-12 form-floating mb-3">
                <textarea name="description" class="form-control" id="description" placeholder="{{ __('Description') }}"
                    style="height: 150px;">{{ $plan->description }}</textarea>
                <label for="description">{{ __('Description') }}</label>
                <div class="invalid-feedback"></div>
            </div>

            {{-- =========================================
                Plan Duration / Period Selection
                Allows selecting monthly or yearly plan duration
            ========================================== --}}
            <div class="col-12 form-floating mb-3">
                <select name="period" class="form-select" id="period">
                    <option value="" disabled selected>{{ __('Select Period') }}</option>
                    <option value="month" {{ old('period', $plan->duration) === 'month' ? 'selected' : '' }}>
                        {{ __('Monthly') }}
                    </option>
                    <option value="year" {{ old('period', $plan->duration) === 'year' ? 'selected' : '' }}>
                        {{ __('Yearly') }}
                    </option>
                </select>
                <label for="period">{{ __('Period') }}</label>
                <div class="invalid-feedback"></div>
            </div>

            {{-- =========================================
                Features / Modules Section
                Displays all features and allows selecting multiple modules per feature
            ========================================== --}}
            <h5 class="mt-4">{{ __('Modules') }}</h5>
            <div class="shadow-sm rounded-4 p-4 mb-4">
                <div id="features-list" class="row">

                    @foreach ($plan->features as $feature)
                        {{-- Feature label --}}
                        <label class="form-label fw-bold">{{ $feature->name }}</label>

                        {{-- Modules select input --}}
                        <select name="basic_features[]" class="form-select select2" id="choices-multiple1" multiple>
                            @foreach ($plan->modules() as $module)
                                <option value="{{ $module }}"
                                    {{ in_array($module, $feature->planModules()) ? 'selected' : '' }}>
                                    {{ $module }}
                                </option>
                            @endforeach
                        </select>
                    @endforeach

                </div>
            </div>

            {{-- =========================================
                Plan Prices Section
                Lists existing prices per country and currency
                Allows adding or removing price rows dynamically
            ========================================== --}}
            <h5 class="mt-4">{{ __('Plan Prices') }}</h5>
            <div class="card shadow-sm rounded-4 p-4 mb-4">
                <div class="card shadow-sm rounded-4 p-4 mb-4">
                    <div id="prices-list" data-countries='@json($countries)' class="row g-3 mb-3">

                        @forelse ($plan->prices as $price)
                            <div class="col-md-12 price-item-wrapper" data-id="{{ $price->id }}">
                                <div class="row g-2 align-items-end border rounded p-3 shadow-sm bg-light">

                                    {{-- Country Selection --}}
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Country') }}</label>
                                        <select name="prices[{{ $price->id }}][country]"
                                            class="form-select country-select" required>
                                            <option value="">{{ __('Select Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    data-currency="{{ $country->currency_id }}"
                                                    @selected($price->country_id == $country->id)>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Currency Selection --}}
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __('Currency') }}</label>
                                        <select name="prices[{{ $price->id }}][currency]"
                                            class="form-select currency-select" required>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}" @selected($price->currency_id == $currency->id)>
                                                    {{ $currency->name }} {{ $currency->symbol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Price Input --}}
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __('Price') }}</label>
                                        <input type="number" step="0.01" name="prices[{{ $price->id }}][amount]"
                                            class="form-control" value="{{ $price->price }}" required>
                                    </div>

                                    {{-- Delete Price Button --}}
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger remove-price">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">{{ __('No prices added yet') }}</div>
                        @endforelse

                    </div>

                    {{-- Add Price Button --}}
                    <button type="button" class="btn btn-outline-success" id="add-price">
                        <i class="fas fa-plus-circle me-1"></i> {{ __('Add Price') }}
                    </button>
                </div>
            </div>

            {{-- =========================================
                Form Action Buttons
                Save changes or cancel
            ========================================== --}}
            <div class="mt-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">{{ __('Save Changes') }}</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            </div>

        </x-form>
    </div>
</div>

{{-- =========================================
    Scripts Section
    Handles automatic currency update when country changes
========================================= --}}
@push('scripts')
    </script>
@endpush
