@extends('layouts.app')

@section('title')
    Zodiac Transactions
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTable.min.css') }}"/>
@endsection

<style>
/* Custom CSS for better layout */
.page-title-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
}

.page-title-box h4 {
    margin: 0;
    font-weight: 600;
}

.breadcrumb {
    background: transparent;
    margin: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

.card-title {
    margin: 0;
    font-weight: 600;
    color: #495057;
}

.table th {
    background: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.modal-content {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.table-sm td, .table-sm th {
    padding: 0.5rem;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .page-title-box {
        padding: 1rem;
    }
    
    .card-tools {
        margin-top: 1rem;
        text-align: center;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}

/* Additional layout improvements */
.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
}

.table th {
    position: sticky;
    top: 0;
    z-index: 10;
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
}

.badge-primary {
    background-color: #007bff !important;
    color: white !important;
}

.badge-success {
    background-color: #28a745 !important;
    color: white !important;
}

.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge-danger {
    background-color: #dc3545 !important;
    color: white !important;
}

.badge-secondary {
    background-color: #6c757d !important;
    color: white !important;
}

.badge-info {
    background-color: #17a2b8 !important;
    color: white !important;
}

/* Modal improvements */
.modal-dialog {
    max-width: 800px;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #dee2e6;
}

/* Button improvements */
.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
}

/* Empty state improvements */
.text-center.py-5 {
    padding: 3rem 1rem !important;
}

.fa-3x {
    font-size: 3rem;
    color: #6c757d;
}

/* Filter styles */
.filter-container {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.filter-container .form-group {
    margin-bottom: 0.5rem;
}

.filter-container label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

.filter-container .form-control {
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

.filter-container .btn {
    border-radius: 0.25rem;
}
</style>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Zodiac Transactions</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.zodiac.dashboard') }}">Zodiac System</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Transactions</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.zodiac.dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="filter-container">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="paymentStatusFilter">Payment Status</label>
                                    <select id="paymentStatusFilter" class="form-control">
                                        <option value="all">All Statuses</option>
                                        @foreach($paymentStatuses as $key => $status)
                                            <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="zodiacSignFilter">Zodiac Sign</label>
                                    <select id="zodiacSignFilter" class="form-control">
                                        <option value="all">All Signs</option>
                                        @foreach($zodiacSigns as $key => $sign)
                                            <option value="{{ $key }}">{{ $sign }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dateFromFilter">Date From</label>
                                    <input type="date" id="dateFromFilter" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dateToFilter">Date To</label>
                                    <input type="date" id="dateToFilter" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="applyFilters" class="btn btn-primary btn-block">
                                        <i class="fa fa-filter me-1"></i> Apply Filters
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="clearFilters" class="btn btn-secondary btn-block">
                                        <i class="fa fa-times me-1"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="transactionsTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Zodiac Sign</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Payment Gateway</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
    <script type="text/javascript" src="{{ asset('js/dataTable.min.js') }}"></script>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/zodiac/transactions.js') }}"></script>
@endsection
