@extends('frontend.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'NSPG - Nirmala Solar Power Generation | Leading Solar Energy Solutions')

@section('content')
<style>

.marginset {
    margin-top: 100px;
}
/* Banner Carousel Styling */
.banner-slider-section {
    position: relative;
    overflow: hidden;
    padding-top: 80px; /* Add space for fixed navbar */
}

.banner-slide {
    position: relative;
    min-height: 110vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.banner-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: transform 0.6s ease-in-out;
}

.banner-slide:hover .banner-bg {
    transform: scale(1.05);
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(144, 56, 18, 0.96) 0%, rgba(62, 238, 39, 0.21) 100%);
    z-index: 1;
}

.banner-content {
    position: relative;
    z-index: 2;
    color: white;
    padding: 2rem 0;
}

/* Hero Image Beautification */
.hero-image {
    position: relative;
    z-index: 2;
    padding: 1rem;
}

.hero-image img {
    width: 100%;
    height: auto;
    border-radius: 20px;
    border: 4px solid rgba(255, 255, 255, 0.2);
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.4),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.hero-image img:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 
        0 35px 70px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(255, 255, 255, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

/* Add a subtle glow effect */
.hero-image::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(45deg, rgba(255, 107, 53, 0.3), rgba(255, 255, 255, 0.1));
    border-radius: 30px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hero-image:hover::before {
    opacity: 1;
}

/* Carousel Indicators Styling */
.carousel-indicators {
    bottom: 30px;
    z-index: 3;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.8);
    margin: 0 5px;
    transition: all 0.3s ease;
}

.carousel-indicators button.active {
    background-color: var(--primary-orange);
    border-color: white;
    transform: scale(1.2);
}

.carousel-indicators button:hover {
    background-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.1);
}

/* Carousel Controls Styling */
.carousel-control-prev,
.carousel-control-next {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(255, 107, 53, 0.8);
    border-color: white;
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-prev {
    left: 30px;
}

.carousel-control-next {
    right: 30px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
}

/* Banner Content Enhancements */
.banner-content h1 {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    animation: fadeInUp 1s ease-out;
}

.banner-content p {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    animation: fadeInUp 1s ease-out 0.2s both;
}

.banner-content .btn {
    animation: fadeInUp 1s ease-out 0.4s both;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.banner-content .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
    border-color: rgba(255, 255, 255, 0.4);
}

/* Company Name Styling */
.company-name {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    animation: fadeInUp 1s ease-out;
}

.private-limited {
    display: block;
    font-size: 1.5rem;
    font-weight: 400;
    opacity: 0.9;
    margin-top: 0.5rem;
}

/* Scheme Banner Enhancements */
.scheme-banner {
    display: flex;
    align-items: center;
    margin: 2rem 0;
    animation: fadeInUp 1s ease-out 0.3s both;
}

.scheme-yellow,
.scheme-blue {
    padding: 12px 24px;
    font-weight: 600;
    font-size: 1.1rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.scheme-yellow {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #333;
    margin-right: 10px;
}

.scheme-blue {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    margin-right: 15px;
}

.scheme-arrow {
    color: white;
    font-size: 1.5rem;
    animation: bounce 2s infinite;
}

.scheme-yellow:hover,
.scheme-blue:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

/* Banner Slogan */
.banner-slogan h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    animation: fadeInUp 1s ease-out 0.5s both;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .banner-slider-section {
        padding-top: 80px; /* Space for fixed navbar */
    }
    
    .banner-slide {
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .banner-content {
        text-align: center;
        padding: 1rem 0;
    }
    
    .hero-image {
        padding: 0.5rem;
        margin-top: 2rem;
    }
    
    .hero-image img {
        border-radius: 15px;
        border-width: 2px;
    }
    
    .company-name {
        font-size: 2.5rem;
        text-align: center;
    }
    
    .private-limited {
        font-size: 1.2rem;
        text-align: center;
    }
    
    .banner-slogan h2 {
        font-size: 2rem;
        text-align: center;
    }
    
    .scheme-banner {
        flex-direction: column;
        gap: 10px;
        align-items: center;
        text-align: center;
    }
    
    .scheme-yellow,
    .scheme-blue {
        margin-right: 0;
        margin-bottom: 10px;
        width: 100%;
        text-align: center;
    }
    
    .benefits-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 2rem;
    }
    
    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    .feature-item i {
        font-size: 1.5rem;
        margin-bottom: 5px;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
    }
    
    .carousel-control-prev {
        left: 15px;
    }
    
    .carousel-control-next {
        right: 15px;
    }
}

@media (max-width: 576px) {
    .banner-slider-section {
        padding-top: 80px;
    }
    
    .banner-slide {
        min-height: 100vh;
        padding: 15px 0;
    }
    
    .banner-content {
        padding: 1rem 0;
        text-align: center;
    }
    
    .hero-image {
        padding: 0.25rem;
        margin-top: 1.5rem;
    }
    
    .hero-image img {
        border-radius: 10px;
        width: 100%;
        height: auto;
    }
    
    .company-name {
        font-size: 1.8rem;
        text-align: center;
        line-height: 1.1;
    }
    
    .private-limited {
        font-size: 0.9rem;
        text-align: center;
    }
    
    .banner-slogan h2 {
        font-size: 1.3rem;
        text-align: center;
    }
    
    .scheme-banner {
        flex-direction: column;
        gap: 8px;
        align-items: center;
        text-align: center;
    }
    
    .scheme-yellow,
    .scheme-blue {
        padding: 8px 16px;
        font-size: 0.9rem;
        margin: 0;
        width: 100%;
    }
    
    .benefits-features {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 1.5rem;
    }
    
    .feature-item {
        padding: 8px;
        font-size: 0.9rem;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
    }
    
    .carousel-control-prev {
        left: 10px;
    }
    
    .carousel-control-next {
        right: 10px;
    }
    
    .carousel-indicators {
        bottom: 20px;
    }
}

/* Google Map Section Styling */
.map-section {
    position: relative;
    overflow: hidden;
}

.map-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.map-container {
    position: relative;
    z-index: 2;
}

.map-wrapper {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.map-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.3);
}

.map-info-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.info-item i {
    font-size: 1.5rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.info-item h6 {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.info-item p {
    color: var(--text-light);
    line-height: 1.5;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-orange), var(--primary-orange-light));
    border-radius: 2px;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-light);
    margin-bottom: 0;
}

/* Map Section Responsive */
@media (max-width: 768px) {
    .map-info-card {
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-item i {
        font-size: 1.25rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .map-info-card {
        padding: 1rem;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
    }
    
    .info-item i {
        margin-bottom: 0.5rem;
        margin-right: 0;
    }
    .marginset {
        margin-top: 1px;
    }

}

/* Calculator Input Width Responsive */
@media (max-width: 768px) {
    .input-wrapper,
    .input-wrapper .form-control {
        max-width: 400px;
    }
    .marginset {
        margin-top: 1px;
    }
}

@media (max-width: 576px) {
    .input-wrapper,
    .input-wrapper .form-control {
        max-width: 100%;
    }   
    .marginset {
        margin-top: 4px;
    }
}

/* Additional Mobile Optimizations */
@media (max-width: 768px) {
    /* Improve touch targets */
    .btn {
        min-height: 44px;
        padding: 12px 20px;
    }
    
    /* Better spacing for mobile */
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    /* Improve readability */
    .lead {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    /* Better form controls */
    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
        padding: 12px 15px;
    }
    
    /* Improve carousel on mobile */
    .carousel-indicators {
        bottom: 15px;
    }
    
    .carousel-indicators button {
        width: 10px;
        height: 10px;
        margin: 0 3px;
    }
    
    /* Better mobile navigation */
    .navbar-toggler {
        border: none;
        padding: 4px 8px;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    /* Benefit cards mobile styling */
    .benefit-card {
        padding: 20px;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .benefit-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-orange), var(--primary-orange-light));
        border-radius: 50%;
    }
    
    .benefit-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .benefit-card h4 {
        font-size: 1.3rem;
        margin-bottom: 15px;
        color: var(--text-dark);
    }
    
    .benefit-card p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-light);
    }
}

@media (max-width: 576px) {
    /* Extra small screen optimizations */
    .btn {
        min-height: 40px;
        padding: 10px 16px;
        font-size: 0.9rem;
    }
    
    .container {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .lead {
        font-size: 1rem;
    }
    
    .form-control {
        font-size: 16px;
        padding: 10px 12px;
    }
    
    /* Smaller carousel controls */
    .carousel-control-prev,
    .carousel-control-next {
        width: 35px;
        height: 35px;
    }
    
    .carousel-control-prev {
        left: 5px;
    }
    
    .carousel-control-next {
        right: 5px;
    }
    
    .carousel-indicators {
        bottom: 10px;
    }
    
    .carousel-indicators button {
        width: 8px;
        height: 8px;
        margin: 0 2px;
    }
}

/* Landscape mobile optimizations */
@media (max-width: 768px) and (orientation: landscape) {
    .banner-slide {
        min-height: 80vh;
    }
    
    .banner-content {
        padding: 0.5rem 0;
    }
    
    .hero-image {
        margin-top: 1rem;
    }
    
    .company-name {
        font-size: 2rem;
    }
    
    .banner-slogan h2 {
        font-size: 1.5rem;
    }
}

/* High DPI display optimizations */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .hero-image img,
    .service-image img,
    .project-image img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
}
</style>



        <!-- NEW SIMPLE BANNER CAROUSEL -->
               <!-- Banner Slider Section -->
               <section class="banner-slider-section">
           
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
                <div class="carousel-indicators">
                    @foreach($banners as $index => $banner)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
        
        <div class="carousel-inner">
            <!-- Banner 1: Pradhan Mantri Surya Ghar Scheme -->
            <div class="carousel-item active">
                <div class="banner-slide">
                    <div class="banner-bg" style="background-image: url('https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');"></div>
                    <div class="banner-overlay"></div>
                    <div class="container">
                        <div class="row align-items-center min-vh-100">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content marginset">
                                    <!-- Government Logos -->
                                    <div class="government-logos mb-4">
                                        <div class="row align-items-center">
                                           
                                        </div>
                                    </div>
                                    
                                    <!-- Company Name -->
                                    <h1 class="company-name mt-5">
                                        Nirmala Solar Power Generation
                                        <span class="private-limited">Private Limited</span>
                                    </h1>
                                    
                                    <!-- Company Description -->
                                    <div class="company-description mb-4">
                                        <p class="lead">EPC Company established in 2015, delivering solar solutions for both rooftop and ground-mounted installations. We harness solar energy efficiently and cost-effectively, offering environmentally friendly solutions with high return on investment.</p>
                                    </div>
                                    
                                    <!-- Scheme Banner -->
                                    <div class="scheme-banner mb-4">
                                        <div class="scheme-yellow">
                                            <span>Pradhan Mantri Surya Ghar</span>
                                        </div>
                                        <div class="scheme-blue">
                                            <span>Free Electricity Scheme</span>
                                        </div>
                                        <div class="scheme-arrow">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Slogan -->
                                    <div class="banner-slogan">
                                        <h2>Your Home, Your Electricity</h2>
                                        <p>Free from electricity bills for 25 years</p>
                                    </div>
                                    
                                    <!-- Benefits -->
                                    <div class="benefits-features">
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>25 Year Warranty</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-leaf"></i>
                                            <span>Environment Friendly</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-bolt"></i>
                                            <span>Renewable Energy</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-charging-station"></i>
                                            <span>Fast Installation</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile CTA Button -->
                                    <div class="d-lg-none mt-4">
                                        <a href="{{ route('contact') }}" class="btn btn-warning btn-lg w-100">
                                            <i class="fas fa-phone me-2"></i>
                                            Get Free Quote
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="hero-image">
                                    <img src="{{ asset($banners[0]->image_path) }}" 
                                         alt="Solar Panels" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Banner 2: Solar Solutions -->
            <div class="carousel-item">
                <div class="banner-slide">
                    <div class="banner-bg" style="background-image: url('https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');"></div>
                    <div class="banner-overlay"></div>
                    <div class="container">
                        <div class="row align-items-center min-vh-100">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content marginset">
                                    <span class="hero-badge">Leading Solar Solutions</span>
                                    <h1 class="hero-title">
                                        Clean Energy
                                        <span class="text-primary">Solutions</span>
                                        for Your Future
                                    </h1>
                                    <p class="hero-description">
                                        We provide innovative solar energy solutions that help you save money while protecting the environment. Join thousands of satisfied customers who have made the switch to clean energy.
                                    </p>
                                    <div class="hero-buttons d-none d-lg-block">
                                        <a href="{{ route('services') }}" class="btn btn-primary btn-lg me-3">
                                            <i class="fas fa-solar-panel me-2"></i>
                                            Our Services
                                        </a>
                                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-phone me-2"></i>
                                            Get Quote
                                        </a>
                                    </div>
                                    <div class="hero-stats d-none d-lg-flex">
                                        <div class="stat-item">
                                            <h3>25+</h3>
                                            <p>Years Experience</p>
                                        </div>
                                        <div class="stat-item">
                                            <h3>700+</h3>
                                            <p>Projects Completed</p>
                                        </div>
                                        <div class="stat-item">
                                            <h3>200+</h3>
                                            <p>Happy Clients</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile CTA Button -->
                                    <div class="d-lg-none mt-4">
                                        <a href="{{ route('contact') }}" class="btn btn-warning btn-lg w-100 mb-3">
                                            <i class="fas fa-phone me-2"></i>
                                            Get Free Quote
                                        </a>
                                        <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg w-100">
                                            <i class="fas fa-solar-panel me-2"></i>
                                            Our Services
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="hero-image">
                                    <img src="{{ asset($banners[1]->image_path) }}" 
                                         alt="Solar Panels" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Banner 3: Renewable Energy -->
            <div class="carousel-item">
                <div class="banner-slide">
                    <div class="banner-bg" style="background-image: url('https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');"></div>
                    <div class="banner-overlay"></div>
                    <div class="container">
                        <div class="row align-items-center min-vh-100">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content marginset">
                                    <span class="hero-badge">Sustainable Future</span>
                                    <h1 class="hero-title">
                                        Renewable Energy
                                        <span class="text-primary">for Everyone</span>
                                    </h1>
                                    <p class="hero-description">
                                        Make the switch to renewable energy and contribute to a sustainable future. Our solar solutions are designed to meet your energy needs while reducing your carbon footprint.
                                    </p>
                                    <div class="hero-buttons d-none d-lg-block">
                                        <a href="{{ route('about') }}" class="btn btn-primary btn-lg me-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Learn More
                                        </a>
                                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-phone me-2"></i>
                                            Contact Us
                                        </a>
                                    </div>
                                    <div class="benefits-features">
                                        <div class="feature-item">
                                            <i class="fas fa-shield-alt"></i>
                                            <span>25 Year Warranty</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-tools"></i>
                                            <span>Expert Installation</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-headset"></i>
                                            <span>24/7 Support</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile CTA Button -->
                                    <div class="d-lg-none mt-4">
                                        <a href="{{ route('contact') }}" class="btn btn-warning btn-lg w-100 mb-3">
                                            <i class="fas fa-phone me-2"></i>
                                            Contact Us
                                        </a>
                                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg w-100">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="hero-image">
                                    <img src="{{ asset($banners[2]->image_path) }}" 
                                         alt="Solar Farm" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

        
        <!-- About Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="about-content">
                    <span class="section-badge">About NSPG</span>
                    <h2 class="section-title">Leading EPC Company in Solar Energy</h2>
                    <p class="section-description">
                        Nirmala Solar Power Generation Pvt. Ltd. (NSPG) is an EPC (Engineering, Procurement, and Construction) company established in 2015, dedicated to delivering solar solutions for both rooftop and ground-mounted installations. We harness solar energy efficiently and cost-effectively, offering environmentally friendly and energy-efficient solutions that provide a high return on investment.
                    </p>
                    
                    <!-- Company Achievements -->
                    <div class="achievements mb-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="achievement-item text-center">
                                    <h3 class="achievement-number">500+</h3>
                                    <p class="achievement-label">Residential Projects</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="achievement-item text-center">
                                    <h3 class="achievement-number">2015</h3>
                                    <p class="achievement-label">Established</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="feature-content">
                                <h5>EPC Services</h5>
                                <p>Complete Engineering, Procurement, and Construction services</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-industry"></i>
                            </div>
                            <div class="feature-content">
                                <h5>OEM in UP</h5>
                                <p>Original Equipment Manufacturer in Uttar Pradesh</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="feature-content">
                                <h5>High ROI</h5>
                                <p>Solutions providing high return on investment</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center text-lg-start">
                        <a href="{{ route('about') }}" class="btn btn-primary">
                            Learn More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="about-images">
                    <div class="main-image">
                        <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" 
                             alt="Solar Installation" class="img-fluid">
                    </div>
                    <div class="floating-card d-none d-lg-block">
                        <div class="card-content">
                            <h4>500+</h4>
                            <p>Projects Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Our Services</span>
            <h2 class="section-title">NSPG Services</h2>
            <p class="section-description">Complete EPC solutions for rooftop and ground-mounted solar installations</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/epc-services.svg" alt="NSPG EPC Services" class="img-fluid">
                    </div>
                    <h4>NSPG EPC</h4>
                    <p>Comprehensive EPC services including site-specific design, construction, and commissioning of solar projects for both rooftop and ground-mounted installations.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/solar-finance.svg" alt="Solar Finance Solutions" class="img-fluid">
                    </div>
                    <h4>Solar Finance</h4>
                    <p>Financial solutions to facilitate the adoption of solar energy, making it accessible and affordable for all customers.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/operations-maintenance.svg" alt="Operations & Maintenance" class="img-fluid">
                    </div>
                    <h4>Operations & Maintenance</h4>
                    <p>Ensures the longevity and efficiency of solar installations through regular maintenance services and monitoring.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/rooftop-solar.svg" alt="Rooftop Solar Solutions" class="img-fluid">
                    </div>
                    <h4>Rooftop Solar</h4>
                    <p>Specialized rooftop solar solutions for residential and commercial buildings with over 500+ completed projects.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/ground-mounted-solar.svg" alt="Ground-Mounted Solar" class="img-fluid">
                    </div>
                    <h4>Ground-Mounted Solar</h4>
                    <p>Large-scale ground-mounted solar installations for industrial and utility-scale projects with high efficiency.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/high-roi-solutions.svg" alt="High ROI Solutions" class="img-fluid">
                    </div>
                    <h4>High ROI Solutions</h4>
                    <p>Environmentally friendly and energy-efficient solutions that provide high return on investment with up to 30% ROI.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Solar Section -->
<section class="why-solar-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Why Choose Solar?</span>
            <h2 class="section-title">Financial Benefits of Solar Energy</h2>
            <p class="section-description">Discover the significant savings and returns that solar energy can provide</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h4>Financial Savings</h4>
                    <p>Homeowners and business owners have reported reductions in energy bills ranging from <strong>50% to 90%</strong>. For instance, if your monthly energy cost is ₹4,000, a 50% reduction would save you <strong>₹24,000 annually</strong>.</p>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>High Investment Returns</h4>
                    <p>Installing solar panels can yield a return on investment (ROI) as high as <strong>30%</strong>, with a payback period of less than <strong>three years</strong>. Additionally, benefits include tax savings through accelerated depreciation.</p>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4>On-Grid Systems</h4>
                    <p>These systems feed energy from solar panels into an inverter, converting it to alternating current compatible with the grid. Excess or deficient power can be managed through net metering, allowing users to receive credit for surplus energy produced.</p>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-battery-full"></i>
                    </div>
                    <h4>Off-Grid Systems</h4>
                    <p>Comprising solar panels, batteries, and a charge controller, these systems operate independently of the grid, storing excess energy for use during non-sunny periods.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Solar Calculator Section -->
@if(isset($calculatorSettings['is_calculator_enabled']) && $calculatorSettings['is_calculator_enabled'])
<section class="calculator-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Solar Calculator</span>
            <h2 class="section-title">{{ $calculatorSettings['calculator_subtitle'] ?? 'Calculate Your Savings' }}</h2>
            <p class="section-description">{{ $calculatorSettings['calculator_description'] ?? 'Explore the potential of solar energy and start saving from Day One!' }}</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="calculator-container">
                    <div class="calculator-header">
                        <h3>{{ $calculatorSettings['calculator_title'] ?? 'NSPG Solar Calculator' }}</h3>
                    </div>
                    
                    <div class="calculator-content">
                        <!-- Calculator Tabs -->
                        <div class="calculator-tabs">
                            <button class="tab-btn active" data-tab="home">Home</button>
                            <button class="tab-btn" data-tab="commercial">Commercial</button>
                        </div>
                        
                        <!-- Input Section -->
                        <div class="calculator-input">
                            <div class="input-group">
                                <label for="monthlyBill" class="m-3">Monthly Electricity Bill </label>
                                <div class="input-wrapper ml-3" >
                                    <span class="currency">₹</span>
                                    <input type="number" id="monthlyBill" class="form-control" placeholder="3000" value="3000" min="100" max="100000">
                                </div>
                            </div>
                            
                            <div class="input-toggle">
                                <label class="toggle-label">
                                    <input type="radio" name="inputType" value="bill" checked>
                                    <span class="toggle-text">Bill Amount</span>
                                </label>
                                <label class="toggle-label">
                                    <input type="radio" name="inputType" value="system">
                                    <span class="toggle-text">System Size</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Results Section -->
                        <div class="calculator-results">
                            <div class="result-grid">
                                <div class="result-item">
                                    <div class="result-icon">
                                        <i class="fas fa-solar-panel"></i>
                                    </div>
                                    <div class="result-content">
                                        <h4 id="systemSize">4 kW</h4>
                                        <p>System Size</p>
                                    </div>
                                </div>
                                
                                <div class="result-item">
                                    <div class="result-icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <div class="result-content">
                                        <h4 id="annualSavings">₹36,000</h4>
                                        <p>Annual Savings</p>
                                    </div>
                                </div>
                                
                                <div class="result-item">
                                    <div class="result-icon">
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                    <div class="result-content">
                                        <h4 id="annualEnergy">5,760 Units</h4>
                                        <p>Annually Generated Energy</p>
                                    </div>
                                </div>
                                
                                <div class="result-item">
                                    <div class="result-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="result-content">
                                        <h4 id="spaceRequired">320 Sqft</h4>
                                        <p>Space Required</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cost Breakdown -->
                        <div class="cost-breakdown">
                            <h4>Cost Breakdown</h4>
                            <div class="cost-item">
                                <span>Price (Excluding Subsidy & GST)</span>
                                <span id="basePrice">₹2,52,703</span>
                            </div>
                            <div class="cost-item">
                                <span>Subsidy + NSPG Discount</span>
                                <span id="discount">(₹75,000 + ₹22,000)</span>
                            </div>
                            <div class="cost-item total">
                                <span>Project Cost</span>
                                <span id="projectCost">= ₹1,52,703 (*Tax Extra)</span>
                            </div>
                        </div>
                        
                        <!-- CTA Button -->
                        <div class="calculator-cta">
                            <a href="{{ route('contact') }}">
                            <button class="btn btn-primary btn-lg">
                                {{ 'Book Free Consultation' }}
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Why Choose Us Section -->
<section class="why-choose-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="why-choose-content">
                    <span class="section-badge">Why Choose Us</span>
                    <h2 class="section-title">Excellence in Every Project</h2>
                    <p class="section-description">
                        We are committed to delivering the highest quality solar energy solutions with unmatched customer service and support.
                    </p>
                    
                    <div class="why-choose-features">
                        <div class="feature-item">
                            <div class="feature-number">01</div>
                            <div class="feature-content">
                                <h5>Expert Team</h5>
                                <p>Our certified engineers and technicians have years of experience in solar energy.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-number">02</div>
                            <div class="feature-content">
                                <h5>Quality Materials</h5>
                                <p>We use only the highest quality solar panels and components from trusted manufacturers.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-number">03</div>
                            <div class="feature-content">
                                <h5>Competitive Pricing</h5>
                                <p>Get the best value for your investment with our competitive pricing and financing options.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12">
                <div class="why-choose-image">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" 
                         alt="Solar Installation" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Projects Section -->
<section class="projects-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Our Projects</span>
            <h2 class="section-title">Recent Installations</h2>
            <p class="section-description">Take a look at some of our recent solar energy projects</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                             alt="Residential Solar" class="img-fluid">
                        <div class="project-overlay">
                            <a href="#" class="project-link">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h5>Residential Solar Installation</h5>
                        <p>5kW solar system for a family home in Delhi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                             alt="Commercial Solar" class="img-fluid">
                        <div class="project-overlay">
                            <a href="#" class="project-link">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h5>Commercial Solar Project</h5>
                        <p>50kW solar system for office building in Mumbai</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                             alt="Industrial Solar" class="img-fluid">
                        <div class="project-overlay">
                            <a href="#" class="project-link">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h5>Industrial Solar Farm</h5>
                        <p>500kW solar farm for manufacturing facility</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-primary">
                View All Projects <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Testimonials</span>
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-description">Hear from our satisfied customers about their experience with NSPG</p>
        </div>
        
        @if($reviews->count() > 0)
        <div class="row">
            <div class="col-12">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                    <div class="carousel-inner">
                        @php
                            $chunks = $reviews->chunk(3);
                        @endphp
                        @foreach($chunks as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $review)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="testimonial-item">
                                        <div class="testimonial-content">
                                            <div class="quote-icon">
                                                <i class="fas fa-quote-left"></i>
                                            </div>
                                            <p class="testimonial-text">
                                                "{{ $review->review_text }}"
                                            </p>
                                            <div class="testimonial-author">
                                                <div class="author-image">
                                                    <div class="avatar-circle">
                                                        {{ substr($review->customer_name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="author-info">
                                                    <h6>{{ $review->customer_name }}</h6>
                                                    <span>{{ $review->customer_location ?? 'Customer' }}</span>
                                                    @if($review->project_name)
                                                    <br><small class="text-muted">{{ $review->project_name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="testimonial-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            @if($review->is_verified)
                                            <div class="verified-badge">
                                                <i class="fas fa-check-circle text-success"></i> Verified Customer
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- View All Reviews Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('reviews') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-star me-2"></i>
                    View All Reviews
                </a>
            </div>
        </div>
        @else
        <!-- Fallback content when no reviews -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">
                            "NSPG provided us with an excellent solar system that has significantly reduced our electricity bills. Their installation team was professional and the system has been working flawlessly for over 2 years."
                        </p>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <div class="avatar-circle">R</div>
                            </div>
                            <div class="author-info">
                                <h6>Rajesh Kumar</h6>
                                <span>Business Owner</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="cta-title">Ready to Go Solar?</h2>
                <p class="cta-description">Get a free consultation and quote for your solar energy system today.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i>
                    Get Free Quote
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Google Map Section -->
<section class="map-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title">Find Us</h2>
                    <p class="section-subtitle">Visit our office for a free consultation</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="map-container">
                    <div class="map-wrapper">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.8520030574223!2d83.00926857478551!3d25.275563528523247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e3196ffc83da3%3A0x9e70d9c27cb92a38!2sNSPG%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1758468974766!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                       
                    </div>
                    
                    <!-- Map Info Card -->
                    
                        
                        
                        <div class="text-center mt-4">
                            <a href="https://maps.app.goo.gl/WyhDrJnnoNGAx82Q7" target="_blank" class="btn btn-primary btn-lg">
                                <i class="fas fa-directions me-2"></i>
                                Get Directions
                            </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
:root {
    --primary-orange: #ff6b35;
    --primary-orange-light: #f7931e;
}

/* Top Bar */
.top-bar {
    background: #1a1a1a;
    padding: 10px 0;
    font-size: 0.875rem;
}

.top-bar-info span {
    color: #ccc;
    margin-right: 20px;
}

.top-bar-info i {
    color: var(--primary-orange);
    margin-right: 5px;
}

.top-bar-social .social-link {
    color: #ccc;
    margin-left: 15px;
    font-size: 1.1rem;
    transition: color 0.3s ease;
}

.top-bar-social .social-link:hover {
    color: var(--primary-orange);
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-slider {
    position: relative;
    width: 100%;
    height: 100vh;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.hero-slide.active {
    opacity: 1;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(30, 58, 138, 0.8) 0%, rgba(59, 130, 246, 0.6) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.hero-badge {
    display: inline-block;
    background: var(--primary-orange);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 30px;
    opacity: 0.9;
}

.hero-buttons {
    margin-bottom: 40px;
}

.hero-stats {
    display: flex;
    gap: 40px;
}

.stat-item h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-orange);
    margin: 0;
}

.stat-item p {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
}

.hero-image {
    position: relative;
    z-index: 2;
}

.hero-image img {
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

/* Section Badge */
.section-badge {
    display: inline-block;
    background: var(--primary-orange);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 15px;
}

/* About Section */
.about-section {
    padding: 100px 0;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--text-dark);
}

.section-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--text-light);
    margin-bottom: 30px;
}

.about-features {
    margin-bottom: 30px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-orange);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    flex-shrink: 0;
}

.feature-icon i {
    font-size: 1.5rem;
    color: white;
}

.feature-content h5 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-dark);
}

.feature-content p {
    color: var(--text-light);
    margin: 0;
}

.about-images {
    position: relative;
}

.main-image img {
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.floating-card {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
}

.floating-card h4 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-orange);
    margin: 0;
}

.floating-card p {
    margin: 0;
    color: var(--text-light);
}

/* Services Section */
.services-section {
    padding: 100px 0;
}

/* Benefit Cards */
.benefit-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.benefit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.benefit-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-orange), var(--primary-orange-light));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    flex-shrink: 0;
}

.benefit-icon i {
    font-size: 2rem;
    color: white;
}

.benefit-card h4 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.benefit-card p {
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
    flex: 1;
}

.service-card {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.service-image {
    width: 100%;
    height: 200px;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    display: block;
    background-color: #f8f9fa;
}

.service-image img:not([src]) {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-image img:not([src]):after {
    content: "Loading...";
    color: #6c757d;
    font-size: 14px;
}

.service-card:hover .service-image img {
    transform: scale(1.05);
}

.service-card h4 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.service-card p {
    color: var(--text-light);
    margin-bottom: 20px;
    line-height: 1.6;
}

.service-link {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.service-link:hover {
    color: var(--primary-blue);
}

/* Why Choose Section */
.why-choose-section {
    padding: 100px 0;
}

.why-choose-features .feature-item {
    margin-bottom: 30px;
}

.feature-number {
    width: 50px;
    height: 50px;
    background: var(--primary-orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    margin-right: 20px;
    flex-shrink: 0;
}

.why-choose-image img {
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

/* Solar Calculator Section */
.calculator-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.calculator-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.calculator-header {
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.calculator-header h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
}

.calculator-content {
    padding: 40px;
}

.calculator-tabs {
    display: flex;
    margin-bottom: 30px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.tab-btn {
    flex: 1;
    padding: 15px 20px;
    border: none;
    background: #f8f9fa;
    color: #6c757d;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-btn.active {
    background: var(--primary-orange);
    color: white;
}

.tab-btn:hover:not(.active) {
    background: #e9ecef;
}

.calculator-input {
    margin-bottom: 40px;
}

.input-group {
    margin-bottom: 25px;
}

.input-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #495057;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 500px;
}

.currency {
    position: absolute;
    left: 15px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
    z-index: 2;
}

.input-wrapper .form-control {
    padding-left: 40px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1.1rem;
    height: 50px;
    width: 100%;
    max-width: 500px;
    transition: all 0.3s ease;
}

.input-wrapper .form-control:focus {
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

.input-toggle {
    display: flex;
    gap: 20px;
}

.toggle-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: 500;
    color: #495057;
}

.toggle-label input[type="radio"] {
    margin-right: 8px;
    accent-color: var(--primary-orange);
}

.calculator-results {
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
}

.result-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
}

.result-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.result-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.result-content h4 {
    margin: 0 0 5px 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.result-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.cost-breakdown {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 30px;
}

.cost-breakdown h4 {
    margin-bottom: 20px;
    color: #495057;
    font-weight: 600;
}

.cost-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e9ecef;
}

.cost-item:last-child {
    border-bottom: none;
}

.cost-item.total {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--primary-orange);
    border-top: 2px solid var(--primary-orange);
    margin-top: 10px;
    padding-top: 15px;
}

.calculator-cta {
    text-align: center;
}

.calculator-cta .btn {
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    border: none;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    transition: all 0.3s ease;
}

.calculator-cta .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, var(--primary-orange-light) 0%, var(--primary-orange) 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .calculator-content {
        padding: 20px;
    }
    
    .result-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .result-item {
        flex-direction: column;
        text-align: center;
    }
    
    .input-toggle {
        flex-direction: column;
        gap: 10px;
    }
    
    .cost-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}

/* Projects Section */
.projects-section {
    padding: 100px 0;
}

.project-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.project-image {
    position: relative;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.1);
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(30, 58, 138, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-card:hover .project-overlay {
    opacity: 1;
}

.project-link {
    color: white;
    font-size: 2rem;
    text-decoration: none;
}

.project-content {
    padding: 20px;
}

.project-content h5 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--text-dark);
}

.project-content p {
    color: var(--text-light);
    margin: 0;
}

/* Testimonials Section */
.testimonials-section {
    padding: 100px 0;
    background: #f8f9fa;
}

.testimonial-slider {
    position: relative;
}

.testimonial-item {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.quote-icon {
    font-size: 3rem;
    color: var(--primary-orange);
    margin-bottom: 20px;
}

.testimonial-text {
    font-size: 1.2rem;
    font-style: italic;
    line-height: 1.6;
    color: var(--text-light);
    margin-bottom: 30px;
}

.testimonial-author {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.author-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
}

.author-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-info h6 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    color: var(--text-dark);
}

.author-info span {
    color: var(--text-light);
    font-size: 0.9rem;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1E3A8A, #3B82F6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.5rem;
}

.testimonial-rating {
    margin-top: 15px;
    font-size: 1.1rem;
}

.verified-badge {
    margin-top: 10px;
    font-size: 0.9rem;
    color: #28a745;
}

.verified-badge i {
    margin-right: 5px;
}

/* Testimonial Carousel Enhancements */
#testimonialCarousel .carousel-item {
    transition: transform 0.6s ease-in-out;
}

#testimonialCarousel .carousel-item.active {
    transform: translateX(0);
}

#testimonialCarousel .carousel-item-next {
    transform: translateX(100%);
}

#testimonialCarousel .carousel-item-prev {
    transform: translateX(-100%);
}

.testimonial-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.testimonial-text {
    flex: 1;
    margin-bottom: 20px;
}

/* Responsive adjustments for testimonials */
@media (max-width: 768px) {
    .testimonial-item {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .quote-icon {
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .testimonial-text {
        font-size: 1rem;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

/* CTA Section */
.cta-section {
    padding: 80px 0;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.cta-description {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .stat-item h3 {
        font-size: 2rem;
    }
    
    .about-section,
    .services-section,
    .why-choose-section,
    .projects-section,
    .testimonials-section {
        padding: 60px 0;
    }
    
    /* About Section Mobile */
    .about-content {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .about-features {
        margin-bottom: 2rem;
    }
    
    .feature-item {
        flex-direction: column;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .feature-icon {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .achievements {
        margin-bottom: 2rem;
    }
    
    .achievement-item {
        margin-bottom: 1rem;
    }
    
    .achievement-number {
        font-size: 2rem;
    }
    
    /* Services Section Mobile */
    .service-card {
        margin-bottom: 2rem;
        padding: 30px 20px;
    }
    
    .service-image {
        height: 180px;
        margin-bottom: 15px;
    }
    
    .service-card h4 {
        font-size: 1.3rem;
        margin-bottom: 12px;
    }
    
    .service-card p {
        font-size: 0.95rem;
        margin-bottom: 15px;
    }
    
    /* Why Choose Section Mobile */
    .why-choose-content {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .why-choose-features .feature-item {
        flex-direction: row;
        text-align: left;
        margin-bottom: 1.5rem;
    }
    
    .feature-number {
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    /* Projects Section Mobile */
    .project-card {
        margin-bottom: 2rem;
    }
    
    .project-image img {
        height: 200px;
    }
    
    .project-content {
        padding: 15px;
    }
    
    .project-content h5 {
        font-size: 1.1rem;
        margin-bottom: 8px;
    }
    
    /* Testimonials Mobile */
    .testimonial-item {
        padding: 20px;
        margin-bottom: 1.5rem;
    }
    
    .quote-icon {
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .testimonial-text {
        font-size: 1rem;
        margin-bottom: 20px;
    }
    
    .testimonial-author {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    /* Calculator Mobile */
    .calculator-container {
        margin: 0 10px;
    }
    
    .calculator-content {
        padding: 20px;
    }
    
    .calculator-header {
        padding: 20px;
    }
    
    .calculator-header h3 {
        font-size: 1.5rem;
    }
    
    .result-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .result-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .cost-breakdown {
        padding: 15px;
    }
    
    .cost-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .input-toggle {
        flex-direction: column;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .about-section,
    .services-section,
    .why-choose-section,
    .projects-section,
    .testimonials-section {
        padding: 40px 0;
    }
    
    /* Extra small screens */
    .service-card {
        padding: 20px 15px;
    }
    
    .service-image {
        height: 150px;
    }
    
    .achievement-number {
        font-size: 1.5rem;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        font-size: 1.2rem;
    }
    
    .feature-number {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .project-image img {
        height: 180px;
    }
    
    .testimonial-item {
        padding: 15px;
    }
    
    .calculator-content {
        padding: 15px;
    }
    
    .calculator-header {
        padding: 15px;
    }
    
    .calculator-header h3 {
        font-size: 1.3rem;
    }
}
</style>

<script>
    // NEW SIMPLE CAROUSEL
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize banner carousel
        var bannerCarousel = new bootstrap.Carousel(document.getElementById('bannerCarousel'), {
            interval: 5000,
            wrap: true
        });

        // Initialize testimonial carousel
        var testimonialCarousel = new bootstrap.Carousel(document.getElementById('testimonialCarousel'), {
            interval: 6000,        // 6 seconds between slides
            wrap: true,            // Loop back to first slide after last
            touch: true,           // Enable touch/swipe support
            pause: 'hover'         // Pause on hover
        });

        const bannerCarouselEl = document.getElementById('bannerCarousel');
        const testimonialCarouselEl = document.getElementById('testimonialCarousel');
        
        // Add smooth transitions for banner carousel
        if (bannerCarouselEl) {
            bannerCarouselEl.addEventListener('slide.bs.carousel', function (e) {
                const activeItem = e.target.querySelector('.carousel-item.active');
                const nextItem = e.relatedTarget;
                
                if (activeItem) {
                    activeItem.style.opacity = '0.8';
                }
                if (nextItem) {
                    nextItem.style.opacity = '1';
                }
            });
            
            // Reset opacity after slide
            bannerCarouselEl.addEventListener('slid.bs.carousel', function (e) {
                const activeItem = e.target.querySelector('.carousel-item.active');
                if (activeItem) {
                    activeItem.style.opacity = '1';
                }
            });
            
            // Pause on hover, resume on mouse leave
            bannerCarouselEl.addEventListener('mouseenter', function() {
                bannerCarousel.pause();
            });
            
            bannerCarouselEl.addEventListener('mouseleave', function() {
                bannerCarousel.cycle();
            });
        }
        
        // Add smooth transitions for testimonial carousel
        if (testimonialCarouselEl) {
            testimonialCarouselEl.addEventListener('slide.bs.carousel', function (e) {
                const activeItem = e.target.querySelector('.carousel-item.active');
                const nextItem = e.relatedTarget;
                
                if (activeItem) {
                    activeItem.style.opacity = '0.8';
                }
                if (nextItem) {
                    nextItem.style.opacity = '1';
                }
            });
            
            // Reset opacity after slide
            testimonialCarouselEl.addEventListener('slid.bs.carousel', function (e) {
                const activeItem = e.target.querySelector('.carousel-item.active');
                if (activeItem) {
                    activeItem.style.opacity = '1';
                }
            });
            
            // Pause on hover, resume on mouse leave
            testimonialCarouselEl.addEventListener('mouseenter', function() {
                testimonialCarousel.pause();
            });
            
            testimonialCarouselEl.addEventListener('mouseleave', function() {
                testimonialCarousel.cycle();
            });
        }
        
        // Handle image loading errors
        const serviceImages = document.querySelectorAll('.service-image img');
        serviceImages.forEach(function(img) {
            img.addEventListener('error', function() {
                console.log('Image failed to load:', this.src);
                // Create a fallback placeholder
                this.style.background = 'linear-gradient(135deg, #f8f9fa, #e9ecef)';
                this.style.display = 'flex';
                this.style.alignItems = 'center';
                this.style.justifyContent = 'center';
                this.style.color = '#6c757d';
                this.style.fontSize = '14px';
                this.alt = 'Image loading...';
            });
            
            img.addEventListener('load', function() {
                console.log('Image loaded successfully:', this.src);
            });
        });

        // Solar Calculator functionality
        console.log('Initializing calculator...');
        initializeCalculator();
    });

    // Solar Calculator Functions
    function initializeCalculator() {
        const monthlyBillInput = document.getElementById('monthlyBill');
        const inputTypeRadios = document.querySelectorAll('input[name="inputType"]');
        const tabButtons = document.querySelectorAll('.tab-btn');
        
        // Check if calculator elements exist
        if (!monthlyBillInput) {
            console.warn('Calculator input not found');
            return;
        }
        
        // Add event listeners
        monthlyBillInput.addEventListener('input', calculateSolar);
        inputTypeRadios.forEach(radio => {
            radio.addEventListener('change', calculateSolar);
        });
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                calculateSolar();
            });
        });
        
        // Initial calculation
        calculateSolar();
    }

    function calculateSolar() {
        try {
            console.log('calculateSolar called');
            const monthlyBillInput = document.getElementById('monthlyBill');
            const inputTypeRadios = document.querySelectorAll('input[name="inputType"]:checked');
            const activeTabElement = document.querySelector('.tab-btn.active');
            
            console.log('Elements found:', {
                monthlyBillInput: !!monthlyBillInput,
                inputTypeRadios: inputTypeRadios.length,
                activeTabElement: !!activeTabElement
            });
            
            if (!monthlyBillInput || inputTypeRadios.length === 0 || !activeTabElement) {
                console.warn('Calculator elements not found');
                return;
            }
            
            const monthlyBill = parseFloat(monthlyBillInput.value) || 0;
            const inputType = inputTypeRadios[0].value;
            const activeTab = activeTabElement.dataset.tab;
            
            // Get calculator settings from PHP
            const calculatorSettings = @json($calculatorSettings ?? []);
            console.log('Calculator settings:', calculatorSettings);
            
            // Solar calculation parameters
            const costPerUnit = calculatorSettings.cost_per_unit || 6; // ₹6 per unit
            const unitsPerMonth = monthlyBill / costPerUnit;
            const unitsPerYear = unitsPerMonth * 12;
            
            // System sizing
            const unitsPerKwPerMonth = calculatorSettings.units_per_kw_per_month || 120;
            const systemSize = Math.ceil(unitsPerMonth / unitsPerKwPerMonth);
            const actualSystemSize = Math.max(1, systemSize);
            
            // Calculations
            const annualSavings = monthlyBill * 12;
            const annualEnergy = actualSystemSize * unitsPerKwPerMonth * 12;
            const spacePerKw = calculatorSettings.space_per_kw || 80;
            const spaceRequired = actualSystemSize * spacePerKw;
            
            // Cost calculations
            const costPerWatt = calculatorSettings.cost_per_watt || 50;
            const basePrice = actualSystemSize * 1000 * costPerWatt;
            const subsidyPerWatt = calculatorSettings.subsidy_per_watt || 20;
            const maxSubsidy = calculatorSettings.max_subsidy || 75000;
            const subsidy = Math.min(actualSystemSize * 1000 * subsidyPerWatt, maxSubsidy);
            const nspgDiscountPercentage = calculatorSettings.nspg_discount_percentage || 10;
            const maxNspgDiscount = calculatorSettings.max_nspg_discount || 22000;
            const nspgDiscount = Math.min(basePrice * (nspgDiscountPercentage / 100), maxNspgDiscount);
            const projectCost = basePrice - subsidy - nspgDiscount;
            
            // Update results
            const systemSizeEl = document.getElementById('systemSize');
            const annualSavingsEl = document.getElementById('annualSavings');
            const annualEnergyEl = document.getElementById('annualEnergy');
            const spaceRequiredEl = document.getElementById('spaceRequired');
            const basePriceEl = document.getElementById('basePrice');
            const discountEl = document.getElementById('discount');
            const projectCostEl = document.getElementById('projectCost');
            
            if (systemSizeEl) systemSizeEl.textContent = actualSystemSize + ' kW';
            if (annualSavingsEl) annualSavingsEl.textContent = '₹' + annualSavings.toLocaleString();
            if (annualEnergyEl) annualEnergyEl.textContent = annualEnergy.toLocaleString() + ' Units';
            if (spaceRequiredEl) spaceRequiredEl.textContent = spaceRequired + ' Sqft';
            if (basePriceEl) basePriceEl.textContent = '₹' + basePrice.toLocaleString();
            if (discountEl) discountEl.textContent = '(₹' + subsidy.toLocaleString() + ' + ₹' + nspgDiscount.toLocaleString() + ')';
            if (projectCostEl) projectCostEl.textContent = '= ₹' + projectCost.toLocaleString() + ' (*Tax Extra)';
            
        } catch (error) {
            console.error('Error in calculateSolar:', error);
        }
    }

    function bookConsultation() {
        // You can implement this to redirect to contact form or open a modal
        alert('Thank you for your interest! Our team will contact you soon for a free consultation.');
        // Alternative: window.location.href = '/contact';
    }
</script>
@endpush