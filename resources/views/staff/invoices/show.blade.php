@extends('staff.layouts.master')

@section('page-title')
    {{ __('Invoice') }} #{{ $invoice->code }}
@endsection

@section('content')
    {{-- Breadcrumb is now handled in the header --}}

    {{-- Invoice Details --}}
    <div class="container mt-4">
        <div class="row">
            {{-- Invoice Information --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-file-invoice me-2"></i>{{ __('Invoice Information') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.invoices.edit', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit') }}
                            </a>
                            @if($invoice->status == 'pending')
                                <form action="{{ route('staff.invoices.mark-paid', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('Mark as Paid') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Invoice Code') }}</label>
                                <div class="fw-bold text-primary">#{{ $invoice->code }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Status') }}</label>
                                <div>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning-subtle text-warning',
                                            'paid' => 'bg-success-subtle text-success',
                                            'cancelled' => 'bg-danger-subtle text-danger',
                                            'refunded' => 'bg-info-subtle text-info'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClasses[$invoice->status] ?? 'bg-secondary-subtle text-secondary' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Customer') }}</label>
                                <div>
                                    <div class="fw-semibold">{{ $invoice->customer->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $invoice->customer->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Plan') }}</label>
                                <div>
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $invoice->plan->name ?? __('No Plan') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Amount') }}</label>
                                <div class="fw-bold text-success fs-5">
                                    {{ number_format($invoice->amount, 2) }}
                                    {{ $invoice->currency->currencyLanguages->first()?->symbol ?? $invoice->currency->getSymbol() ?? '$' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Due Date') }}</label>
                                <div class="fw-semibold">
                                    @if($invoice->due_date)
                                        @if(is_string($invoice->due_date))
                                            {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                        @else
                                            {{ $invoice->due_date->format('M d, Y') }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div>{{ $invoice->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Last Updated') }}</label>
                                <div>{{ $invoice->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions Panel --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-gear me-2"></i>{{ __('Actions') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('staff.invoices.edit', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-pencil-square me-1"></i>{{ __('Edit Invoice') }}
                            </a>
                            
                            @if($invoice->status == 'pending')
                                <form action="{{ route('staff.invoices.mark-paid', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('Mark as Paid') }}
                                    </button>
                                </form>
                            @endif

                            @if($invoice->status == 'paid')
                                <form action="{{ route('staff.invoices.mark-pending', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-clock me-1"></i>{{ __('Mark as Pending') }}
                                    </button>
                                </form>
                            @endif

                            <button class="btn btn-outline-info" onclick="window.print()">
                                <i class="fas fa-printer me-1"></i>{{ __('Print Invoice') }}
                            </button>

                            <button class="btn btn-outline-secondary" onclick="downloadInvoice()">
                                <i class="fas fa-download me-1"></i>{{ __('Download PDF') }}
                            </button>

                            <button class="btn btn-outline-primary" onclick="sendEmail()">
                                <i class="fas fa-envelope me-1"></i>{{ __('Send Email') }}
                            </button>

                            <hr>

                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>{{ __('Delete Invoice') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Status History --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-clock-history me-2"></i>{{ __('Status History') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold">{{ __('Invoice Created') }}</h6>
                                    <small class="text-muted">{{ $invoice->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>
                            @if($invoice->updated_at != $invoice->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-semibold">{{ __('Last Updated') }}</h6>
                                        <small class="text-muted">{{ $invoice->updated_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete Invoice') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this invoice? This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('staff.invoices.destroy', ['locale' => $uiLocale, 'invoice' => $invoice]) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadInvoice() {
            // TODO: Implement PDF download
            alert('PDF download functionality will be implemented soon.');
        }

        function sendEmail() {
            // TODO: Implement email sending
            alert('Email sending functionality will be implemented soon.');
        }
    </script>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -35px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .timeline-content h6 {
            margin-bottom: 5px;
        }
    </style>
@endsection
