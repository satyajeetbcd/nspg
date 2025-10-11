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
        margin-top: 600px;
    }

}

/* Calculator Input Width Responsive */
@media (max-width: 768px) {
    .input-wrapper,
    .input-wrapper .form-control {
        max-width: 400px;
    }
    .marginset {
        margin-top: 600px;
    }
}

@media (max-width: 576px) {
    .input-wrapper,
    .input-wrapper .form-control {
        max-width: 100%;
    }   
    .marginset {
        margin-top: 600px;
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
                                    निर्मला सोलर पावर जनरेशन
                                        <span class="private-limited">प्राइवेट लिमिटेड</span>
                                    </h1>
                                    
                                    <!-- Company Description -->
                                    <div class="company-description mb-4">
                                        <p class="lead">ईपीसी कंपनी की स्थापना 2015 में की गई थी, जो छत और ज़मीन पर लगाए जाने वाले दोनों प्रकार के सोलर प्रोजेक्ट्स के लिए समाधान प्रदान करती है। हम सौर ऊर्जा का कुशल और किफायती उपयोग करते हुए पर्यावरण के अनुकूल समाधान प्रदान करते हैं, जो उच्च निवेश प्रतिफल (ROI) सुनिश्चित करते हैं।</p>
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
                                        <h2>प्रधानमंत्री सूर्य घर मुफ्त बिजली योजना</h2>
                                        <p>अपना घर, अपनी बिजली
                                        25 साल तक बिजली बिल से मुक्त</p>
                                    </div>
                                    
                                    <!-- Benefits -->
                                    <div class="benefits-features">
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>25 साल वारंटी</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-leaf"></i>
                                            <span>पर्यावरण अनुकूल</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-bolt"></i>
                                            <span>नवीकरणीय ऊर्जा</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-charging-station"></i>
                                            <span>तेज चार्जिंग</span>
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
                                <div class="banner-content ">
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
                                <div class="banner-content" style="margin-top: 200px;">
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

        
        <!-- Solar System Working Principle Section -->
<section class="solar-principle-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <!-- Header Benefits -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="benefit-card text-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; border-radius: 10px;">
                    <h5 class="mb-2">सोलर पावरपैक पर 60% तक की सब्सिडी</h5>
                    <p class="mb-0" style="color: white;">Up to 60% subsidy on Solar Powerpack</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="benefit-card text-center" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 20px; border-radius: 10px;">
                    <h5 class="mb-2">अगले 25 सालों तक प्रतिमाह बिजली बिल की बचत</h5>
                    <p class="mb-0" style="color: white;">Monthly electricity bill savings for the next 25 years</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="benefit-card text-center" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); color: white; padding: 20px; border-radius: 10px;">
                    <h5 class="mb-2">बिजली की बढ़ती दरों से मुक्ति का आनन्द लें</h5>
                    <p class="mb-0" style="color: white;">Enjoy freedom from rising electricity rates</p>
                </div>
            </div>
        </div>

        <!-- Main Title -->
        <div class="text-center mb-5">
            <h2 class="section-title" style="color: #1e3a8a; font-weight: 800;">ग्रिड संयोजित सोलर सिस्टम की कार्यप्रणाली</h2>
            <p class="section-subtitle" style="color: #6c757d; font-size: 1.2rem;">Working Principle of Grid-Connected Solar System</p>
        </div>

        <!-- Working Process -->
                        <div class="row">
            <div class="col-12">
                <div class="process-flow-container">
                    <!-- Step 1: Solar Panels -->
                    <div class="process-step-card">
                        <div class="step-header">
                            <div class="step-number-badge">
                                <span class="step-number">01</span>
                                </div>
                            <div class="step-title-section">
                                <h3 class="step-title">Solar Panels</h3>
                                <div class="step-icon-large">
                                    <i class="fas fa-solar-panel"></i>
                            </div>
                                </div>
                            </div>
                        <div class="step-content-body">
                            <div class="step-description">
                                <p class="hindi-text">सोलर ऐरे सूर्य के प्रकाश को उर्जा से बिजली में परिवर्तित करती है।</p>
                                <p class="english-text">Solar array converts sunlight into electricity.</p>
                        </div>
                            <div class="step-flow-indicator">
                                <div class="flow-arrow">
                                    <i class="fas fa-arrow-right"></i>
                    </div>
                                <div class="flow-label">DC</div>
                            </div>
                            </div>
                        </div>

                    <!-- Step 2: Inverter -->
                    <div class="process-step-card">
                        <div class="step-header">
                            <div class="step-number-badge">
                                <span class="step-number">02</span>
                            </div>
                            <div class="step-title-section">
                                <h3 class="step-title">Solar Inverter</h3>
                                <div class="step-icon-large">
                                    <i class="fas fa-microchip"></i>
                            </div>
                        </div>
                            </div>
                        <div class="step-content-body">
                            <div class="step-description">
                                <p class="hindi-text">ऐरे द्वारा उत्पादित बिजली को इन्वर्टर डायरेक्ट करंट (DC) से अल्टरनेटिंग करंट (AC) में परिवर्तित करती है।</p>
                                <p class="english-text">The inverter converts electricity from Direct Current (DC) to Alternating Current (AC).</p>
                            </div>
                            <div class="step-flow-indicator">
                                <div class="flow-arrow">
                                    <i class="fas fa-arrow-right"></i>
                        </div>
                                <div class="flow-label">AC</div>
                    </div>
                        </div>
                    </div>

                    <!-- Step 3: Electrical Appliances -->
                    <div class="process-step-card">
                        <div class="step-header">
                            <div class="step-number-badge">
                                <span class="step-number">03</span>
                            </div>
                            <div class="step-title-section">
                                <h3 class="step-title">Electrical Appliances</h3>
                                <div class="step-icon-large">
                                    <i class="fas fa-home"></i>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-body">
                            <div class="step-description">
                                <p class="hindi-text">एसी करंट तब मेन स्विच को जाता है और घर के उपकरणों को बिजली प्रदान करता है</p>
                                <p class="english-text">AC current then goes to the main switch and powers electrical appliances.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Net Meter -->
                    <div class="process-step-card">
                        <div class="step-header">
                            <div class="step-number-badge">
                                <span class="step-number">04</span>
                            </div>
                            <div class="step-title-section">
                                <h3 class="step-title">Bi-directional Solar Meter</h3>
                                <div class="step-icon-large">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-body">
                            <div class="step-description">
                                <p class="hindi-text">नेट मीटर उपयोग मे ली गई उर्जा व उत्पादित अतिरिक्त एनर्जी दर्शाता है।</p>
                                <p class="english-text">Net meter shows energy consumed and additional energy produced.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Grid Connection -->
                    <div class="process-step-card">
                        <div class="step-header">
                            <div class="step-number-badge">
                                <span class="step-number">05</span>
                            </div>
                            <div class="step-title-section">
                                <h3 class="step-title">Utility Grid</h3>
                                <div class="step-icon-large">
                                    <i class="fas fa-plug"></i>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-body">
                            <div class="step-description">
                                <p class="hindi-text">अतिरिक्त बिजली ग्रिड में चली जाती है। सोलर की उपलब्धता कम होने से उत्पादन नहीं होता। तब ग्रिड से उर्जा का आयात होता है।</p>
                                <p class="english-text">Excess electricity goes to the grid. When solar availability is low, energy is imported from the grid.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Component Legend -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="component-legend">
                    <h4 class="mb-4" style="color: #1e3a8a;">Component Legend</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="legend-item mb-2">
                                <span class="legend-letter">A</span>
                                <span>सोलर पेनल्स (Solar Panels)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">B</span>
                                <span>माउंटिंग स्ट्रक्चर (Mounting Structure)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">C</span>
                                <span>इंटरैक्टिव इनवर्टर (Interactive Inverter)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">D</span>
                                <span>मैन स्विच (Main Switch)</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="legend-item mb-2">
                                <span class="legend-letter">E</span>
                                <span>कांसुमेर लोड (Consumer Load)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">F</span>
                                <span>नेट मीटर (Net Meter)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">G</span>
                                <span>ग्रिड यूटिलिटी (Grid Utility)</span>
                            </div>
                            <div class="legend-item mb-2">
                                <span class="legend-letter">H</span>
                                <span>सर्ज/स्पाइक अरेस्टर (Surge/Spike Arrester)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="additional-benefits">
                    <h4 class="mb-4" style="color: #1e3a8a;">Key Benefits</h4>
                    <div class="benefit-item mb-3">
                        <i class="fas fa-recycle" style="color: #059669; font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>लंबा जीवन (Long Life)</span>
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="fas fa-award" style="color: #f7931e; font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>गुणवत्ता आश्वासन (Quality Assurance)</span>
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="fas fa-cog" style="color: #1e3a8a; font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>लगाने में आसान (Easy to Install)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <!-- <div class="text-center mt-5">
            <a href="{{ route('about') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-info-circle me-2"></i>
                Learn More About NSPG
                        </a>
                    </div>a -->
                    </div>
</section>

<!-- Government Subsidy Section -->
<section class="subsidy-section py-5" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge" style="background: white; color: #ff6b35;">Government Subsidies</span>
            <h2 class="section-title" style="color: white;">सरकारी अनुदान</h2>
            <p class="section-description" style="color: white; opacity: 0.9;">सोलर रूफटॉप संयंत्र के लिए उपलब्ध सरकारी सब्सिडी</p>
                </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="subsidy-container">
                    <!-- Central Government Subsidy -->
                    <div class="subsidy-card mb-4">
                        <div class="subsidy-header">
                            <h3 class="subsidy-title">घरेलू ग्रिड संयोजित सोलर रूफटॉप संयंत्र हेतु केन्द्र सरकार द्वारा देय अनुदान</h3>
            </div>
                        <div class="subsidy-table-container">
                            <table class="subsidy-table">
                                <thead>
                                    <tr>
                                        <th>क्रमांक</th>
                                        <th>संयंत्र क्षमता</th>
                                        <th>लागू सब्सिडी</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td><strong>1kW क्षमता तक</strong></td>
                                        <td><strong>रू. 30,000/-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>02</td>
                                        <td><strong>2kW क्षमता तक</strong></td>
                                        <td><strong>रू. 60,000/-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>03</td>
                                        <td><strong>3kW क्षमता तक</strong></td>
                                        <td><strong>रू. 78,000/-</strong><br><small>अधिकतम निर्धारित</small></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                        </div>
                    
                    <!-- State Government Subsidy -->
                    <div class="subsidy-card state-subsidy">
                        <div class="subsidy-header state-header">
                            <h3 class="subsidy-title">राज्य सरकार द्वारा देय अनुदान</h3>
                    </div>
                        <div class="subsidy-content">
                            <p class="subsidy-text">
                                <strong>आवासीय रूफटॉप संयंत्रो हेतु उ.प्र. सौर ऊर्जा नीति 2022 के अन्तर्गत रु. 15,000 प्रति kW, अधिकतम रु. 30,000 अनुदान केन्द्र सरकार के अतिरिक्त देय है।</strong>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Total Savings Highlight -->
                    <div class="savings-highlight">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="savings-item">
                                    <h4>3kW सिस्टम</h4>
                                    <p>कुल अनुदान</p>
                                    <span class="savings-amount">रू. 1,08,000/-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="savings-item">
                                    <h4>2kW सिस्टम</h4>
                                    <p>कुल अनुदान</p>
                                    <span class="savings-amount">रू. 90,000/-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="savings-item">
                                    <h4>1kW सिस्टम</h4>
                                    <p>कुल अनुदान</p>
                                    <span class="savings-amount">रू. 45,000/-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('contact') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            मुफ्त सलाह लें
                        </a>
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
                        <img src="/images/services/rooftop-residential.svg" alt="Rooftop Residential Solar" class="img-fluid">
                    </div>
                    <h4>Rooftop Residential</h4>
                    <p>Specialized solar solutions for residential rooftops, designed to maximize energy generation while maintaining aesthetic appeal and structural integrity.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/offgrid-solar.svg" alt="Offgrid Solar Solutions" class="img-fluid">
                    </div>
                    <h4>Offgrid</h4>
                    <p>Complete off-grid solar systems with battery storage for areas without grid connectivity, ensuring reliable power supply 24/7.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/hybrid-solar.svg" alt="Hybrid Solar Systems" class="img-fluid">
                    </div>
                    <h4>Hybrid</h4>
                    <p>Advanced hybrid solar systems combining grid-tied and battery backup capabilities for maximum energy independence and cost savings.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card ">
                    <div class="service-image">
                        <img src="/images/services/aata-chakki.svg" alt="Aata Chakki Solar" class="img-fluid">
                    </div>
                    <h4>Aata Chakki</h4>
                    <p>Solar-powered flour mills (Aata Chakki) providing clean energy solutions for traditional grain processing with significant cost savings.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/hospital-solar.svg" alt="Hospital Solar Solutions" class="img-fluid">
                    </div>
                    <h4>Hospital</h4>
                    <p>Critical power solutions for healthcare facilities ensuring uninterrupted medical services with reliable solar energy and backup systems.</p>
                    <a href="{{ route('services') }}" class="service-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="service-card">
                    <div class="service-image">
                        <img src="/images/services/commercial-solar.svg" alt="College Hotel Restaurant Petrol Pump Solar" class="img-fluid">
                    </div>
                    <h4>College + Hotel & Restaurant, Petrol Pump</h4>
                    <p>Comprehensive solar solutions for educational institutions, hospitality sector, and fuel stations with customized energy management systems.</p>
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
<!-- Our Branches Section -->
<section class="branches-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Our Branches</span>
            <h2 class="section-title">Serving Across Uttar Pradesh</h2>
            <p class="section-description">We have established our presence in key cities to serve you better</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="fas fa-map-marker-alt"></i>
                            </div>
                    <div class="branch-content">
                        <h4 class="branch-name">Prayagraj</h4>
                        <p class="branch-description">Our main branch serving the holy city of Prayagraj and surrounding areas</p>
                        <div class="branch-features">
                            <span class="feature-tag">Installation</span>
                            <span class="feature-tag">Maintenance</span>
                            <span class="feature-tag">Support</span>
                        </div>
                    </div>
                            </div>
                        </div>
                        
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="fas fa-map-marker-alt"></i>
                            </div>
                    <div class="branch-content">
                        <h4 class="branch-name">Gorakhpur</h4>
                        <p class="branch-description">Expanding our services to Gorakhpur and eastern Uttar Pradesh region</p>
                        <div class="branch-features">
                            <span class="feature-tag">Installation</span>
                            <span class="feature-tag">Maintenance</span>
                            <span class="feature-tag">Support</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="branch-content">
                        <h4 class="branch-name">Ayodhya</h4>
                        <p class="branch-description">Serving the sacred city of Ayodhya and nearby districts</p>
                        <div class="branch-features">
                            <span class="feature-tag">Installation</span>
                            <span class="feature-tag">Maintenance</span>
                            <span class="feature-tag">Support</span>
                        </div>
                    </div>
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
            @forelse($projects as $project)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        @if($project->image_path)
                            <img src="{{ asset('/' . $project->image_path) }}" 
                                 alt="{{ $project->image_alt ?: $project->title }}" class="img-fluid">
                        @else
                            <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                                 alt="{{ $project->title }}" class="img-fluid">
                        @endif
                        <div class="project-overlay">
                            <a href="#" class="project-link" data-bs-toggle="modal" data-bs-target="#projectModal{{ $project->id }}">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                        @if($project->is_featured)
                            <div class="project-badge">
                                <span class="badge bg-warning">Featured</span>
                            </div>
                        @endif
                    </div>
                    <div class="project-content">
                        <h5>{{ $project->title }}</h5>
                        <p class="project-location">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $project->location }}
                        </p>
                        @if($project->capacity)
                            <p class="project-capacity">
                                <i class="fas fa-bolt me-1"></i>
                                {{ $project->capacity }}
                            </p>
                        @endif
                        @if($project->description)
                            <p class="project-description">{{ Str::limit($project->description, 80) }}</p>
                        @endif
                        <div class="project-meta">
                            <span class="badge bg-info">{{ $project->project_type_label }}</span>
                            @if($project->cost)
                                <span class="project-cost">{{ $project->formatted_cost }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Modal -->
            <div class="modal fade" id="projectModal{{ $project->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $project->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($project->image_path)
                                        <img src="{{ asset('/' . $project->image_path) }}" 
                                             alt="{{ $project->image_alt ?: $project->title }}" class="img-fluid rounded">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                                             alt="{{ $project->title }}" class="img-fluid rounded">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Project Details</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Type:</strong> {{ $project->project_type_label }}</li>
                                        <li><strong>Location:</strong> {{ $project->location }}</li>
                                        @if($project->capacity)
                                            <li><strong>Capacity:</strong> {{ $project->capacity }}</li>
                                        @endif
                                        @if($project->cost)
                                            <li><strong>Cost:</strong> {{ $project->formatted_cost }}</li>
                                        @endif
                                        @if($project->installation_date)
                                            <li><strong>Installation Date:</strong> {{ $project->formatted_installation_date }}</li>
                                        @endif
                                    </ul>
                                    
                                    @if($project->description)
                                        <h6>Description</h6>
                                        <p>{{ $project->description }}</p>
                                    @endif
                                    
                                    @if($project->features && count($project->features) > 0)
                                        <h6>Project Features</h6>
                                        <ul>
                                            @foreach($project->features as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="{{ route('contact') }}" class="btn btn-primary">Get Quote for Similar Project</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-solar-panel fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No projects available</h5>
                    <p class="text-muted">Check back soon for our latest solar installations.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-primary">
                View All Projects <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div> -->
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

/* Stop rotation animation for Aata Chakki card */
.aata-chakki-card .service-image img {
    animation: none !important;
    transform: none !important;
    transition: transform 0.3s ease !important;
}

.aata-chakki-card:hover .service-image img {
    transform: scale(1.05) !important;
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

/* Branches Section */
.branches-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.branch-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.branch-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
}

.branch-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.branch-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 2rem;
    color: white;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
    transition: all 0.3s ease;
}

.branch-card:hover .branch-icon {
    transform: scale(1.1);
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.4);
}

.branch-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
    position: relative;
}

.branch-name::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    border-radius: 2px;
}

.branch-description {
    color: var(--text-light);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 25px;
}

.branch-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
}

.feature-tag {
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
    transition: all 0.3s ease;
}

.feature-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
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

/* Solar Principle Section */
.solar-principle-section {
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.process-flow-container {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
}

.process-step-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.process-step-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(255, 107, 53, 0.2);
}

.step-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.step-number-badge {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 25px;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
}

.step-number {
    color: white;
    font-size: 1.8rem;
    font-weight: 900;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.step-title-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex: 1;
}

.step-title {
    color: #1e3a8a;
    font-weight: 800;
    font-size: 1.8rem;
    margin: 0;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.step-icon-large {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.step-icon-large i {
    font-size: 2rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.step-content-body {
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.step-description {
    flex: 1;
    margin-right: 30px;
}

.hindi-text {
    font-size: 1.2rem;
    color: #2d3748;
    font-weight: 600;
    line-height: 1.7;
    margin-bottom: 12px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.english-text {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
    line-height: 1.6;
    margin: 0;
    font-style: italic;
}

.step-flow-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
}

.flow-arrow {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    animation: pulse 2s infinite;
}

.flow-arrow i {
    font-size: 1.5rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.flow-label {
    background: #f8f9fa;
    color: #6c757d;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 700;
    border: 2px solid #e9ecef;
    text-transform: uppercase;
    letter-spacing: 1px;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }
}

.component-legend {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.legend-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.legend-item:hover {
    background-color: #f8f9fa;
}

.legend-letter {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 15px;
    flex-shrink: 0;
}

.additional-benefits {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.benefit-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 10px;
    transition: background-color 0.3s ease;
}

.benefit-item:hover {
    background-color: #f8f9fa;
}

/* Responsive Design for Solar Principle Section */
@media (max-width: 768px) {
    .solar-principle-section {
        padding: 60px 0;
    }
    
    .process-flow-container {
        max-width: 100%;
        padding: 0 15px;
    }
    
    .process-step-card {
        margin-bottom: 25px;
    }
    
    .step-header {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .step-number-badge {
        margin-right: 0;
        margin-bottom: 20px;
        width: 60px;
        height: 60px;
    }
    
    .step-number {
        font-size: 1.5rem;
    }
    
    .step-title-section {
        flex-direction: column;
        align-items: center;
    }
    
    .step-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    
    .step-icon-large {
        width: 50px;
        height: 50px;
    }
    
    .step-icon-large i {
        font-size: 1.5rem;
    }
    
    .step-content-body {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .step-description {
        margin-right: 0;
        margin-bottom: 20px;
    }
    
    .hindi-text {
        font-size: 1.1rem;
    }
    
    .english-text {
        font-size: 0.95rem;
    }
    
    .step-flow-indicator {
        margin-top: 15px;
    }
    
    .flow-arrow {
        width: 45px;
        height: 45px;
    }
    
    .flow-arrow i {
        font-size: 1.3rem;
    }
    
    .component-legend,
    .additional-benefits {
        padding: 20px;
        margin-bottom: 20px;
    }
}

@media (max-width: 576px) {
    .solar-principle-section {
        padding: 40px 0;
    }
    
    .process-flow-container {
        padding: 0 10px;
    }
    
    .process-step-card {
        margin-bottom: 20px;
        border-radius: 15px;
    }
    
    .step-header {
        padding: 15px;
    }
    
    .step-number-badge {
        width: 50px;
        height: 50px;
        margin-bottom: 15px;
    }
    
    .step-number {
        font-size: 1.2rem;
    }
    
    .step-title {
        font-size: 1.3rem;
        margin-bottom: 10px;
    }
    
    .step-icon-large {
        width: 40px;
        height: 40px;
        border-radius: 10px;
    }
    
    .step-icon-large i {
        font-size: 1.2rem;
    }
    
    .step-content-body {
        padding: 15px;
    }
    
    .hindi-text {
        font-size: 1rem;
        margin-bottom: 10px;
    }
    
    .english-text {
        font-size: 0.9rem;
    }
    
    .flow-arrow {
        width: 40px;
        height: 40px;
    }
    
    .flow-arrow i {
        font-size: 1.1rem;
    }
    
    .flow-label {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .component-legend,
    .additional-benefits {
        padding: 15px;
    }
    
    .legend-item {
        padding: 8px;
    }
    
    .legend-letter {
        width: 25px;
        height: 25px;
        font-size: 0.9rem;
    }
}

/* Government Subsidy Section */
.subsidy-section {
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.subsidy-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    pointer-events: none;
}

.subsidy-container {
    position: relative;
    z-index: 2;
}

.subsidy-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.subsidy-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.subsidy-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 20px;
    text-align: center;
}

.state-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
}

.subsidy-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.4;
}

.subsidy-table-container {
    padding: 0;
    overflow-x: auto;
}

.subsidy-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.subsidy-table thead {
    background: #f8f9fa;
}

.subsidy-table th {
    padding: 15px 10px;
    text-align: center;
    font-weight: 700;
    color: #1e3a8a;
    border-bottom: 2px solid #1e3a8a;
    font-size: 0.9rem;
}

.subsidy-table td {
    padding: 15px 10px;
    text-align: center;
    border-bottom: 1px solid #e9ecef;
    font-size: 0.9rem;
}

.subsidy-table tbody tr:hover {
    background: #f8f9fa;
}

.subsidy-table tbody tr:last-child td {
    border-bottom: none;
}

.subsidy-content {
    padding: 25px;
}

.subsidy-text {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #333;
    margin: 0;
    text-align: center;
}

.savings-highlight {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-top: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.savings-item {
    text-align: center;
    padding: 20px 10px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    margin-bottom: 15px;
    transition: transform 0.3s ease;
}

.savings-item:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
}

.savings-item h4 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 10px;
}

.savings-item p {
    color: #6c757d;
    margin-bottom: 10px;
    font-size: 0.9rem;
}

.savings-amount {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ff6b35;
    display: block;
}

/* Responsive Design for Subsidy Section */
@media (max-width: 768px) {
    .subsidy-section {
        padding: 60px 0;
    }
    
    .subsidy-title {
        font-size: 1rem;
    }
    
    .subsidy-table th,
    .subsidy-table td {
        padding: 10px 5px;
        font-size: 0.8rem;
    }
    
    .subsidy-text {
        font-size: 1rem;
    }
    
    .savings-highlight {
        padding: 20px;
    }
    
    .savings-item {
        padding: 15px 5px;
        margin-bottom: 10px;
    }
    
    .savings-item h4 {
        font-size: 1.1rem;
    }
    
    .savings-amount {
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .subsidy-section {
        padding: 40px 0;
    }
    
    .subsidy-card {
        margin-bottom: 20px;
    }
    
    .subsidy-header {
        padding: 15px;
    }
    
    .subsidy-title {
        font-size: 0.9rem;
    }
    
    .subsidy-content {
        padding: 20px;
    }
    
    .subsidy-text {
        font-size: 0.9rem;
    }
    
    .savings-highlight {
        padding: 15px;
    }
    
    .savings-item {
        padding: 12px 5px;
    }
    
    .savings-item h4 {
        font-size: 1rem;
    }
    
    .savings-amount {
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
    .branches-section,
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
    
    /* Branches Section Mobile */
    .branch-card {
        padding: 30px 20px;
        margin-bottom: 20px;
    }
    
    .branch-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    
    .branch-name {
        font-size: 1.5rem;
        margin-bottom: 12px;
    }
    
    .branch-description {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    .feature-tag {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
    
    /* Branches Section Extra Small */
    .branch-card {
        padding: 25px 15px;
    }
    
    .branch-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .branch-name {
        font-size: 1.3rem;
    }
    
    .branch-description {
        font-size: 0.85rem;
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
    .branches-section,
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

<!-- Diwali Offer Banner -->
<div class="diwali-offer-banner" id="diwaliOfferBanner">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="offer-content">
                    <div class="offer-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="offer-text">
                        <h4 class="offer-title">🎉 Diwali Special Offer</h4>
                        <p class="offer-description">Get <span class="discount-highlight">10% OFF</span> on all solar installations this festive season!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 text-end">
                <div class="offer-actions">
                    <a href="{{ route('contact') }}" class="btn btn-offer-primary">
                        <i class="fas fa-phone me-2"></i>
                        Book Now
                    </a>
                    <button class="btn btn-offer-secondary" onclick="closeDiwaliOffer()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="offer-decoration">
        <div class="firework firework-1"></div>
        <div class="firework firework-2"></div>
        <div class="firework firework-3"></div>
    </div>
</div>

<style>
/* Diwali Offer Banner Styles */
.diwali-offer-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 25%, #ffa726 50%, #ffb74d 75%, #ffcc80 100%);
    color: white;
    padding: 15px 0;
    z-index: 9999;
    box-shadow: 0 -5px 20px rgba(255, 107, 53, 0.3);
    border-top: 3px solid #e65100;
    animation: slideUpBounce 0.8s ease-out;
    font-family: 'Poppins', sans-serif;
}

@keyframes slideUpBounce {
    0% {
        transform: translateY(100%);
        opacity: 0;
    }
    60% {
        transform: translateY(-10px);
        opacity: 1;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.offer-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.offer-icon {
    font-size: 2.5rem;
    animation: pulse 2s infinite;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.offer-text {
    flex: 1;
}

.offer-title {
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.5px;
}

.offer-description {
    font-size: 1rem;
    margin: 0;
    opacity: 0.95;
    font-weight: 500;
}

.discount-highlight {
    background: linear-gradient(45deg, #ff1744, #ff5722);
    color: white;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 800;
    font-size: 1.1em;
    text-shadow: none;
    box-shadow: 0 2px 8px rgba(255, 23, 68, 0.4);
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from {
        box-shadow: 0 2px 8px rgba(255, 23, 68, 0.4);
    }
    to {
        box-shadow: 0 4px 16px rgba(255, 23, 68, 0.6);
    }
}

.offer-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: flex-end;
}

.btn-offer-primary {
    background: linear-gradient(45deg, #e65100, #ff5722);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(230, 81, 0, 0.3);
    font-size: 0.95rem;
}

.btn-offer-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(230, 81, 0, 0.4);
    color: white;
    text-decoration: none;
}

.btn-offer-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    padding: 8px 12px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-offer-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: scale(1.1);
}

.offer-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.firework {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #fff;
    border-radius: 50%;
    animation: fireworkAnimation 3s infinite;
}

.firework-1 {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.firework-2 {
    top: 30%;
    right: 15%;
    animation-delay: 1s;
}

.firework-3 {
    top: 40%;
    left: 50%;
    animation-delay: 2s;
}

@keyframes fireworkAnimation {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    50% {
        transform: scale(1);
        opacity: 0.8;
    }
    100% {
        transform: scale(0);
        opacity: 0;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .diwali-offer-banner {
        padding: 12px 0;
    }
    
    .offer-content {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .offer-icon {
        font-size: 2rem;
    }
    
    .offer-title {
        font-size: 1.2rem;
    }
    
    .offer-description {
        font-size: 0.9rem;
    }
    
    .offer-actions {
        justify-content: center;
        margin-top: 10px;
    }
    
    .btn-offer-primary {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .offer-text {
        text-align: center;
    }
    
    .offer-title {
        font-size: 1.1rem;
    }
    
    .offer-description {
        font-size: 0.85rem;
    }
    
    .discount-highlight {
        font-size: 1em;
        padding: 1px 6px;
    }
}

/* Project Cards Styles */
.project-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.project-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.05);
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
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
    transition: transform 0.3s ease;
}

.project-link:hover {
    color: var(--primary-orange);
    transform: scale(1.1);
}

.project-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
}

.project-content {
    padding: 20px;
}

.project-content h5 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.project-location,
.project-capacity {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.project-description {
    color: #777;
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.4;
}

.project-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.project-cost {
    color: var(--primary-orange);
    font-weight: 600;
    font-size: 0.9rem;
}

/* Project Modal Styles */
.project-modal .modal-content {
    border-radius: 12px;
    border: none;
}

.project-modal .modal-header {
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    color: white;
    border-radius: 12px 12px 0 0;
}

.project-modal .modal-header .btn-close {
    filter: invert(1);
}

.project-modal .modal-body h6 {
    color: var(--primary-orange);
    font-weight: 600;
    margin-top: 15px;
    margin-bottom: 10px;
}

.project-modal .modal-body ul li {
    margin-bottom: 5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .project-image {
        height: 180px;
    }
    
    .project-content {
        padding: 15px;
    }
    
    .project-meta {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
function closeDiwaliOffer() {
    const banner = document.getElementById('diwaliOfferBanner');
    banner.style.animation = 'slideDown 0.5s ease-in forwards';
    setTimeout(() => {
        banner.style.display = 'none';
    }, 500);
}

// Add slide down animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>