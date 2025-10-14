@extends('frontend.layouts.app')

@section('title', 'Our Clients - NSPG Solar | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section clients-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-users me-2"></i>
                        Client Success
                    </div>
                    <h1 class="hero-title mb-4">
                        Our Valued
                        <span class="text-primary">Clients</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Discover the success stories of our satisfied clients who have made the switch to clean, 
                        renewable solar energy with NSPG. Their trust drives our commitment to excellence.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">4200+</h3>
                                    <p class="stat-label">Happy Clients</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">10MW+</h3>
                                    <p class="stat-label">Solar Capacity</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">96%</h3>
                                    <p class="stat-label">Satisfaction Rate</p>
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

<!-- Client Projects Section -->
<section class="py-5 client-projects-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-solar-panel"></i>
            </div>
            <h2 class="section-title">Client Projects</h2>
            <p class="section-subtitle">Showcasing our successful solar installations across various sectors</p>
        </div>
        
        <div class="row">
            <!-- Residential Projects -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/residential-project-1.jpg" alt="Residential Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Residential Project</h4>
                                <p>5 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Residential</div>
                        <h3 class="project-title">Mr. Rajesh Kumar</h3>
                        <p class="project-location">Varanasi, Uttar Pradesh</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>5 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2023</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>40% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Commercial Project -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/commercial-project-1.jpg" alt="Commercial Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Commercial Project</h4>
                                <p>25 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Commercial</div>
                        <h3 class="project-title">ABC Industries Ltd.</h3>
                        <p class="project-location">Noida, Uttar Pradesh</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>25 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2023</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>60% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Industrial Project -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/industrial-project-1.jpg" alt="Industrial Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Industrial Project</h4>
                                <p>100 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Industrial</div>
                        <h3 class="project-title">XYZ Manufacturing</h3>
                        <p class="project-location">Prayagraj, Uttar Pradesh</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>100 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2024</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>70% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Educational Institution -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/educational-project-1.jpg" alt="Educational Institution Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Educational Project</h4>
                                <p>15 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Educational</div>
                        <h3 class="project-title">Delhi Public School</h3>
                        <p class="project-location">Delhi, NCR</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>15 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2023</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>50% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Healthcare Facility -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/healthcare-project-1.jpg" alt="Healthcare Facility Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Healthcare Project</h4>
                                <p>30 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Healthcare</div>
                        <h3 class="project-title">City Hospital</h3>
                        <p class="project-location">Lucknow, Uttar Pradesh</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>30 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2024</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>55% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Government Office -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="/images/government-project-1.jpg" alt="Government Office Solar Project" class="img-fluid">
                        <div class="project-overlay">
                            <div class="overlay-content">
                                <h4>Government Project</h4>
                                <p>50 kW Solar System</p>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <div class="project-badge">Government</div>
                        <h3 class="project-title">District Magistrate Office</h3>
                        <p class="project-location">Varanasi, Uttar Pradesh</p>
                        <div class="project-details">
                            <div class="detail-item">
                                <i class="fas fa-bolt"></i>
                                <span>50 kW Capacity</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Completed 2023</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-chart-line"></i>
                                <span>65% Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonials Section -->
<section class="py-5 testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-quote-left"></i>
            </div>
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Hear from our satisfied customers about their experience with NSPG</p>
        </div>
        
        <div class="row">
            @if(isset($reviews) && $reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="quote-icon">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                <p class="testimonial-text">{{ $review->review }}</p>
                                <div class="testimonial-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="{{ $review->image ? asset('storage/' . $review->image) : '/images/default-avatar.jpg' }}" alt="{{ $review->name }}" class="img-fluid">
                                </div>
                                <div class="author-info">
                                    <h5 class="author-name">{{ $review->name }}</h5>
                                    <p class="author-title">{{ $review->designation ?? 'Client' }}</p>
                                    <p class="author-company">{{ $review->company ?? 'NSPG Client' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default Testimonials -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"NSPG provided excellent service from start to finish. Our solar system has been working perfectly and we've seen significant savings on our electricity bills."</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                            </div>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="/images/client-1.jpg" alt="Client" class="img-fluid">
                            </div>
                            <div class="author-info">
                                <h5 class="author-name">Rajesh Kumar</h5>
                                <p class="author-title">Homeowner</p>
                                <p class="author-company">Varanasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"The team at NSPG is professional and knowledgeable. They helped us choose the right system for our business needs and the installation was completed on time."</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                            </div>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="/images/client-2.jpg" alt="Client" class="img-fluid">
                            </div>
                            <div class="author-info">
                                <h5 class="author-name">Priya Sharma</h5>
                                <p class="author-title">Business Owner</p>
                                <p class="author-company">Noida</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">"We are very satisfied with our solar installation. The system is performing better than expected and the maintenance support is excellent."</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                                <i class="fas fa-star active"></i>
                            </div>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="/images/client-3.jpg" alt="Client" class="img-fluid">
                            </div>
                            <div class="author-info">
                                <h5 class="author-name">Amit Singh</h5>
                                <p class="author-title">Factory Owner</p>
                                <p class="author-company">Prayagraj</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Client Statistics Section -->
<section class="py-5 client-stats-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-chart-bar"></i>
            </div>
            <h2 class="section-title">Our Impact</h2>
            <p class="section-subtitle">Numbers that speak for our success</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stat-number">500+</h3>
                    <p class="stat-label">Satisfied Clients</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-solar-panel"></i>
                    </div>
                    <h3 class="stat-number">50MW+</h3>
                    <p class="stat-label">Solar Capacity Installed</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="stat-number">1000+</h3>
                    <p class="stat-label">Tons CO2 Reduced</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="stat-number">4.9/5</h3>
                    <p class="stat-label">Average Rating</p>
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
            <p class="section-subtitle">Ready to join our family of satisfied clients? Get in touch today</p>
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
                <h2 class="fw-bold mb-3">Ready to Become Our Next Success Story?</h2>
                <p class="lead mb-0">Join hundreds of satisfied clients who have made the switch to clean, renewable solar energy.</p>
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
@endsection

@push('styles')
<style>
/* Hero Section Styles */
.clients-hero {
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

/* Client Projects Section */
.client-projects-section {
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

.project-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.project-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
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
    right: 0;
    bottom: 0;
    background: rgba(255, 107, 53, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-card:hover .project-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
}

.overlay-content h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.project-content {
    padding: 2rem;
}

.project-badge {
    display: inline-block;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.project-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.5rem;
}

.project-location {
    color: #64748b;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.project-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.detail-item {
    display: flex;
    align-items: center;
    color: #64748b;
    font-size: 0.9rem;
}

.detail-item i {
    margin-right: 0.75rem;
    color: #FF6B35;
    width: 16px;
}

/* Testimonials Section */
.testimonials-section {
    background: white;
    position: relative;
}

.testimonial-card {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.testimonial-content {
    margin-bottom: 2rem;
}

.quote-icon {
    color: #FF6B35;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.testimonial-text {
    color: #64748b;
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    font-style: italic;
}

.testimonial-rating {
    display: flex;
    gap: 0.25rem;
}

.testimonial-rating i {
    color: #FFD700;
    font-size: 1.1rem;
}

.testimonial-rating i.active {
    color: #FFD700;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.author-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.25rem;
}

.author-title {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.author-company {
    color: #64748b;
    font-size: 0.8rem;
    margin: 0;
}

/* Client Stats Section */
.client-stats-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.client-stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.client-stats-section .section-title {
    color: white;
}

.client-stats-section .section-subtitle {
    color: rgba(255, 255, 255, 0.9);
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 2.5rem;
    border-radius: 20px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    z-index: 2;
}

.stat-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
}

.stat-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.stat-card .stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: #FFE0B2;
    margin-bottom: 0.5rem;
}

.stat-card .stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
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
    
    .project-content {
        padding: 1.5rem;
    }
    
    .testimonial-card {
        padding: 2rem;
    }
    
    .contact-info-card {
        padding: 2rem;
    }
    
    .stat-card {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .project-content {
        padding: 1rem;
    }
    
    .testimonial-card {
        padding: 1.5rem;
    }
    
    .contact-info-card {
        padding: 1.5rem;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .project-title {
        font-size: 1.3rem;
    }
    
    .testimonial-author {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush
