@extends('staff.layouts.master')

@section('title', __('Plan Subscribers'))

@section('content')
<div class="container-fluid" style="margin-top:250px;">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="staff-breadcrumb">
        <ol class="breadcrumb">
            <li class="staff-breadcrumb-item">
                <a href="{{ route('staff.dashboard', ['locale' => $uiLocale]) }}">{{ __('Dashboard') }}</a>
            </li>
            <li class="staff-breadcrumb-item">
                <a href="{{ route('staff.plans.index', ['locale' => $uiLocale]) }}">{{ __('Plans') }}</a>
            </li>
            <li class="staff-breadcrumb-item">
                <a href="{{ route('staff.plans.show', ['locale' => $uiLocale, 'plan' => $plan->id]) }}">{{ $plan->name ?? 'Plan #' . $plan->id }}</a>
            </li>
            <li class="staff-breadcrumb-item active" aria-current="page">{{ __('Subscribers') }}</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="staff-page-header">
        <div>
            <h4 class="staff-page-title">{{ __('Plan Subscribers') }}</h4>
            <p class="staff-page-subtitle">
                {{ __('Customers subscribed to') }}: 
                <strong>{{ $plan->name ?? 'Plan #' . $plan->id }}</strong>
            </p>
        </div>
        <div class="staff-page-actions">
            <a href="{{ route('staff.plans.show', ['locale' => $uiLocale, 'plan' => $plan->id]) }}" 
               class="staff-btn staff-btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Plan') }}
            </a>
            <a href="{{ route('staff.plans.index', ['locale' => $uiLocale]) }}" 
               class="staff-btn staff-btn-outline-primary">
                <i class="fas fa-list me-1"></i>{{ __('All Plans') }}
            </a>
        </div>
    </div>

    {{-- Plan Information Card --}}
    <div class="staff-card mb-4 staff-fade-in">
        <div class="staff-card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="staff-form-label">{{ __('Plan Name') }}</label>
                    <div class="fw-bold">{{ $plan->name ?? 'Plan #' . $plan->id }}</div>
                </div>
                <div class="col-md-3">
                    <label class="staff-form-label">{{ __('Total Subscribers') }}</label>
                    <div class="fw-bold text-primary">{{ $customers->total() }}</div>
                </div>
                <div class="col-md-3">
                    <label class="staff-form-label">{{ __('Plan Status') }}</label>
                    <div>
                        <span class="staff-badge {{ $plan->is_visible ? 'staff-badge-success' : 'staff-badge-warning' }}">
                            {{ $plan->is_visible ? __('Visible') : __('Hidden') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="staff-form-label">{{ __('Created') }}</label>
                    <div class="text-muted">{{ $plan->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Subscribers Table --}}
    <div class="staff-card staff-fade-in">
        <div class="staff-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-white">
                    <i class="fas fa-people me-2"></i>{{ __('Subscribers List') }}
                </h5>
                <div class="d-flex gap-2">
                    <span class="staff-badge staff-badge-primary">
                        {{ $customers->count() }} {{ __('of') }} {{ $customers->total() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="staff-card-body p-0">
            @if($customers->count() > 0)
                <div class="staff-table-responsive">
                    <table class="staff-table">
                        <thead>
                            <tr>
                                <th class="ps-4">{{ __('ID') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Joined') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-muted">#{{ $customer->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="staff-avatar staff-avatar-sm me-3">
                                                <img src="{{ $customer->avatar }}" alt="{{ $customer->name }}">
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $customer->name }}</div>
                                                <small class="text-muted">{{ $customer->type ?? 'Individual' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $customer->email }}</div>
                                        @if($customer->email_verified_at)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>{{ __('Verified') }}
                                            </small>
                                        @else
                                            <small class="text-warning">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ __('Unverified') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="staff-badge {{ $customer->is_active ? 'staff-badge-success' : 'staff-badge-danger' }}">
                                            {{ $customer->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $customer->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="staff-dropdown">
                                            <button class="staff-btn staff-btn-sm staff-btn-outline-secondary dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown_menu" aria-expanded="false">
                                                <i class="fas fa-three-dots"></i>
                                            </button>
                                            <ul class="staff-dropdown-menu">
                                                <li>
                                                    <a href="{{ route('staff.customers.show', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                       class="staff-dropdown-item">
                                                        <i class="fas fa-eye text-info"></i>
                                                        {{ __('View Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('staff.customers.edit', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                       class="staff-dropdown-item">
                                                        <i class="fas fa-pencil text-warning"></i>
                                                        {{ __('Edit Customer') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('staff.customers.assign-plan', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                       class="staff-dropdown-item">
                                                        <i class="fas fa-package text-primary"></i>
                                                        {{ __('Change Plan') }}
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    @if($customer->is_active)
                                                        <form action="{{ route('staff.customers.deactivate', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="staff-dropdown-item text-warning">
                                                                <i class="fas fa-pause-circle"></i>
                                                                {{ __('Deactivate') }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('staff.customers.activate', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="staff-dropdown-item text-success">
                                                                <i class="fas fa-play-circle"></i>
                                                                {{ __('Activate') }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($customers->hasPages())
                    <div class="staff-card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                {{ __('Showing') }} {{ $customers->firstItem() }} {{ __('to') }} {{ $customers->lastItem() }} 
                                {{ __('of') }} {{ $customers->total() }} {{ __('results') }}
                            </div>
                            <div>
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="staff-empty-state">
                    <div class="staff-empty-state-icon">
                        <i class="fas fa-people"></i>
                    </div>
                    <h5 class="staff-empty-state-title">{{ __('No Subscribers Found') }}</h5>
                    <p class="staff-empty-state-description">
                        {{ __('This plan currently has no subscribers.') }}<br>
                        {{ __('Customers can be assigned to this plan from the customer management section.') }}
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('staff.customers.index', ['locale' => $uiLocale]) }}" 
                           class="staff-btn staff-btn-primary">
                            <i class="fas fa-people me-1"></i>{{ __('Manage Customers') }}
                        </a>
                        <a href="{{ route('staff.plans.show', ['locale' => $uiLocale, 'plan' => $plan->id]) }}" 
                           class="staff-btn staff-btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Plan') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
