@extends('staff.layouts.master')

@section('page-title')
    {{ __('Subscription Management') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-credit-card me-1"></i>{{ __('Subscriptions') }}
    </li>
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- KPI Summary --}}
    <div class="container mb-5 mt-5">
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-credit-card display-4 text-primary mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Total Subscriptions') }}</h6>
                        <h3 class="fw-bold text-primary">{{ $subscriptions->total() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-check-circle display-4 text-success mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Active') }}</h6>
                        <h3 class="fw-bold text-success">{{ $subscriptions->where('end_date', '>', now())->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-clock-history display-4 text-warning mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Grace Period') }}</h6>
                        <h3 class="fw-bold text-warning">{{ $subscriptions->where('grace_date', '>', now())->where('end_date', '<=', now())->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-x-circle display-4 text-danger mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Expired') }}</h6>
                        <h3 class="fw-bold text-danger">{{ $subscriptions->where('end_date', '<=', now())->where('grace_date', '<=', now())->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        {{-- Subscriptions Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-white">
                    <i class="fas fa-credit-card me-2"></i>{{ __('Subscriptions List') }}
                </h5>
                <a href="{{ route('staff.subscriptions.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-1"></i>{{ __('Add New Subscription') }}
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 overflow-visible">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">{{ __('Customer') }}</th>
                                <th class="border-0">{{ __('Plan') }}</th>
                                <th class="border-0 text-center">{{ __('Start Date') }}</th>
                                <th class="border-0 text-center">{{ __('End Date') }}</th>
                                <th class="border-0 text-center">{{ __('Status') }}</th>
                                <th class="border-0 text-center">{{ __('Days Left') }}</th>
                                <th class="border-0 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $subscription->customer->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $subscription->customer->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $subscription->plan->name ?? __('No Plan') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">
                                            {{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">
                                            {{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClasses = [
                                                'active' => 'bg-success-subtle text-success',
                                                'grace_period' => 'bg-warning-subtle text-warning',
                                                'expired' => 'bg-danger-subtle text-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusClasses[$subscription->status] ?? 'bg-secondary-subtle text-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-semibold {{ $subscription->days_remaining < 7 ? 'text-danger' : ($subscription->days_remaining < 30 ? 'text-warning' : 'text-success') }}">
                                            {{ $subscription->days_remaining > 0 ? $subscription->days_remaining : 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown_menu">
                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a href="{{ route('staff.subscriptions.show', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                                       class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="fas fa-eye"></i>{{ __('View Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('staff.subscriptions.edit', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                                       class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="fas fa-pencil-square"></i>{{ __('Edit Subscription') }}
                                                    </a>
                                                </li>
                                                @if($subscription->status === 'active')
                                                    <li>
                                                        <form action="{{ route('staff.subscriptions.renew', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-success">
                                                                <i class="fas fa-arrow-repeat"></i>{{ __('Renew') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('staff.subscriptions.cancel', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-warning">
                                                                <i class="fas fa-x-circle"></i>{{ __('Cancel') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($subscription->status === 'grace_period')
                                                    <li>
                                                        <form action="{{ route('staff.subscriptions.extend-grace', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-info">
                                                                <i class="fas fa-clock"></i>{{ __('Extend Grace') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center gap-2 text-danger" 
                                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $subscription->id }}">
                                                        <i class="fas fa-trash"></i>{{ __('Delete Subscription') }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-credit-card display-4 mb-3"></i>
                                            <h5>{{ __('No subscriptions found') }}</h5>
                                            <p>{{ __('Get started by creating your first subscription.') }}</p>
                                            <a href="{{ route('staff.subscriptions.create') }}" class="btn btn-success">
                                                <i class="fas fa-plus-circle me-1"></i>{{ __('Create Subscription') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($subscriptions->hasPages())
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-center">
                            {{ $subscriptions->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modals --}}
    @foreach($subscriptions as $subscription)
        <div class="modal fade" id="deleteModal{{ $subscription->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete Subscription') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this subscription? This action cannot be undone.') }}</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ __('This will also remove the plan assignment from the customer.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('staff.subscriptions.destroy', ['locale' => $uiLocale, 'subscription' => $subscription]) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection