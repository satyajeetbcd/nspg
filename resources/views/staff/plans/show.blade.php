{{-- 
==============================================================================
Plan Details View
Description: This page displays detailed information about a specific plan
Author: Your Name
Created: 2025-09-17
Version: 1.0
============================================================================== 
--}}

@extends('staff.layouts.master')

@section('page-title', __('Plan Details'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-circle me-1"></i>{{ __('Plan Details') }}
    </li>
@endsection

@section('page-title', __('Plan Details'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumb-glass text-white rounded-4 px-4 py-3 shadow d-flex align-items-center justify-content-between">
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
                            <i class="fas fa-eye me-1"></i> {{ $plan->name }}
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
<div class="container mt-4">
    
    {{-- Plan Header Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-arrow-up-right-circle me-2"></i>{{ $plan->name }}
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('staff.plans.edit', ['locale' => app()->getLocale(), 'plan' => $plan->id]) }}" 
                       class="btn btn-light btn-sm">
                        <i class="fas fa-pencil-square me-1"></i> {{ __('Edit') }}
                    </a>
                    <a href="{{ route('staff.plans.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Plans') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-3">{{ __('Plan Information') }}</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar3 me-2 text-primary"></i>
                                <strong>{{ __('Duration') }}:</strong>
                                <span class="ms-2 badge bg-info">{{ ucfirst($plan->duration) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-people me-2 text-primary"></i>
                                <strong>{{ __('Max Users') }}:</strong>
                                <span class="ms-2">{{ $plan->max_users < 0 ? 'Unlimited' : $plan->max_users }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-toggle-on me-2 text-primary"></i>
                                <strong>{{ __('Status') }}:</strong>
                                <span class="ms-2 badge {{ $plan->is_disable ? 'bg-danger' : 'bg-success' }}">
                                    {{ $plan->is_disable ? __('Disabled') : __('Active') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye me-2 text-primary"></i>
                                <strong>{{ __('Visibility') }}:</strong>
                                <span class="ms-2 badge {{ $plan->is_visible ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $plan->is_visible ? __('Visible') : __('Hidden') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($plan->description)
                        <div class="mt-4">
                            <h6 class="fw-bold">{{ __('Description') }}</h6>
                            <p class="text-muted">{{ $plan->description }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-light rounded-4 p-4">
                            <i class="fas fa-arrow-up-right-circle display-4 text-primary mb-3"></i>
                            <h5 class="fw-bold">{{ __('Subscribers') }}</h5>
                            <h2 class="text-primary fw-bold">{{ $plan->subscribers_count ?? 0 }}</h2>
                            <a href="{{ route('staff.plans.subscribers', ['locale' => app()->getLocale(), 'plan' => $plan->id]) }}" 
                               class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-people me-1"></i> {{ __('View Subscribers') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Plan Features --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-light rounded-top-4 py-3">
            <h5 class="mb-0 fw-bold text-white">
                <i class="fas fa-gear me-2"></i>{{ __('Plan Features') }}
            </h5>
        </div>
        <div class="card-body p-4">
            @if($plan->features && $plan->features->count() > 0)
                <div class="row">
                    @foreach($plan->features as $feature)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle-fill text-success me-2"></i>
                                <span class="fw-semibold">{{ __('Plan Features') }}</span>
                            </div>
                            @if(method_exists($feature, 'planModules'))
                                <div class="ms-4 mt-2">
                                    @foreach($feature->planModules() as $module)
                                        <span class="badge bg-success-subtle text-success me-1 mb-1">
                                            <i class="fas fa-check me-1"></i>{{ $module }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-exclamation-circle display-4 mb-3"></i>
                    <p>{{ __('No features configured for this plan') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Plan Pricing --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-light rounded-top-4 py-3">
            <h5 class="mb-0 fw-bold text-white">
                <i class="fas fa-currency-dollar me-2"></i>{{ __('Plan Pricing') }}
            </h5>
        </div>
        <div class="card-body p-4">
            @if($plan->prices && $plan->prices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Period') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan->prices as $price)
                                <tr>
                                    <td>
                                        <i class="fas fa-geo-alt me-2 text-primary"></i>
                                        {{ $price->country->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-currency-exchange me-2 text-success"></i>
                                        {{ $price->currency->name ?? 'N/A' }} 
                                        <small class="text-muted">({{ $price->currency->symbol ?? '' }})</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">
                                            {{ number_format($price->price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($plan->duration) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-exclamation-circle display-4 mb-3"></i>
                    <p>{{ __('No pricing configured for this plan') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Plan Statistics --}}
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <i class="fas fa-people display-4 text-primary mb-3"></i>
                <h5 class="fw-bold">{{ __('Total Subscribers') }}</h5>
                <h3 class="text-primary fw-bold">{{ $plan->subscribers_count ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <i class="fas fa-calendar-check display-4 text-success mb-3"></i>
                <h5 class="fw-bold">{{ __('Created') }}</h5>
                <h6 class="text-muted">{{ $plan->created_at->format('M d, Y') }}</h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <i class="fas fa-arrow-clockwise display-4 text-warning mb-3"></i>
                <h5 class="fw-bold">{{ __('Last Updated') }}</h5>
                <h6 class="text-muted">{{ $plan->updated_at->format('M d, Y') }}</h6>
            </div>
        </div>
    </div>

</div>
@endsection
