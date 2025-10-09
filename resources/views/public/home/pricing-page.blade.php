@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])

@section('content')
<x-page-title
    :title="__('Choose Your Perfect Plan')"
    :subtitle="__('Select the plan that best fits your business needs')"
/>

<section class="py-5 bg-light">
    <div class="container">
        <!-- Pricing Banner -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <img src="{{ asset('assets/landing/img/land-price-banner.jpg') }}"
                     alt="{{ __('Pricing Plans') }}"
                     class="img-fluid rounded shadow-sm">
            </div>
        </div>

        <!-- Plan Type Tabs -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6">
                <div class="nav nav-pills nav-justified bg-white rounded-pill shadow-sm p-1" id="pricing-tabs" role="tablist">
                    <button class="nav-link active rounded-pill px-4 py-3"
                            id="monthly-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#monthly"
                            type="button"
                            role="tab"
                            aria-controls="monthly"
                            aria-selected="true">
                        <i class="fas fa-calendar-alt me-2"></i>{{ __('Monthly Plans') }}
                    </button>
                    <button class="nav-link rounded-pill px-4 py-3"
                            id="yearly-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#yearly"
                            type="button"
                            role="tab"
                            aria-controls="yearly"
                            aria-selected="false">
                        <i class="fas fa-calendar me-2"></i>{{ __('Yearly Plans') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Plans Content -->
        <div class="tab-content" id="pricing-content">
            <!-- Monthly Plans -->
            <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                <div class="row g-4 justify-content-center">
                    @foreach ($collection->where('duration', 'month')->where('is_visible', 1) as $plan)
                        @include('partials.pricing.plan-card', ['plan' => $plan, 'country' => $country, 'currentLanguage' => $currentLanguage])
                    @endforeach
                </div>
            </div>

            <!-- Yearly Plans -->
            <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                <div class="row g-4 justify-content-center">
                    @foreach ($collection->where('duration', 'year')->where('is_visible', 1) as $plan)
                        @include('partials.pricing.plan-card', ['plan' => $plan, 'country' => $country, 'currentLanguage' => $currentLanguage])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if($collection->where('is_visible', 1)->count() === 0)
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5">
                            <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">{{ __('No Plans Available') }}</h5>
                            <p class="text-muted mb-0">{{ __('Please check back later for available pricing plans.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize plan description toggles
    const descriptions = document.querySelectorAll('.plan-description');

    descriptions.forEach(function(description) {
        const fullText = description.dataset.fullText;
        const maxLength = 80;
        const toggleBtn = description.nextElementSibling;

        if (fullText && fullText.length > maxLength) {
            description.textContent = fullText.slice(0, maxLength) + '...';
            if (toggleBtn && toggleBtn.classList.contains('description-toggle')) {
                toggleBtn.style.display = 'block';
            }
        }
    });
});

function toggleDescription(button) {
    const description = button.previousElementSibling;
    const fullText = description.dataset.fullText;
    const maxLength = 80;
    const isExpanded = button.dataset.expanded === 'true';

    if (isExpanded) {
        description.textContent = fullText.slice(0, maxLength) + '...';
        button.innerHTML = '<i class="fas fa-chevron-down me-1"></i>Show More';
        button.dataset.expanded = 'false';
    } else {
        description.textContent = fullText;
        button.innerHTML = '<i class="fas fa-chevron-up me-1"></i>Show Less';
        button.dataset.expanded = 'true';
    }
}
</script>
@endpush
