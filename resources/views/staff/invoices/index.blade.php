@extends('staff.layouts.master')

@section('page-title', __('Invoice Manager'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-file-invoice me-1"></i>{{ __('Manage Invoices') }}
    </li>
@endsection

@section('content')

    {{-- KPI Summary --}}
    <div class="container mb-5">
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <!-- SVG "Total invoices" icon (uses currentColor so Bootstrap classes work) -->
                        <svg aria-hidden="true" focusable="false" class="display-4 text-primary mb-3"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64"
                            role="img">
                            <!-- outer document -->
                            <path fill="none" stroke="currentColor" stroke-width="2.5"
                                d="M12 4h28l12 12v36a4 4 0 0 1-4 4H12a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4z" />
                            <!-- folded corner -->
                            <path fill="none" stroke="currentColor" stroke-width="2.5" d="M40 4v12h12" />
                            <!-- lines (invoice lines) -->
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                d="M18 26h28M18 34h28M18 42h18" />
                            <!-- "Total" badge -->
                            <rect x="34" y="44" width="18" height="10" rx="2" ry="2"
                                fill="currentColor" />
                            <text x="43" y="51.5" fill="#fff" font-size="6.5" font-family="Arial,Helvetica,sans-serif"
                                font-weight="700" text-anchor="middle">TOT</text>
                        </svg>
                        <h6 class="fw-semibold text-muted">{{ __('Total Invoices') }}</h6>
                        <h3 class="fw-bold text-primary">{{ $invoices->total() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-clock-history display-4 text-warning mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Pending') }}</h6>
                        <h3 class="fw-bold text-warning">{{ $invoices->where('status', 'pending')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-check-circle display-4 text-success mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Paid') }}</h6>
                        <h3 class="fw-bold text-success">{{ $invoices->where('status', 'paid')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card kpi-card text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-currency-dollar display-4 text-info mb-3"></i>
                        <h6 class="fw-semibold text-muted">{{ __('Total Revenue') }}</h6>
                        <h3 class="fw-bold text-info">
                            {{ number_format($invoices->where('status', 'paid')->sum('amount'), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        {{-- Invoices Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-file-invoice me-2"></i>{{ __('Invoices List') }}
                </h5>
                <a href="{{ route('staff.invoices.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-1"></i>{{ __('Add New Invoice') }}
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">{{ __('Code') }}</th>
                                <th class="border-0">{{ __('Customer') }}</th>
                                <th class="border-0">{{ __('Plan') }}</th>
                                <th class="border-0 text-center">{{ __('Amount') }}</th>
                                <th class="border-0 text-center">{{ __('Status') }}</th>
                                <th class="border-0 text-center">{{ __('Due Date') }}</th>
                                <th class="border-0 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td>
                                        <span class="fw-semibold text-primary">#{{ $invoice->code }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $invoice->customer->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $invoice->customer->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $invoice->plan->name ?? __('No Plan') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-semibold">
                                            {{ number_format($invoice->amount, 2) }}
                                            {{ $invoice->currency->currencyLanguages->first()?->symbol ?? ($invoice->currency->getSymbol() ?? '$') }}
                                        </span>
                                    </td>
                                    <td class="text-center">

                                        <span
                                            class="badge {{ $statusClasses[$invoice->status] ?? 'bg-secondary-subtle text-secondary' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">
                                            @if ($invoice->due_date)
                                                @if (is_string($invoice->due_date))
                                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                                @else
                                                    {{ $invoice->due_date->format('M d, Y') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown_menu">
                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a href="{{ route('staff.invoices.show', ['locale' => $uiLocale, 'invoice' => $invoice]) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="fas fa-eye"></i>{{ __('View Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('staff.invoices.edit', ['locale' => $uiLocale, 'invoice' => $invoice]) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="fas fa-pencil-square"></i>{{ __('Edit Invoice') }}
                                                    </a>
                                                </li>
                                                @if ($invoice->status == 'pending')
                                                    <li>
                                                        <form
                                                            action="{{ route('staff.invoices.mark-paid', ['locale' => $uiLocale, 'invoice' => $invoice]) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-2 text-success">
                                                                <i
                                                                    class="fas fa-check-circle"></i>{{ __('Mark as Paid') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button
                                                        class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $invoice->id }}">
                                                        <i class="fas fa-trash"></i>{{ __('Delete Invoice') }}
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
                                            <svg aria-hidden="true" focusable="false" class="display-4 text-primary mb-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64"
                                                height="64" role="img">
                                                <!-- outer document -->
                                                <path fill="none" stroke="currentColor" stroke-width="2.5"
                                                    d="M12 4h28l12 12v36a4 4 0 0 6-4 4H12a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4z" />
                                                <!-- folded corner -->
                                                <path fill="none" stroke="currentColor" stroke-width="2.5"
                                                    d="M40 4v12h12" />
                                                <!-- lines (invoice lines) -->
                                                <path fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" d="M18 26h28M18 34h28M18 42h18" />
                                                <!-- "Total" badge -->
                                                <rect x="34" y="44" width="18" height="10" rx="2"
                                                    ry="2" fill="currentColor" />
                                                <text x="43" y="51.5" fill="#fff" font-size="6.5"
                                                    font-family="Arial,Helvetica,sans-serif" font-weight="700"
                                                    text-anchor="middle">TOT</text>
                                            </svg>
                                            <h5>{{ __('No invoices found') }}</h5>
                                            <p>{{ __('Get started by creating your first invoice.') }}</p>
                                            <a href="{{ route('staff.invoices.create') }}" class="btn btn-success">
                                                <i class="fas fa-plus-circle me-1"></i>{{ __('Create Invoice') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($invoices->hasPages())
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @include('partials.confirm-modal', [
        'id' => 'deleteModal',
        'title' => __('Delete Item'),
        'message' => __('Are you sure you want to delete this item?'),
        'confirmBtnId' => 'confirmDelete',
    ])

@endsection
