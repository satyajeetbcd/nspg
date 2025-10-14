@extends('frontend.layouts.app')

@section('title', 'What\'s New - NSPG Solar Solutions')
@section('description', 'Stay updated with the latest news, updates, and developments from NSPG Solar Solutions.')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">What's New</h1>
                <p class="lead mb-4">Stay updated with the latest news, updates, and developments from NSPG Solar Solutions.</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">What's New</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper fa-5x opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- What's New Content -->
<section class="py-5">
    <div class="container">
        @if($whatsNew->count() > 0)
            <div class="row">
                @foreach($whatsNew as $item)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 whats-new-card">
                        @if($item->image)
                        <div class="card-img-top-container" style="height: 200px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $item->image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="card-img-top h-100 w-100" 
                                 style="object-fit: cover;">
                        </div>
                        @else
                        <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-white opacity-75"></i>
                        </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $item->publish_date->format('M d, Y') }}</span>
                            </div>
                            
                            <h5 class="card-title text-dark mb-3">{{ $item->title }}</h5>
                            
                            <div class="card-text flex-grow-1">
                                <p class="text-muted mb-3">
                                    {!! Str::limit(strip_tags($item->description), 120) !!}
                                </p>
                                
                                @if($item->hindi_description)
                                <p class="text-muted mb-3" style="font-family: 'Noto Sans Devanagari', sans-serif;">
                                    {!! Str::limit(strip_tags($item->hindi_description), 100) !!}
                                </p>
                                @endif
                            </div>
                            
                            <div class="mt-auto">
                                <button class="btn btn-outline-primary w-100" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#whatsNewModal{{ $item->id }}">
                                    <i class="fas fa-eye me-2"></i>
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                <h3 class="text-muted mb-3">No Updates Available</h3>
                <p class="text-muted mb-4">We're working on bringing you the latest updates. Check back soon!</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>
                    Back to Home
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modals for detailed view -->
@foreach($whatsNew as $item)
<div class="modal fade" id="whatsNewModal{{ $item->id }}" tabindex="-1" aria-labelledby="whatsNewModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsNewModalLabel{{ $item->id }}">{{ $item->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($item->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="img-fluid rounded shadow">
                </div>
                @endif
                
                <div class="mb-3">
                    <span class="badge bg-primary">{{ $item->publish_date->format('M d, Y') }}</span>
                </div>
                
                <div class="mb-4">
                    <h6 class="text-dark">Description</h6>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($item->description)) !!}
                    </div>
                </div>
                
                @if($item->hindi_description)
                <div class="mb-4">
                    <h6 class="text-dark">Hindi Description</h6>
                    <div class="border rounded p-3 bg-light" style="font-family: 'Noto Sans Devanagari', sans-serif;">
                        {!! nl2br(e($item->hindi_description)) !!}
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('styles')
<style>
.whats-new-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.whats-new-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.hero-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
}

.card-img-top-container {
    border-radius: 15px 15px 0 0;
    overflow: hidden;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
}
</style>
@endpush
