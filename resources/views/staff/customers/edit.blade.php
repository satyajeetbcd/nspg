
@section('page-title', __('Edit Customer'))

    {{-- Breadcrumb Navigation --}}


    {{-- Edit Customer Form --}}
    <div class="card">
        <div >
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="fas fa-pencil-square me-2"></i>{{ __('Edit Customer') }}: {{ $customer->name }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <x-form id="customerForm" action="{{ route('staff.customers.update', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" method="POST" :axios="true">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            {{-- Basic Information --}}
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Basic Information') }}</h6>
                            </div>

                            <!-- Name -->
                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ __('Enter Full Name') }}" value="{{ old('name', $customer->name) }}" required>
                                <div class="invalid-feedback">{{ __('Please enter your full name.') }}</div>
                                <label for="name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                            </div>

                            <!-- Email -->
                            <div class="form-group form-floatingcol-md-6 mb-3">
                                <input type="email" name="email" id="email" class="form-control"
                                placeholder="{{ __('Enter Email Address') }}" value="{{ old('email', $customer->email) }}" required>
                                <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">{{ __('Please enter a valid email address.') }}</div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="phone" id="phone" class="form-control"
                                placeholder="{{ __('Enter Phone Number') }}" value="{{ old('phone', $customer->phone) }}">
                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            </div>

                            <!-- VAT Number -->
                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="vat_number" id="vat_number" class="form-control"
                                placeholder="{{ __('Enter VAT Number') }}" value="{{ old('vat_number', $customer->company->vat_number) }}">
                                <label for="vat_number" class="form-label">{{ __('VAT Number') }}</label>
                            </div>

                            <!-- Plan Selection -->
                            <div class="form-group form-floating col-md-6 mb-3">
                                <select name="plan" id="plan" class="form-select">
                                    <option value="">{{ __('No Plan') }}</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('plan', $customer->plan) == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name ?? 'Plan #' . $plan->id }}
                                    </option>
                                    @endforeach
                                    <label for="plan" class="form-label">{{ __('Select Plan') }}</label>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group form-floating col-md-6 mb-3">
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', $customer->is_active) ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ !old('is_active', $customer->is_active) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                                <label for="is_active" class="form-label">{{ __('Status') }}</label>
                            </div>

                            {{-- Billing Information --}}
                            <div class="col-12 mt-4 mb-3">
                                <h6 class="fw-bold text-primary border-bottom pb-2">{{ __('Billing Information') }}</h6>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_name" id="billing_name" class="form-control"
                                placeholder="{{ __('Enter Billing Name') }}" value="{{ old('billing_name', $customer->billing_name) }}">
                                <label for="billing_name" class="form-label">{{ __('Billing Name') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_country" id="billing_country" class="form-control"
                                placeholder="{{ __('Enter Country') }}" value="{{ old('billing_country', $customer->billing_country) }}">
                                <label for="billing_country" class="form-label">{{ __('Country') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_state" id="billing_state" class="form-control"
                                placeholder="{{ __('Enter State/Province') }}" value="{{ old('billing_state', $customer->billing_state) }}">
                                <label for="billing_state" class="form-label">{{ __('State/Province') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_city" id="billing_city" class="form-control"
                                placeholder="{{ __('Enter City') }}" value="{{ old('billing_city', $customer->billing_city) }}">
                                <label for="billing_city" class="form-label">{{ __('City') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_phone" id="billing_phone" class="form-control"
                                placeholder="{{ __('Enter Phone Number') }}" value="{{ old('billing_phone', $customer->billing_phone) }}">
                                <label for="billing_phone" class="form-label">{{ __('Billing Phone') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-6 mb-3">
                                <input type="text" name="billing_zip" id="billing_zip" class="form-control"
                                placeholder="{{ __('Enter ZIP/Postal Code') }}" value="{{ old('billing_zip', $customer->billing_zip) }}">
                                <label for="billing_zip" class="form-label">{{ __('ZIP/Postal Code') }}</label>
                            </div>

                            <div class="form-group form-floating col-md-12 mb-3">
                                <textarea name="billing_address" id="billing_address" class="form-control" rows="3"
                                placeholder="{{ __('Enter Full Address') }}">{{ old('billing_address', $customer->billing_address) }}</textarea>
                                <label for="billing_address" class="form-label">{{ __('Billing Address') }}</label>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('staff.customers.index', ['locale' => $uiLocale]) }}" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-1"></i> {{ __('Update Customer') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>