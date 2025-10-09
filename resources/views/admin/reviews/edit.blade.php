@extends('admin.layouts.app')

@section('title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Review</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Review Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Customer Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" name="customer_name" value="{{ old('customer_name', $review->customer_name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_location" class="form-label">Customer Location</label>
                                <input type="text" class="form-control @error('customer_location') is-invalid @enderror" 
                                       id="customer_location" name="customer_location" value="{{ old('customer_location', $review->customer_location) }}">
                                @error('customer_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rating" class="form-label">Rating *</label>
                                <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>5 Stars - Excellent</option>
                                    <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>4 Stars - Very Good</option>
                                    <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>3 Stars - Good</option>
                                    <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>2 Stars - Fair</option>
                                    <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>1 Star - Poor</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service_type" class="form-label">Service Type</label>
                                <select class="form-select @error('service_type') is-invalid @enderror" id="service_type" name="service_type">
                                    <option value="">Select Service</option>
                                    <option value="EPC" {{ old('service_type', $review->service_type) == 'EPC' ? 'selected' : '' }}>EPC Services</option>
                                    <option value="Finance" {{ old('service_type', $review->service_type) == 'Finance' ? 'selected' : '' }}>Solar Finance</option>
                                    <option value="O&M" {{ old('service_type', $review->service_type) == 'O&M' ? 'selected' : '' }}>Operations & Maintenance</option>
                                    <option value="Rooftop" {{ old('service_type', $review->service_type) == 'Rooftop' ? 'selected' : '' }}>Rooftop Solar</option>
                                    <option value="Ground" {{ old('service_type', $review->service_type) == 'Ground' ? 'selected' : '' }}>Ground-Mounted Solar</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_name" class="form-label">Project/Company Name</label>
                                <input type="text" class="form-control @error('project_name') is-invalid @enderror" 
                                       id="project_name" name="project_name" value="{{ old('project_name', $review->project_name) }}">
                                @error('project_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="project_location" class="form-label">Project Location</label>
                                <input type="text" class="form-control @error('project_location') is-invalid @enderror" 
                                       id="project_location" name="project_location" value="{{ old('project_location', $review->project_location) }}">
                                @error('project_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="review_text" class="form-label">Review Text *</label>
                            <textarea class="form-control @error('review_text') is-invalid @enderror" 
                                      id="review_text" name="review_text" rows="4" required>{{ old('review_text', $review->review_text) }}</textarea>
                            <div class="form-text">Maximum 1000 characters</div>
                            @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="review_source" class="form-label">Review Source</label>
                                <select class="form-select @error('review_source') is-invalid @enderror" id="review_source" name="review_source">
                                    <option value="website" {{ old('review_source', $review->review_source) == 'website' ? 'selected' : '' }}>Website</option>
                                    <option value="google" {{ old('review_source', $review->review_source) == 'google' ? 'selected' : '' }}>Google</option>
                                    <option value="facebook" {{ old('review_source', $review->review_source) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="other" {{ old('review_source', $review->review_source) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('review_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="external_id" class="form-label">External ID</label>
                                <input type="text" class="form-control @error('external_id') is-invalid @enderror" 
                                       id="external_id" name="external_id" value="{{ old('external_id', $review->external_id) }}">
                                <div class="form-text">For external review platform IDs</div>
                                @error('external_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           {{ old('is_active', $review->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Show on website)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                           {{ old('is_featured', $review->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured (Show in testimonials section)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" 
                                           {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_verified">
                                        Verified Customer
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for review text
    const reviewText = document.getElementById('review_text');
    const maxLength = 1000;
    
    reviewText.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        const formText = this.nextElementSibling;
        
        if (remaining < 100) {
            formText.textContent = `${remaining} characters remaining`;
            formText.className = 'form-text text-warning';
        } else {
            formText.textContent = 'Maximum 1000 characters';
            formText.className = 'form-text';
        }
    });
});
</script>
@endpush
