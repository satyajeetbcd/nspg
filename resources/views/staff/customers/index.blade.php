{{--
    File: resources/views/dashboard/customer-manager.blade.php
    Description: Staff Panel - Customer Management Dashboard
    Author: Your Name
    Created: 2025-09-17
    Layout: layouts.staff
--}}

@extends('staff.layouts.master')

{{-- Page Title --}}
@section('page-title', __('Customer Manager'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-users me-1"></i>{{ __('Manage Customers') }}
    </li>
@endsection

@section('content')
<div class="container">

    {{-- Breadcrumb is now handled in the header --}}

    {{-- =========================
         KPI Summary Cards
         Description: Shows key metrics like Total Customers, Active/Inactive subscriptions, etc.
    ========================== --}}
    <div class="row g-3 mb-4 d-flex justify-content-center ">
        <div class="col-md-2 col-sm-6">
            <div class="card text-center p-3 bg-primary text-white shadow-sm rounded-3">
                <h6>{{ __('Total Customers') }}</h6>
                <h3>{{ $customers->count() }}</h3>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card text-center p-3 bg-success text-white shadow-sm rounded-3">
                <h6>{{ __('Subscriptions') }}</h6>
                <h3>{{ $customers->where('is_active', true)->count() }}</h3>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card text-center p-3 bg-danger text-white shadow-sm rounded-3">
                <h6>{{ __('None Subscriptions') }}</h6>
                <h3>{{ $customers->where('is_active', false)->count() }}</h3>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card text-center p-3 bg-secondary text-white shadow-sm rounded-3">
                <h6>{{ __('Customers Renewal') }}</h6>
                <h3>{{ $customers->where('is_active', false)->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- =========================
         Customers Table
         Description: List all customers with options to view, edit, activate/deactivate, and delete
    ========================== --}}
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">{{ __('Customers List') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('staff.customers.export', ['locale' => $uiLocale]) }}" 
                       class="btn btn-outline-success">
                        <i class="fas fa-download me-1"></i> {{ __('Export') }}
                    </a>
                    <a href="{{ route('staff.customers.create', ['locale' => $uiLocale]) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> {{ __('Create Customer') }}
                    </a>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-light rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold text-white">{{ __('Customers') }}</h5>
            </div>
            <div class="card-body p-3">

            <div class="table-responsive overflow-visible ">
                <table id="customers-table" class="table datatable align-middle table-hover mb-0 rounded-3 overflow-visible">
                    <thead class="table">
                        <tr>
                            <th>#</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Plan') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $index => $customer)
                            <tr>
                                {{-- Iteration Number --}}
                                <td>{{ $loop->iteration }}</td>

                                {{-- Customer Name --}}
                                <td>
                                    <a href="#" class="text-primary"
                                       data-url="{{ route('staff.customers.edit', ['locale' => $uiLocale, 'customer' => $customer->id]) }}"
                                       data-ajax-popup="true" data-title="{{ __('Edit Customer') }}" data-size="lg"
                                       title="{{ __('Edit') }}">
                                       <i class="fas fa-pencil-square"></i> {{ $customer->name ?? 'N/A' }}
                                    </a>
                                </td>

                                {{-- Customer Email --}}
                                <td>{{ $customer->email ?? 'N/A' }}</td>

                                {{-- Customer Plan --}}
                                <td>
                                    @php
                                        $customerPlan = $customer->plan()->first();
                                    @endphp
                                    @if($customerPlan)
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $customerPlan->name ?? 'Plan #' . $customerPlan->id }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ __('No Plan') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Customer Status Badge --}}
                                <td>
                                    <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $customer->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>

                                {{-- Customer Phone --}}
                                <td>{{ $customer->phone ?? 'N/A' }}</td>

                                {{-- Created At --}}
                                <td>{{ $customer->created_at->format('Y-m-d') }}</td>

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
                                                <a href="{{ route('staff.customers.show', ['locale' => $uiLocale, 'customer' => $customer->id]) }}"
                                                   class="dropdown-item">
                                                    <i class="fas fa-eye me-2 text-primary"></i> {{ __('View') }}
                                                </a>
                                            </li>

                                            {{-- Edit --}}
                                            <li>
                                                <a href="#" class="dropdown-item"
                                                   data-url="{{ route('staff.customers.edit', ['locale' => $uiLocale, 'customer' => $customer->id]) }}"
                                                   data-ajax-popup="true" data-title="{{ __('Edit Customer') }}"
                                                   data-size="lg">
                                                    <i class="fas fa-pencil-square me-2 text-warning"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                            </li>

                                            {{-- Plan Assignment --}}
                                            <li>
                                                <a href="{{ route('staff.customers.assign-plan', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" 
                                                   class="dropdown-item">
                                                    <i class="fas fa-package me-2 text-info"></i>
                                                    {{ __('Assign Plan') }}
                                                </a>
                                            </li>

                                            {{-- Status Toggle --}}
                                            <li>
                                                @if($customer->is_active)
                                                    <form action="{{ route('staff.customers.deactivate', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-slash-circle text-danger me-2"></i>
                                                            {{ __('Deactivate') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('staff.customers.activate', ['locale' => $uiLocale, 'customer' => $customer->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            {{ __('Activate') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </li>

                                            {{-- Delete --}}
                                            <li>
                                                <button class="dropdown-item text-danger itemDelete"
                                                        data-item_id="{{ $customer->id }}"
                                                        data-url="{{ route('staff.customers.destroy', ['locale' => $uiLocale, 'customer' => $customer->id]) }}"
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
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">{{ __('No customers found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $customers->links('pagination::bootstrap-5') }}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables for customers table
    if ($.fn.DataTable && $('#customers-table').length) {
        try {
            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#customers-table')) {
                $('#customers-table').DataTable().destroy();
            }
            
            // Initialize DataTable
            $('#customers-table').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: -1 } // Disable ordering on action column
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    },
                    emptyTable: "No customers found"
                }
            });
        } catch (error) {
            console.error('DataTables initialization error:', error);
        }
    }
});
</script>
@endpush
