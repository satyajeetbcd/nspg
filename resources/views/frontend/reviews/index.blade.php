@extends('frontend.layouts.app')

@section('title', 'Customer Reviews - NSPG')

@section('content')
<!-- Reviews Hero Section -->
<section class="reviews-hero py-5" style="background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Customer Reviews</h1>
                <p class="lead mb-4">See what our satisfied customers say about NSPG's solar solutions</p>
                
                <!-- Overall Rating -->
                <div class="d-flex align-items-center mb-4">
                    <div class="rating-display me-3">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($stats['average_rating']))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $stats['average_rating'])
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="ms-2 fs-4 fw-bold">{{ $stats['average_rating'] }}/5</span>
                    </div>
                    <div class="review-count">
                        <span class="fs-5">Based on {{ $stats['total_reviews'] }} reviews</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="review-stats-card bg-white text-dark p-4 rounded-3 shadow">
                    <h3 class="text-primary mb-3">EXCELLENT</h3>
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="stars me-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                        <span class="fw-bold">{{ $stats['total_reviews'] }} reviews</span>
                    </div>
                    <div class="google-logo">
                        <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="Google" height="20">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rating Breakdown -->
<section class="rating-breakdown py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-4">Rating Distribution</h3>
                @foreach($stats['rating_counts'] as $ratingCount)
                <div class="rating-bar mb-3">
                    <div class="d-flex align-items-center">
                        <span class="me-2 fw-bold">{{ $ratingCount->rating }}★</span>
                        <div class="progress flex-grow-1 me-2" style="height: 20px;">
                            <div class="progress-bar bg-warning" 
                                 style="width: {{ ($ratingCount->count / $stats['total_reviews']) * 100 }}%"></div>
                        </div>
                        <span class="text-muted">{{ $ratingCount->count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Submit Your Review</h5>
                        <p class="card-text">Share your experience with NSPG</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Write a Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Grid -->
<section class="reviews-grid py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Customer Reviews</h3>
                    <div class="filter-controls">
                        <select class="form-select me-2" id="ratingFilter">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                        <select class="form-select" id="serviceFilter">
                            <option value="">All Services</option>
                            <option value="EPC">EPC Services</option>
                            <option value="Finance">Solar Finance</option>
                            <option value="O&M">Operations & Maintenance</option>
                            <option value="Rooftop">Rooftop Solar</option>
                            <option value="Ground">Ground-Mounted Solar</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" id="reviewsContainer">
            @foreach($reviews as $review)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="review-card card h-100 {{ $review->is_featured ? 'featured' : '' }}">
                    <div class="card-body">
                        @if($review->is_featured)
                        <div class="featured-badge">
                            <i class="fas fa-star"></i> Featured
                        </div>
                        @endif
                        
                        <div class="review-header mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="customer-avatar me-3">
                                    <div class="avatar-circle">
                                        {{ substr($review->name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $review->name }}</h6>
                                    @if($review->location)
                                    <small class="text-muted">{{ $review->location }}</small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            
                            @if($review->project_name)
                            <div class="project-info">
                                <small class="text-primary fw-bold">{{ $review->project_name }}</small>
                                @if($review->project_location)
                                <br><small class="text-muted">{{ $review->project_location }}</small>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <div class="review-content">
                            <p class="review-text">{{ $review->review }}</p>
                        </div>
                        
                        @if($review->service_type)
                        <div class="service-tag">
                            <span class="badge bg-primary">{{ $review->service_type }}</span>
                        </div>
                        @endif
                        
                        @if($review->is_verified)
                        <div class="verified-badge mt-2">
                            <i class="fas fa-check-circle text-success"></i> Verified Customer
                        </div>
                        @endif
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">
                            {{ $review->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Load More Button -->
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-outline-primary" id="loadMoreBtn" style="display: none;">
                    Load More Reviews
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Your Name *</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="customer_location" name="customer_location">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Service Type</label>
                            <select class="form-select" id="service_type" name="service_type">
                                <option value="">Select Service</option>
                                <option value="EPC">EPC Services</option>
                                <option value="Finance">Solar Finance</option>
                                <option value="O&M">Operations & Maintenance</option>
                                <option value="Rooftop">Rooftop Solar</option>
                                <option value="Ground">Ground-Mounted Solar</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rating" class="form-label">Rating *</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="">Select Rating</option>
                                <option value="5">5 Stars - Excellent</option>
                                <option value="4">4 Stars - Very Good</option>
                                <option value="3">3 Stars - Good</option>
                                <option value="2">2 Stars - Fair</option>
                                <option value="1">1 Star - Poor</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="project_name" class="form-label">Project/Company Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="project_location" class="form-label">Project Location</label>
                            <input type="text" class="form-control" id="project_location" name="project_location">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="review_text" class="form-label">Your Review *</label>
                        <textarea class="form-control" id="review_text" name="review_text" rows="4" 
                                  placeholder="Share your experience with NSPG..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.reviews-hero {
    padding: 80px 0;
}

.rating-display .stars {
    font-size: 1.5rem;
}

.review-stats-card {
    border: 2px solid #e3f2fd;
}

.review-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.review-card.featured {
    border: 2px solid #ffc107;
    background: linear-gradient(135deg, #fff9c4 0%, #ffffff 100%);
}

.featured-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ffc107;
    color: #000;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1E3A8A, #3B82F6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
}

.rating {
    font-size: 1.1rem;
}

.review-text {
    line-height: 1.6;
    color: #555;
}

.service-tag {
    margin-top: 10px;
}

.verified-badge {
    font-size: 0.9rem;
    color: #28a745;
}

.rating-bar .progress {
    background-color: #e9ecef;
}

.filter-controls {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .filter-controls {
        flex-direction: column;
        width: 100%;
    }
    
    .filter-controls select {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let isLoading = false;
    
    // Filter functionality
    const ratingFilter = document.getElementById('ratingFilter');
    const serviceFilter = document.getElementById('serviceFilter');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    
    function loadReviews(reset = false) {
        if (isLoading) return;
        
        isLoading = true;
        if (reset) currentPage = 1;
        
        const params = new URLSearchParams({
            page: currentPage,
            rating: ratingFilter.value,
            service_type: serviceFilter.value
        });
        
        fetch(`/api/reviews?${params}`)
            .then(response => response.json())
            .then(data => {
                if (reset) {
                    document.getElementById('reviewsContainer').innerHTML = '';
                }
                
                // Render reviews
                data.reviews.forEach(review => {
                    const reviewHtml = createReviewHtml(review);
                    document.getElementById('reviewsContainer').insertAdjacentHTML('beforeend', reviewHtml);
                });
                
                // Show/hide load more button
                loadMoreBtn.style.display = data.pagination.has_more ? 'block' : 'none';
                
                currentPage++;
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
                isLoading = false;
            });
    }
    
    function createReviewHtml(review) {
        const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
        const featuredBadge = review.is_featured ? 
            '<div class="featured-badge"><i class="fas fa-star"></i> Featured</div>' : '';
        const verifiedBadge = review.is_verified ? 
            '<div class="verified-badge mt-2"><i class="fas fa-check-circle text-success"></i> Verified Customer</div>' : '';
        
        return `
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="review-card card h-100 ${review.is_featured ? 'featured' : ''}">
                    <div class="card-body">
                        ${featuredBadge}
                        <div class="review-header mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="customer-avatar me-3">
                                    <div class="avatar-circle">${review.customer_name.charAt(0)}</div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">${review.customer_name}</h6>
                                    ${review.customer_location ? `<small class="text-muted">${review.customer_location}</small>` : ''}
                                </div>
                            </div>
                            <div class="rating mb-2">${stars}</div>
                            ${review.project_name ? `<div class="project-info"><small class="text-primary fw-bold">${review.project_name}</small></div>` : ''}
                        </div>
                        <div class="review-content">
                            <p class="review-text">${review.review_text}</p>
                        </div>
                        ${review.service_type ? `<div class="service-tag"><span class="badge bg-primary">${review.service_type}</span></div>` : ''}
                        ${verifiedBadge}
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">${new Date(review.created_at).toLocaleDateString()}</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Event listeners
    ratingFilter.addEventListener('change', () => loadReviews(true));
    serviceFilter.addEventListener('change', () => loadReviews(true));
    loadMoreBtn.addEventListener('click', () => loadReviews(false));
});
</script>
@endpush
