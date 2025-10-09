@extends('admin.layouts.app')

@section('title', 'View Calculator Setting')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">View Calculator Setting</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.calculator.index') }}">Calculator Settings</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Setting Details</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.calculator.edit', $calculator->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('admin.calculator.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Setting Key:</label>
                                <p class="form-control-plaintext">{{ $calculator->setting_key }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Setting Type:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-secondary">{{ $calculator->setting_type }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Setting Value:</label>
                        <div class="form-control-plaintext">
                            @if($calculator->setting_type == 'boolean')
                                <span class="badge bg-{{ $calculator->setting_value ? 'success' : 'danger' }}">
                                    {{ $calculator->setting_value ? 'Enabled' : 'Disabled' }}
                                </span>
                            @elseif($calculator->setting_type == 'json')
                                <pre class="bg-light p-3 rounded">{{ json_encode(json_decode($calculator->setting_value, true), JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <code>{{ $calculator->setting_value }}</code>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p class="form-control-plaintext">{{ $calculator->description ?? 'No description provided' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-{{ $calculator->is_active ? 'success' : 'danger' }}">
                                {{ $calculator->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created At:</label>
                                <p class="form-control-plaintext">{{ $calculator->created_at->format('M d, Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Updated At:</label>
                                <p class="form-control-plaintext">{{ $calculator->updated_at->format('M d, Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
