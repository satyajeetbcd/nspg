{{-- Customer Invoice History --}}
@extends('layouts.customer')

@section('page-title', __('Invoice History'))
@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('Invoice History')],
        ]
    ])
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Invoice History') }}</h4>
                <p class="text-muted mb-0">{{ __('Complete history of all your invoices') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="exportInvoices()" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-2"></i>{{ __('Export') }}
                </button>
                <button onclick="printHistory()" class="btn btn-outline-primary">
                    <i class="fas fa-print me-2"></i>{{ __('Print') }}
                </button>
            </div>
        </div>
    </div>
</div>

@if($customer && $customer->invoices->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                <i class="fas fa-history me-2"></i>{{ __('All Invoices') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInvoices" placeholder="{{ __('Search invoices...') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="invoicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Invoice #') }}</th>
                                    <th>{{ __('Plan') }}</th>
                                    <th>{{ __('Issue Date') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->invoices->sortByDesc('created_at') as $invoice)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-invoice text-primary me-2"></i>
                                                <strong class="text-primary">#{{ $invoice->code ?? $invoice->id }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $invoice->plan->name ?? __('Unknown Plan') }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div>@userTime($invoice->created_at, 'M d, Y')</div>
                                                <small class="text-muted">@userTime($invoice->created_at, 'h:i A')</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div>@userTime($invoice->created_at->addDays(30), 'M d, Y')</div>
                                                <small class="text-muted">{{ __('30 days') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                @if($invoice->currency)
                                                    {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                                                @else
                                                    ${{ number_format($invoice->amount, 2) }}
                                                @endif
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : 'danger') }}">
                                                <i class="fas fa-{{ $invoice->status === 'paid' ? 'check-circle' : ($invoice->status === 'pending' ? 'clock' : 'times-circle') }} me-1"></i>
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('customer.invoices.show', [app()->getLocale(), $invoice->id]) }}"
                                                   class="btn btn-outline-primary" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-success" onclick="downloadInvoice({{ $invoice->id }})"
                                                        data-bs-toggle="tooltip" title="{{ __('Download') }}">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-outline-info" onclick="shareInvoice({{ $invoice->id }})"
                                                        data-bs-toggle="tooltip" title="{{ __('Share') }}">
                                                    <i class="fas fa-share"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-file-invoice fa-2x text-primary mb-2"></i>
                    <h4 class="text-primary">{{ $customer->invoices->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Total Invoices') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4 class="text-success">{{ $customer->invoices->where('status', 'paid')->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Paid Invoices') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4 class="text-warning">{{ $customer->invoices->where('status', 'pending')->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Pending Invoices') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-dollar-sign fa-2x text-info mb-2"></i>
                    <h4 class="text-info">
                        @php
                            $totalAmount = $customer->invoices->sum('amount');
                            $firstInvoice = $customer->invoices->first();
                        @endphp
                        @if($firstInvoice && $firstInvoice->currency)
                            {{ $firstInvoice->currency->getSymbol('en') }}{{ number_format($totalAmount, 2) }}
                        @else
                            ${{ number_format($totalAmount, 2) }}
                        @endif
                    </h4>
                    <p class="text-muted mb-0">{{ __('Total Amount') }}</p>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- No Invoices State -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-history fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">{{ __('No Invoice History') }}</h4>
                    <p class="text-muted mb-4">
                        {{ __('Your invoice history will appear here once you start using our services.') }}
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('customer.dashboard', ) }}"
                           class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}
                        </a>
                        <a href="{{ route('customer.subscription.index', ) }}"
                           class="btn btn-primary">
                            <i class="fas fa-credit-card me-2"></i>{{ __('View Plans') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function printHistory() {
        window.print();
    }

    function exportInvoices() {
        // Simulate export functionality
        const link = document.createElement('a');
        link.href = '#';
        link.download = 'invoice-history.csv';
        link.click();

        showToast('{{ __("Invoice history exported successfully") }}', 'success');
    }

    function viewInvoice(invoiceId) {
        // Create a modal to view invoice details
        const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
        document.getElementById('invoiceModalTitle').textContent = `{{ __('Invoice') }} #${invoiceId}`;
        document.getElementById('invoiceModalBody').innerHTML = `
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                <p>{{ __('Loading invoice details...') }}</p>
            </div>
        `;
        modal.show();

        // Simulate loading invoice details
        setTimeout(() => {
            document.getElementById('invoiceModalBody').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>{{ __('Invoice Details') }}</h6>
                        <p><strong>{{ __('Invoice Number') }}:</strong> #${invoiceId}</p>
                        <p><strong>{{ __('Plan') }}:</strong> {{ __('Basic Plan') }}</p>
                        <p><strong>{{ __('Amount') }}:</strong> $0.00</p>
                        <p><strong>{{ __('Status') }}:</strong> <span class="badge bg-success">{{ __('Paid') }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>{{ __('Payment Information') }}</h6>
                        <p><strong>{{ __('Payment Method') }}:</strong> {{ __('Manual') }}</p>
                        <p><strong>{{ __('Payment Date') }}:</strong> {{ date('M d, Y') }}</p>
                        <p><strong>{{ __('Transaction ID') }}:</strong> TXN-${invoiceId}</p>
                    </div>
                </div>
            `;
        }, 1000);
    }

    function downloadInvoice(invoiceId) {
        // Simulate invoice download
        const link = document.createElement('a');
        link.href = '#';
        link.download = `invoice-${invoiceId}.pdf`;
        link.click();

        showToast(`{{ __('Invoice #') }}${invoiceId} {{ __('download started') }}`, 'success');
    }

    function shareInvoice(invoiceId) {
        // Simulate sharing functionality
        if (navigator.share) {
            navigator.share({
                title: `{{ __('Invoice') }} #${invoiceId}`,
                text: `{{ __('Check out my invoice #') }}${invoiceId}`,
                url: window.location.href
            });
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(window.location.href);
            showToast('{{ __("Invoice link copied to clipboard") }}', 'info');
        }
    }

    function showToast(message, type = 'info') {
        const toast = new bootstrap.Toast(document.getElementById('toast'));
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toast').className = `toast position-fixed top-0 end-0 p-3 toast-${type}`;
        toast.show();
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInvoices');
        const table = document.getElementById('invoicesTable');
        const rows = table.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();

                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalTitle">{{ __('Invoice Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceModalBody">
                <!-- Invoice details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" onclick="downloadInvoice()">{{ __('Download PDF') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast position-fixed top-0 end-0 p-3" style="z-index: 9999" id="toast">
    <div class="toast-header">
        <i class="fas fa-info-circle text-primary me-2"></i>
        <strong class="me-auto">{{ __('Notification') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="toastMessage">
        {{ __('Message') }}
    </div>
</div>
