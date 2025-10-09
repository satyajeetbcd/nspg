{{-- Customer Invoice Details --}}
@extends('layouts.customer')

@section('page-title', __('Invoice Details'))
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Invoice Details') }}</h4>
                <p class="text-muted mb-0">{{ __('Invoice') }} #{{ $invoice->code ?? $invoice->id }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="printInvoice()" class="btn btn-outline-primary">
                    <i class="fas fa-print me-2"></i>{{ __('Print') }}
                </button>
                <button onclick="downloadInvoice()" class="btn btn-outline-success">
                    <i class="fas fa-download me-2"></i>{{ __('Download PDF') }}
                </button>
                <a href="{{ route('customer.invoices.index', app()->getLocale()) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Invoices') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-invoice me-2"></i>{{ __('Invoice Information') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Invoice Details') }}</h6>
                        <p><strong>{{ __('Invoice Number') }}:</strong> #{{ $invoice->code ?? $invoice->id }}</p>
                        <p><strong>{{ __('Issue Date') }}:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                        <p><strong>{{ __('Due Date') }}:</strong> {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : $invoice->created_at->addDays(30)->format('M d, Y') }}</p>
                        <p><strong>{{ __('Status') }}:</strong>
                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Plan Information') }}</h6>
                        @if($invoice->plan)
                            <p><strong>{{ __('Plan') }}:</strong> {{ $invoice->plan->name ?? 'Unknown Plan' }}</p>
                        @endif
                        @if($invoice->subscription)
                            <p><strong>{{ __('Subscription') }}:</strong> {{ $invoice->subscription->id }}</p>
                        @endif
                        @if($invoice->order)
                            <p><strong>{{ __('Order ID') }}:</strong> {{ $invoice->order->order_id }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($invoice->order)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>{{ __('Order Details') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('Order ID') }}:</strong> {{ $invoice->order->order_id }}</p>
                        <p><strong>{{ __('Order Type') }}:</strong> {{ $invoice->order->order_type_display }}</p>
                        <p><strong>{{ __('Payment Status') }}:</strong>
                            <span class="badge bg-{{ $invoice->order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $invoice->order->payment_status_display }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        @if($invoice->order->paid_at)
                            <p><strong>{{ __('Paid At') }}:</strong> {{ $invoice->order->paid_at->format('M d, Y h:i A') }}</p>
                        @endif
                        @if($invoice->order->payment_type)
                            <p><strong>{{ __('Payment Method') }}:</strong> {{ ucfirst($invoice->order->payment_type) }}</p>
                        @endif
                        @if($invoice->order->txn_id)
                            <p><strong>{{ __('Transaction ID') }}:</strong> {{ $invoice->order->txn_id }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-dollar-sign me-2"></i>{{ __('Amount Due') }}
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <h2 class="text-primary mb-0">
                        @if($invoice->currency)
                            {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                        @else
                            ${{ number_format($invoice->amount, 2) }}
                        @endif
                    </h2>
                    <p class="text-muted mb-0">{{ __('Total Amount') }}</p>
                </div>

                @if($invoice->status === 'pending')
                    <button class="btn btn-success btn-lg w-100 mb-2" onclick="payInvoice()">
                        <i class="fas fa-credit-card me-2"></i>{{ __('Pay Now') }}
                    </button>
                @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ __('This invoice has been paid') }}
                    </div>
                @endif

                <div class="mt-3">
                    <small class="text-muted">
                        {{ __('Payment is due by') }} {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : $invoice->created_at->addDays(30)->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>

        @if($invoice->company)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i>{{ __('Billing Information') }}
                </h5>
            </div>
            <div class="card-body">
                <p><strong>{{ $invoice->company->company_name }}</strong></p>
                @if($invoice->company->address)
                    <p class="mb-1">{{ $invoice->company->address }}</p>
                @endif
                @if($invoice->company->cr_number)
                    <p class="mb-1"><small class="text-muted">{{ __('CR Number') }}: {{ $invoice->company->cr_number }}</small></p>
                @endif
                @if($invoice->company->vat_number)
                    <p class="mb-0"><small class="text-muted">{{ __('VAT Number') }}: {{ $invoice->company->vat_number }}</small></p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function printInvoice() {
        window.print();
    }

    function downloadInvoice() {
        // TODO: Implement PDF generation and download
        showToast('{{ __("Invoice download feature coming soon") }}', 'info');
    }

    function payInvoice() {
        // TODO: Implement payment processing
        showToast('{{ __("Payment processing feature coming soon") }}', 'info');
    }

    function showToast(message, type = 'info') {
        const toast = new bootstrap.Toast(document.getElementById('toast'));
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toast').className = `toast position-fixed top-0 end-0 p-3 toast-${type}`;
        toast.show();
    }
</script>
@endpush

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
