@extends('admin.layouts.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Reviews Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
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
                        <h5 class="card-title mb-0">All Reviews</h5>
                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Review
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Verified</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                {{ substr($review->customer_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $review->customer_name }}</div>
                                                @if($review->customer_location)
                                                <small class="text-muted">{{ $review->customer_location }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-1 fw-bold">{{ $review->rating }}/5</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="review-preview" style="max-width: 300px;">
                                            {{ Str::limit($review->review_text, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->service_type)
                                        <span class="badge bg-primary">{{ $review->service_type }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm toggle-status {{ $review->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                data-id="{{ $review->id }}"
                                                data-status="{{ $review->is_active }}">
                                            {{ $review->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm toggle-featured {{ $review->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                                                data-id="{{ $review->id }}"
                                                data-featured="{{ $review->is_featured }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm toggle-verified {{ $review->is_verified ? 'btn-success' : 'btn-outline-success' }}"
                                                data-id="{{ $review->id }}"
                                                data-verified="{{ $review->is_verified }}">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-comments fa-3x mb-3"></i>
                                            <p>No reviews found. <a href="{{ route('admin.reviews.create') }}">Add the first review</a></p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($reviews->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1E3A8A, #3B82F6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.9rem;
}

.review-preview {
    line-height: 1.4;
}

.rating {
    font-size: 0.9rem;
}

.toggle-status, .toggle-featured, .toggle-verified {
    transition: all 0.3s ease;
}

.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.id;
            const currentStatus = this.dataset.status === '1';
            
            fetch(`/admin/reviews/${reviewId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.status = data.is_active ? '1' : '0';
                    this.textContent = data.is_active ? 'Active' : 'Inactive';
                    this.className = `btn btn-sm toggle-status ${data.is_active ? 'btn-success' : 'btn-secondary'}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Toggle Featured
    document.querySelectorAll('.toggle-featured').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.id;
            const currentFeatured = this.dataset.featured === '1';
            
            fetch(`/admin/reviews/${reviewId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.featured = data.is_featured ? '1' : '0';
                    this.className = `btn btn-sm toggle-featured ${data.is_featured ? 'btn-warning' : 'btn-outline-warning'}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Toggle Verified
    document.querySelectorAll('.toggle-verified').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.id;
            const currentVerified = this.dataset.verified === '1';
            
            fetch(`/admin/reviews/${reviewId}/toggle-verified`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.verified = data.is_verified ? '1' : '0';
                    this.className = `btn btn-sm toggle-verified ${data.is_verified ? 'btn-success' : 'btn-outline-success'}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endpush
