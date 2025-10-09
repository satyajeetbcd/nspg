@extends('staff.layouts.master')

@section('page-title', __('Create Customer'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-circle me-1"></i>{{ __('Create Customer') }}
    </li>
@endsection

@section('page-title', __('Create Customer'))

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
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        <i class="fas fa-person-plus-fill me-1"></i> {{ __('Create Customer') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Create Customer Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="fas fa-person-plus-fill me-2"></i>{{ __('Create New Customer') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <x-form id="customerForm" action="{{ route('staff.customers.store', ['locale' => $uiLocale]) }}" method="POST" :axios="true">
                        <div class="row">
                            {{-- Basic Information --}}
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Basic Information') }}</h6>
                            </div>

                            <!-- Name -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('Enter Full Name') }}" required>
                                <div class="invalid-feedback">{{ __('Please enter your full name.') }}</div>
                            </div>

                            <!-- Email -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="{{ __('Enter Email Address') }}" required>
                                <div class="invalid-feedback">{{ __('Please enter a valid email address.') }}</div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="{{ __('Enter Phone Number') }}">
                            </div>

                            <!-- VAT Number -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="vat_number" class="form-label">{{ __('VAT Number') }}</label>
                                <input type="text" name="vat_number" id="vat_number" class="form-control"
                                    placeholder="{{ __('Enter VAT Number') }}">
                            </div>

                            <!-- Plan Selection -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="plan" class="form-label">{{ __('Select Plan') }}</label>
                                <select name="plan" id="plan" class="form-select">
                                    <option value="">{{ __('No Plan') }}</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name ?? 'Plan #' . $plan->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="is_active" class="form-label">{{ __('Status') }}</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>

                            <!-- Password Section -->
                            <div class="col-12 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="need_login" name="need_login"
                                        onchange="togglePasswordField(this.checked);">
                                    <label class="form-check-label" for="need_login">
                                        {{ __('Customer needs login access') }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-md-6 mb-3" id="passwordField" style="display: none;">
                                <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('Enter Password') }}">
                                <div class="invalid-feedback">{{ __('Please enter a password.') }}</div>
                            </div>

                            {{-- Billing Information --}}
                            <div class="col-12 mt-4 mb-3">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Billing Information') }}</h6>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_name" class="form-label">{{ __('Billing Name') }}</label>
                                <input type="text" name="billing_name" id="billing_name" class="form-control"
                                    placeholder="{{ __('Enter Billing Name') }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_country" class="form-label">{{ __('Country') }}</label>
                                <input type="text" name="billing_country" id="billing_country" class="form-control"
                                    placeholder="{{ __('Enter Country') }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_state" class="form-label">{{ __('State/Province') }}</label>
                                <input type="text" name="billing_state" id="billing_state" class="form-control"
                                    placeholder="{{ __('Enter State/Province') }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_city" class="form-label">{{ __('City') }}</label>
                                <input type="text" name="billing_city" id="billing_city" class="form-control"
                                    placeholder="{{ __('Enter City') }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_phone" class="form-label">{{ __('Billing Phone') }}</label>
                                <input type="text" name="billing_phone" id="billing_phone" class="form-control"
                                    placeholder="{{ __('Enter Phone Number') }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="billing_zip" class="form-label">{{ __('ZIP/Postal Code') }}</label>
                                <input type="text" name="billing_zip" id="billing_zip" class="form-control"
                                    placeholder="{{ __('Enter ZIP/Postal Code') }}">
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="billing_address" class="form-label">{{ __('Billing Address') }}</label>
                                <textarea name="billing_address" id="billing_address" class="form-control" rows="3"
                                    placeholder="{{ __('Enter Full Address') }}"></textarea>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('staff.customers.index', ['locale' => $uiLocale]) }}" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-1"></i> {{ __('Create Customer') }}
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
    function togglePasswordField(show) {
        const field = document.getElementById('passwordField');
        const passwordInput = document.getElementById('password');
        
        if (show) {
            field.style.display = 'block';
            field.style.opacity = '0';
            passwordInput.required = true;
            setTimeout(() => {
                field.style.transition = 'opacity 0.3s';
                field.style.opacity = '1';
            }, 10);
        } else {
            field.style.transition = 'opacity 0.3s';
            field.style.opacity = '0';
            passwordInput.required = false;
            passwordInput.value = '';
            setTimeout(() => {
                field.style.display = 'none';
            }, 300);
        }
    }
</script>
@endsection