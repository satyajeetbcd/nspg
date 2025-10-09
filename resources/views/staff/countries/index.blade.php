{{--
    File: resources/views/dashboard/country-manager.blade.php
    Description: Staff Panel - country Management Dashboard
    Author: Your Name
    Created: 2025-09-17
    Layout: layouts.staff
--}}

@extends('staff.layouts.master')

@section('page-title', __('Country Management'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-circle me-1"></i>{{ __('Countries') }}
    </li>
@endsection

{{-- Page Title --}}
@section('page-title', __('country Manager'))

@section('content')
    <div class="container">

        {{-- =========================
         Breadcrumb Navigation
         Description: Shows current page hierarchy and link to Dashboard
    ========================== --}}
        <div class="row mb-4">
            <div class="col-12">
                <nav class="breadcrumb-glass text-white rounded px-4 py-3 d-flex align-items-center justify-content-between">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item text-white">
                            <a href="{{ route('redirect') }}" class="text-white">
                                <i class="fas fa-house-door-fill me-1"></i> {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">
                            <i class="fas fa-person-badge-fill me-1"></i> {{ __('Manage country') }}
                        </li>
                    </ol>

                    <h5 class="mb-0 text-white">
                        <i class="fas fa-speedometer2 me-2 "></i>{{ __('Super Admin Panel') }}
                    </h5>
                </nav>
            </div>
        </div>

        {{-- =========================
         KPI Summary Cards
         Description: Shows key metrics like Total Countries, Active/Inactive subscriptions, etc.
    ========================== --}}
        {{-- <div class="row g-3 mb-4">
            <div class="col-md-2 col-sm-6">
                <div class="card text-center p-3 bg-primary text-white shadow-sm rounded-3">
                    <h6>{{ __('Total Countries') }}</h6>
                    <h3>{{ $Countries->count() }}</h3>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="card text-center p-3 bg-success text-white shadow-sm rounded-3">
                    <h6>{{ __('Countries Usage') }}</h6>
                    <h3>{{ $Countries->where('is_active', true)->count() }}</h3>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="card text-center p-3 bg-danger text-white shadow-sm rounded-3">
                    <h6>{{ __('Countries Not Available') }}</h6>
                    <h3>{{ $Countries->where('is_active', false)->count() }}</h3>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="card text-center p-3 bg-secondary text-white shadow-sm rounded-3">
                    <h6>{{ __('Countries Available') }}</h6>
                    <h3>{{ $countrys->where('is_active', false)->count() }}</h3>
                </div>
            </div>
        </div> --}}

        {{-- =========================
         Countries Table
         Description: List all Countries with options to view, edit, activate/deactivate, and delete
    ========================== --}}
        <div class="row position-relative">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ __('Countries List') }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.countries.export', ['locale' => $uiLocale]) }}"
                            class="btn btn-outline-success">
                            <i class="fas fa-download me-1"></i> {{ __('Export') }}
                        </a>
                        <a href="{{ route('staff.countries.create', ['locale' => $uiLocale]) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('Create country') }}
                        </a>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">{{ __('Countries') }}</h5>
                    </div>
                    <div class="card-body p-3">

                        <div class="table-responsive text-center  ">
                            <table id="Countries-table"
                                class="table datatable   text-center table-hover mb-0 rounded-3 overflow-visible" data-search-name="Search Countries">
                                <thead class="table-light  text-center">
                                    <tr>
                                        <th>#</th>
                                        <th >{{ __('Name') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th >{{ __('Currency') }}</th>
                                        <th >{{ __('Created At') }}</th>
                                        <th >{{ __('Actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($countries as $index => $country)
                                        <tr class="text-lefy">
                                            {{-- Iteration Number --}}
                                            <td>{{ $loop->iteration }}</td>

                                            {{-- country Name --}}
                                            <td>
                                                <a href="#" class="text-primary"
                                                    data-url="{{ route('staff.countries.edit', ['locale' => $uiLocale, 'country' => $country->id]) }}"
                                                    data-ajax-popup="true" data-title="{{ __('Edit country') }}"
                                                    data-size="lm" title="{{ __('Edit') }}">
                                                    <i class="fas fa-pencil-square"></i>
                                                    {{ $country->name }}
                                                </a>
                                            </td>

                                            {{-- country Code --}}
                                            <td>
                                                <span class="badge bg-info-subtle text-info">
                                                    {{ $country->code }}
                                                </span>
                                            </td>
                
                                            
                                            {{-- country Currency --}}
                                            <td>{{ $country->primaryCurrency() ?? 'N/A' }}</td>
                                            
                                            {{-- country Created At --}}
                                            <td>{{ $country->created_at ?? 'N/A' }}</td>
                                            
                                            {{-- Action Dropdown --}}
                                            <td>
                                                <div class="dropdown_menu">
                                                    <button class="btn btn-light btn-sm border shadow-sm" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        {{-- View --}}
                                                        <li>
                                                            <a href="{{ route('staff.countries.show', ['locale' => $uiLocale, 'country' => $country->id]) }}"
                                                                class="dropdown-item">
                                                                <i class="fas fa-eye me-2 text-primary"></i>
                                                                {{ __('View') }}
                                                            </a>
                                                        </li>

                                                        {{-- Edit --}}
                                                        <li>
                                                            <a href="#" class="dropdown-item"
                                                                data-url="{{ route('staff.countries.edit', ['locale' => $uiLocale, 'country' => $country->id]) }}"
                                                                data-ajax-popup="true"
                                                                data-title="{{ __('Edit Country') }}" data-size="lg">
                                                                <i class="fas fa-pencil-square me-2 text-warning"></i>
                                                                {{ __('Edit') }}
                                                            </a>
                                                        </li>

                                                        {{-- Delete --}}
                                                        <li>
                                                            <button class="dropdown-item text-danger itemDelete"
                                                                data-item_id="{{ $country->id }}" data-name="Country"
                                                                data-url="{{ route('staff.countries.destroy', ['locale' => $uiLocale, 'country' => $country->id]) }}"
                                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                                <i class="fas fa-trash me-2"></i> {{ __('Delete') }}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- Empty State --}}
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                {{ __('No Countries found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>


                            {{-- Pagination --}}
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $countries->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Delete Confirmation Modal --}}
        @include('partials.confirm-modal', [
            'id' => 'deleteModal',
            'title' => __('Delete Country'),
            'message' => __('Are you sure you want to delete this Country'),
            'name' => __('Country'),
            'confirmBtnId' => 'confirmDelete',
        ])

    @endsection
