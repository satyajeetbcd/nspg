@extends('staff.layouts.master')

@section('page-title')
    {{ __('Create Country') }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Create Country Form --}}
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-flag me-2"></i>{{ __('Country Details') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <x-form id="countryForm" action="{{ route('staff.countries.store') }}" method="POST" :axios="true">
                            <div class="row g-3">
                                {{-- Country ISO Code --}}
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-semibold">
                                        <i class="fas fa-barcode me-1"></i>{{ __('ISO Code') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="code" id="code" class="form-control" maxlength="3" placeholder="EG / US / SA" required>
                                    <div class="invalid-feedback">{{ __('Please enter a valid ISO code.') }}</div>
                                </div>

                                {{-- Country Name (English) --}}
                                <div class="col-md-6">
                                    <label for="name_en" class="form-label fw-semibold">
                                        <i class="fas fa-language me-1"></i>{{ __('Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name_en" class="form-control" required>
                                    <div class="invalid-feedback">{{ __('Please enter country name') }}</div>
                                </div>

                   

                                {{-- Submit Buttons --}}
                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('staff.countries.index') }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>{{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-lg me-1"></i>{{ __('Create Country') }}
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
@endsection
