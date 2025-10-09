@extends('admin.layouts.app')

@section('title', 'View Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">View Review</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Review Details</h5>
                        <div class="btn-group">
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="review-details">
                                <!-- Customer Information -->
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Customer Information</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <strong>Name:</strong> {{ $review->customer_name }}
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Location:</strong> {{ $review->customer_location ?? 'Not specified' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Content -->
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Review Content</h6>
                                    <div class="rating-display mb-2">
                                        <strong>Rating:</strong>
                                        <div class="stars d-inline-block ms-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>
                                    <div class="review-text">
                                        <strong>Review:</strong>
                                        <p class="mt-2 p-3 bg-light rounded">{{ $review->review_text }}</p>
                                    </div>
                                </div>

                                <!-- Project Information -->
                                @if($review->project_name || $review->project_location)
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Project Information</h6>
                                    <div class="row">
                                        @if($review->project_name)
                                        <div class="col-sm-6">
                                            <strong>Project/Company Name:</strong> {{ $review->project_name }}
                                        </div>
                                        @endif
                                        @if($review->project_location)
                                        <div class="col-sm-6">
                                            <strong>Project Location:</strong> {{ $review->project_location }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- Service Information -->
                                @if($review->service_type)
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Service Information</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <strong>Service Type:</strong> 
                                            <span class="badge bg-primary">{{ $review->service_type }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="review-meta">
                                <!-- Status Information -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Status Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Active:</span>
                                            <span class="badge {{ $review->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $review->is_active ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Featured:</span>
                                            <span class="badge {{ $review->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                                {{ $review->is_featured ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Verified:</span>
                                            <span class="badge {{ $review->is_verified ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $review->is_verified ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Source -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Review Source</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Source:</strong> 
                                            <span class="badge bg-info">{{ ucfirst($review->review_source) }}</span>
                                        </div>
                                        @if($review->external_id)
                                        <div>
                                            <strong>External ID:</strong> {{ $review->external_id }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Timestamps -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Timestamps</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Created:</strong><br>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y \a\t g:i A') }}</small>
                                        </div>
                                        <div>
                                            <strong>Updated:</strong><br>
                                            <small class="text-muted">{{ $review->updated_at->format('M d, Y \a\t g:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
.review-details h6 {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 8px;
}

.rating-display .stars {
    font-size: 1.2rem;
}

.review-text p {
    line-height: 1.6;
    margin-bottom: 0;
}

.review-meta .card {
    border: 1px solid #e9ecef;
}

.review-meta .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.review-meta .card-body {
    padding: 1rem;
}
</style>
@endpush
