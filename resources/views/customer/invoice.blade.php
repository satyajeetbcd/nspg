{{-- Customer Invoice View --}}
@extends('layouts.customer')

@section('breadcrumbs')
    @include('partials.customer.breadcrumbs', [
        'items' => [
            ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )],
            ['label' => __('Invoices'), 'url' => route('customer.invoices.index', app()->getLocale())],
            ['label' => __('Invoice') . ' #' . ($invoice->code ?? $invoice->id)],
        ]
    ])
@endsection
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ __('Invoice') }} #{{ $invoice->code }}</h4>
                <p class="text-muted mb-0">{{ __('View and download your invoice') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-primary">
                    <i class="fas fa-print me-2"></i>{{ __('Print') }}
                </button>
                <a href="{{ route('customer.subscription.billing', ) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Billing') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <!-- Invoice Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <h3 class="text-primary">{{ config('app.name', 'FERP Controller') }}</h3>
                    <p class="text-muted mb-1">Your Business Management Solution</p>
                    <p class="text-muted mb-0">support@ferpcontroller.com</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="mb-3">
                    <h5>{{ __('Invoice') }} #{{ $invoice->code }}</h5>
                    <p class="text-muted mb-1">{{ __('Date') }}: @userTime($invoice->created_at, 'M d, Y')</p>
                    <span class="badge bg-success">{{ __('Paid') }}</span>
                </div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">{{ __('Bill To') }}:</h6>
                <div class="border-start border-primary border-3 ps-3">
                    <p class="mb-1"><strong>{{ $customer->name }}</strong></p>
                    <p class="mb-1">{{ $customer->email }}</p>
                    @if($customer->primaryCompany)
                        <p class="mb-1">{{ $customer->primaryCompany->company_name }}</p>
                        @if($customer->primaryCompany->address)
                            <p class="mb-0 text-muted">{{ $customer->primaryCompany->address }}</p>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">{{ __('Payment Details') }}:</h6>
                <div class="border-start border-success border-3 ps-3">
                    <p class="mb-1">{{ __('Status') }}: <span class="badge bg-success">{{ __('Paid') }}</span></p>
                    <p class="mb-1">{{ __('Payment Date') }}: @userTime($invoice->created_at, 'M d, Y')</p>
                    <p class="mb-0">{{ __('Payment Method') }}: {{ __('Online Payment') }}</p>
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="table-responsive mb-4">
            <table class="table table-borderless">
                <thead class="bg-light">
                    <tr>
                        <th>{{ __('Description') }}</th>
                        <th class="text-center">{{ __('Duration') }}</th>
                        <th class="text-center">{{ __('Quantity') }}</th>
                        <th class="text-end">{{ __('Amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <h6 class="mb-1">{{ $invoice->plan->name ?? __('Subscription Plan') }}</h6>
                                <p class="text-muted mb-0">{{ $invoice->plan->description ?? __('Business management subscription') }}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ ucfirst($invoice->plan->duration ?? 'month') }}
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-end">
                            @if($invoice->currency)
                                {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                            @else
                                ${{ number_format($invoice->amount, 2) }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Invoice Totals -->
        <div class="row justify-content-end">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Subtotal') }}:</span>
                            <span>
                                @if($invoice->currency)
                                    {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                                @else
                                    ${{ number_format($invoice->amount, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Tax') }}:</span>
                            <span>
                                @if($invoice->currency)
                                    {{ $invoice->currency->getSymbol('en') }}0.00
                                @else
                                    $0.00
                                @endif
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>{{ __('Total') }}:</strong>
                            <strong>
                                @if($invoice->currency)
                                    {{ $invoice->currency->getSymbol('en') }}{{ number_format($invoice->amount, 2) }}
                                @else
                                    ${{ number_format($invoice->amount, 2) }}
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Footer -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="border-top pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>{{ __('Payment Terms') }}</h6>
                            <p class="text-muted mb-0">{{ __('Payment is due immediately upon receipt of this invoice.') }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6>{{ __('Thank You!') }}</h6>
                            <p class="text-muted mb-0">{{ __('Thank you for your business. We appreciate your trust in our services.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
@media print {
    .btn, nav, footer {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    body {
        background: white !important;
    }
}
</style>
@endpush
