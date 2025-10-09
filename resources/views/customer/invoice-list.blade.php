{{-- Customer Invoice List --}}
@extends('layouts.customer')

@section('page-title', __('Invoices'))
@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('Invoices')],
        ]
    ])
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('My Invoices') }}</h4>
                <p class="text-muted mb-0">{{ __('View and manage your invoices') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.invoices.history', app()->getLocale()) }}" class="btn btn-outline-primary">
                    <i class="fas fa-history me-2"></i>{{ __('View History') }}
                </a>
            </div>
        </div>
    </div>
</div>

@if($customer && $customer->invoices->count() > 0)
    <div class="row">
        @foreach($customer->invoices->sortByDesc('created_at') as $invoice)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-file-invoice text-primary me-2"></i>
                            {{ __('Invoice') }} #{{ $invoice->code ?? $invoice->id }}
                        </h6>
                        <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">{{ __('Plan') }}</h6>
                            <p class="mb-0">{{ $invoice->plan->name ?? __('Unknown Plan') }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">{{ __('Amount') }}</h6>
                            <h5 class="text-primary mb-0">
                                @if($invoice->currency)
                                    {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                                @else
                                    ${{ number_format($invoice->amount, 2) }}
                                @endif
                            </h5>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">{{ __('Date') }}</h6>
                            <p class="mb-0">@userTime($invoice->created_at, 'M d, Y')</p>
                        </div>

                        @if($invoice->due_date)
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">{{ __('Due Date') }}</h6>
                                <p class="mb-0">@userTime($invoice->due_date, 'M d, Y')</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('customer.invoices.show', [app()->getLocale(), $invoice->id]) }}"
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>{{ __('View') }}
                            </a>
                            @if($invoice->status === 'pending')
                                <button class="btn btn-success btn-sm flex-fill" onclick="payInvoice({{ $invoice->id }})">
                                    <i class="fas fa-credit-card me-1"></i>{{ __('Pay') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
                        <i class="fas fa-file-invoice fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">{{ __('No Invoices Found') }}</h4>
                    <p class="text-muted mb-4">
                        {{ __('You don\'t have any invoices yet. Invoices will appear here once you make a purchase.') }}
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('customer.dashboard', app()->getLocale()) }}"
                           class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}
                        </a>
                        <a href="{{ route('customer.subscription.index', app()->getLocale()) }}"
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
    function payInvoice(invoiceId) {
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
