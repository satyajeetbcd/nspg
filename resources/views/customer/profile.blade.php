{{-- Customer Profile --}}
@extends('layouts.customer')

@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard')],
            ['label' => __('Profile Management')],
        ],
    ])
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $customer->avatar }}" alt="Profile Image" id="profileImagePreview"
                            class="rounded-circle border border-3 border-primary shadow-sm"
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;">
                        <input type="file" name="profile_image" id="profileImageInput" class="d-none"
                            form="customerForm">
                        <button type="button"
                            class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle"
                            onclick="document.getElementById('profileImageInput').click()">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <h4 class="mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-2">{{ $customer->email }}</p>

                    @if ($company)
                        <div class="mb-3">
                            <span class="badge bg-info fs-6">{{ $company->company_name }}</span>
                            @if ($company->vat_number)
                                <span class="badge bg-secondary ms-1">{{ $company->vat_number }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge {{ $customer->is_truly_active ? 'bg-success' : 'bg-danger' }} fs-6">
                            <i class="fas fa-{{ $customer->is_truly_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                            {{ $customer->status_display }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('Account Information') }}
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ __('Profile Completion') }}</label>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar 
                                    @if ($customer->profile_completion < 50) bg-danger
                                    @elseif($customer->profile_completion < 80) bg-warning
                                    @else bg-success @endif"
                                    role="progressbar" style="width: {{ $customer->profile_completion }}%;"
                                    aria-valuenow="{{ $customer->profile_completion }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    {{ $customer->profile_completion }}%
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('Member Since') }}</label>
                            <p class="form-control-plaintext">{{ $customer->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('Last Login') }}</label>
                            <p class="form-control-plaintext">{{ $customer->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('Email Status') }}</label>
                            <p class="form-control-plaintext">
                                @if ($customer->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('Verified') }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ __('Unverified') }}
                                    </span>
                                @endif
                            </p>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Profile Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit Profile') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="customerForm" action="{{ route('customer.profile.submit', ['customer' => $customer->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>{{ __('Personal Information') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Full Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $customer->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email Address') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email', $customer->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Company Information -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-building me-2"></i>{{ __('Company Information') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                        value="{{ old('company_name', $company?->company_name) }}">
                                    @error('company_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="cr_number" class="form-label">{{ __('CR Number') }}</label>
                                    <input type="text" class="form-control" name="cr_number" id="cr_number"
                                        value="{{ old('cr_number', $company?->cr_number) }}">
                                    @error('cr_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="vat_number" class="form-label">{{ __('VAT Number') }}</label>
                                    <input type="text" class="form-control" name="vat_number" id="vat_number"
                                        value="{{ old('vat_number', $company?->vat_number) }}">
                                    @error('vat_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        value="{{ old('phone', $company?->phone) }}">
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="billing_phone" class="form-label">{{ __('Billing Phone') }}</label>
                                    <input type="text" class="form-control" name="billing_phone" id="billing_phone"
                                        value="{{ old('billing_phone', $company?->billing_phone) }}">
                                    @error('billing_phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label">{{ __('Address') }}</label>
                                    <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $company?->address) }}</textarea>
                                    @error('address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Preferences -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-cog me-2"></i>{{ __('Preferences') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="language" class="form-label">{{ __('Language') }}</label>
                                    <select class="form-select" name="language" id="language">
                                        <option value="en"
                                            {{ ($company?->language ?? 'en') == 'en' ? 'selected' : '' }}>
                                            {{ __('English') }}</option>
                                        <option value="ar"
                                            {{ ($company?->language ?? 'en') == 'ar' ? 'selected' : '' }}>
                                            {{ __('Arabic') }}</option>
                                    </select>
                                    @error('language')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="currency_id" class="form-label">{{ __('Currency') }}</label>
                                    <select class="form-select" name="currency_id" id="currency_id">
                                        <option value="1" {{ ($company?->currency_id ?? 1) == 1 ? 'selected' : '' }}>
                                            USD</option>
                                        <option value="2" {{ ($company?->currency_id ?? 1) == 2 ? 'selected' : '' }}>
                                            SAR</option>
                                    </select>
                                    @error('currency_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-lock me-2"></i>{{ __('Change Password') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                    <input type="password" class="form-control" name="current_password"
                                        id="current_password">
                                </div>
                                <div class="col-md-4">
                                    <label for="password" class="form-label">{{ __('New Password') }}</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="col-md-4">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation">
                                </div>
                            </div>
                            <small
                                class="text-muted">{{ __('Leave password fields empty if you don\'t want to change your password.') }}</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .alert-custom {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 8px;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile image preview
            const profileImageInput = document.getElementById('profileImageInput');
            const profileImagePreview = document.getElementById('profileImagePreview');

            profileImageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form validation and AJAX submission
            const form = document.getElementById('customerForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;

                if (password && password !== passwordConfirmation) {
                    showAlert('{{ __('Passwords do not match!') }}', 'error');
                    return false;
                }

                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('Saving...') }}';
                submitBtn.disabled = true;

                // Prepare form data
                const formData = new FormData(form);

                // AJAX request
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            showAlert(data.message, 'success');
                            // Clear password fields on success
                            document.getElementById('password').value = '';
                            document.getElementById('password_confirmation').value = '';
                        } else {
                            showAlert('{{ __('Profile updated successfully!') }}', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('{{ __('An error occurred while saving. Please try again.') }}',
                            'error');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            });

            // Function to show alerts
            function showAlert(message, type = 'success') {
                // Remove existing alerts
                const existingAlerts = document.querySelectorAll('.alert-custom');
                existingAlerts.forEach(alert => alert.remove());

                // Create alert element
                const alertDiv = document.createElement('div');
                alertDiv.className =
                    `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show alert-custom`;
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.minWidth = '300px';

                alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

                // Add to page
                document.body.appendChild(alertDiv);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        });
    </script>
@endpush
