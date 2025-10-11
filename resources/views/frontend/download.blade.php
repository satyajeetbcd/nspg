@extends('frontend.layouts.app')

@section('title', 'Download - NSPG Solar | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section download-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-download me-2"></i>
                        Resources
                    </div>
                    <h1 class="hero-title mb-4">
                        Download
                        <span class="text-primary">Resources</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Access our comprehensive collection of solar energy resources, brochures, catalogs, 
                        and technical documents to help you make informed decisions about your solar journey.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">20+</h3>
                                    <p class="stat-label">Resources Available</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">5+</h3>
                                    <p class="stat-label">Document Types</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">100%</h3>
                                    <p class="stat-label">Free Access</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
</section>

<!-- Download Resources Section -->
<section class="py-5 download-resources-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-file-download"></i>
            </div>
            <h2 class="section-title">Downloadable Resources</h2>
            <p class="section-subtitle">Get access to our comprehensive solar energy resources and documentation</p>
        </div>
        
        <div class="row">
            <!-- Brochures -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h3 class="download-title">Company Brochure</h3>
                    <p class="download-description">Comprehensive overview of NSPG's services, capabilities, and solar solutions.</p>
                    <div class="download-info">
                        <span class="file-size">2.5 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-company-brochure.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
            
            <!-- Product Catalog -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="download-title">Product Catalog</h3>
                    <p class="download-description">Detailed catalog of our solar panels, inverters, and complete system packages.</p>
                    <div class="download-info">
                        <span class="file-size">4.2 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-product-catalog.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
            
            <!-- Technical Specifications -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="download-title">Technical Specifications</h3>
                    <p class="download-description">Detailed technical specifications and performance data for all our products.</p>
                    <div class="download-info">
                        <span class="file-size">3.1 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-technical-specs.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
            
            <!-- Installation Guide -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="download-title">Installation Guide</h3>
                    <p class="download-description">Step-by-step installation guide for solar panel systems and components.</p>
                    <div class="download-info">
                        <span class="file-size">5.8 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-installation-guide.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
            
            <!-- Maintenance Manual -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <h3 class="download-title">Maintenance Manual</h3>
                    <p class="download-description">Comprehensive maintenance guide to keep your solar system running efficiently.</p>
                    <div class="download-info">
                        <span class="file-size">2.9 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-maintenance-manual.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
            
            <!-- Warranty Information -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="download-card">
                    <div class="download-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="download-title">Warranty Information</h3>
                    <p class="download-description">Complete warranty terms and conditions for all NSPG products and services.</p>
                    <div class="download-info">
                        <span class="file-size">1.7 MB</span>
                        <span class="file-type">PDF</span>
                    </div>
                    <a href="/downloads/nspg-warranty-info.pdf" class="btn btn-download" download>
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="py-5 quick-links-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-link"></i>
            </div>
            <h2 class="section-title">Quick Links</h2>
            <p class="section-subtitle">Navigate to important sections of our website</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h4 class="link-title">About Us</h4>
                    <p class="link-description">Learn about NSPG's mission, vision, and commitment to solar energy.</p>
                    <a href="{{ route('about') }}" class="btn btn-link">Learn More</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4 class="link-title">Careers</h4>
                    <p class="link-description">Explore career opportunities and join our growing team.</p>
                    <a href="#" class="btn btn-link">View Jobs</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="link-title">Case Studies</h4>
                    <p class="link-description">Read about our successful solar projects and client stories.</p>
                    <a href="{{ route('our-clients') }}" class="btn btn-link">View Cases</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="link-title">Meet Our Team</h4>
                    <p class="link-description">Get to know the experts behind NSPG's success.</p>
                    <a href="{{ route('calculator') }}" class="btn btn-link">NSPG Calculator</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="link-title">Testimonials</h4>
                    <p class="link-description">Read what our satisfied clients say about our services.</p>
                    <a href="{{ route('our-clients') }}" class="btn btn-link">Read Reviews</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="link-title">Partnership</h4>
                    <p class="link-description">Explore partnership opportunities with NSPG.</p>
                    <a href="{{ route('business-and-partnership') }}" class="btn btn-link">Partner With Us</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4 class="link-title">Services</h4>
                    <p class="link-description">Discover our comprehensive solar energy services.</p>
                    <a href="{{ route('services') }}" class="btn btn-link">Our Services</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-link-card">
                    <div class="link-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4 class="link-title">Contact Us</h4>
                    <p class="link-description">Get in touch with our solar energy experts.</p>
                    <a href="{{ route('contact') }}" class="btn btn-link">Contact Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 services-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-solar-panel"></i>
            </div>
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive solar energy solutions for all your needs</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4 class="service-title">Installation & Monitoring</h4>
                    <p class="service-description">Professional installation and continuous monitoring of your solar system.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <h4 class="service-title">After Sales Service</h4>
                    <p class="service-description">Comprehensive after-sales support and maintenance services.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h4 class="service-title">Free Replacement</h4>
                    <p class="service-description">Free replacement of defective components under warranty.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="service-title">Warranty Claims</h4>
                    <p class="service-description">Quick and efficient processing of warranty claims.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="service-title">Energy Equipment</h4>
                    <p class="service-description">Supply of high-quality solar panels, inverters, and accessories.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="service-title">Performance Analysis</h4>
                    <p class="service-description">Regular performance analysis and optimization recommendations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section class="py-5 contact-info-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h2 class="section-title">Contact Us</h2>
            <p class="section-subtitle">Get in touch with our solar energy experts for more information</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-info-card">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">Visit The Office</h6>
                                    <p class="text-muted mb-0">N1/66R-15K, Samne Ghat, Nagwa Lanka, Varanasi, Uttar Pradesh 221005</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">Phone Inquiry</h6>
                                    <p class="text-muted mb-0">+91 99568 93331</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">Send Email</h6>
                                    <p class="text-muted mb-0">infonspg.in@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">Office Hours</h6>
                                    <p class="text-muted mb-0">Monday to Saturday: 09:30 AM - 06:30 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Need More Information?</h2>
                <p class="lead mb-0">Contact our solar energy experts for personalized assistance and detailed information.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section Styles */
.download-hero {
    background: linear-gradient(135deg, rgb(206, 67, 20) 0%, rgb(58, 8, 82) 50%, rgb(135, 56, 32) 100%);
    position: relative;
    overflow: hidden;
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
}

.hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 12px 24px;
    border-radius: 50px;
    color: white;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
    margin: 0 auto;
}

.text-primary {
    color: #FFE0B2 !important;
}

.hero-stats {
    margin-top: 3rem;
}

.stat-item {
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #FF6B35;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    margin: 0;
}

.hero-shapes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 5%;
    animation-delay: 2s;
}

.shape-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    right: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Download Resources Section */
.download-resources-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.section-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #FF6B35;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
}

.download-card {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.download-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.download-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
}

.download-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 1rem;
}

.download-description {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

.download-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    font-size: 0.9rem;
    color: #64748b;
}

.file-size {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
    padding: 4px 12px;
    border-radius: 15px;
    font-weight: 600;
}

.file-type {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
    padding: 4px 12px;
    border-radius: 15px;
    font-weight: 600;
}

.btn-download {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
    color: white;
    text-decoration: none;
    display: inline-block;
}

.btn-download:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, #FF5722, #E64A19);
    color: white;
}

/* Quick Links Section */
.quick-links-section {
    background: white;
    position: relative;
}

.quick-link-card {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.quick-link-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.link-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
}

.link-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 1rem;
}

.link-description {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.btn-link {
    background: transparent;
    border: 2px solid #FF6B35;
    color: #FF6B35;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-link:hover {
    background: #FF6B35;
    color: white;
    transform: translateY(-2px);
}

/* Services Section */
.services-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    position: relative;
}

.service-card {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.service-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
}

.service-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 1rem;
}

.service-description {
    color: #64748b;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Contact Info Section */
.contact-info-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.contact-info-card {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
    overflow: hidden;
}

.contact-info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #FF6B35, #FF8A65, #FFAB91);
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    padding: 1.5rem;
    background: rgba(255, 107, 53, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(255, 107, 53, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    height: 100%;
}

.contact-item:hover {
    background: rgba(255, 107, 53, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.15);
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
}

.contact-details h6 {
    color: #FF6B35;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.contact-details p {
    color: #64748b;
    margin: 0;
    line-height: 1.6;
}

/* CTA Section Enhancement */
.bg-primary {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%) !important;
    position: relative;
    overflow: hidden;
}

.bg-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.btn-warning {
    background: linear-gradient(135deg, #FF6B35, #FF5722);
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
}

.btn-warning:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, #FF5722, #E64A19);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .download-card {
        padding: 2rem;
    }
    
    .quick-link-card, .service-card {
        padding: 1.5rem;
    }
    
    .contact-info-card {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .download-card {
        padding: 1.5rem;
    }
    
    .quick-link-card, .service-card {
        padding: 1rem;
    }
    
    .contact-info-card {
        padding: 1.5rem;
    }
    
    .download-title, .link-title, .service-title {
        font-size: 1.2rem;
    }
}
</style>
@endpush
