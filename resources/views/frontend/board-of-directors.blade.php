@extends('frontend.layouts.app')

@section('title', 'Board of Directors - NSPG Solar | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section board-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-users-cog me-2"></i>
                        Leadership Team
                    </div>
                    <h1 class="hero-title mb-4">
                        Board of
                        <span class="text-primary">Directors</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Meet the visionary leaders guiding NSPG towards a sustainable future. 
                        Our board members bring decades of experience and commitment to clean energy innovation.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">2</h3>
                                    <p class="stat-label">Board Members</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">15+</h3>
                                    <p class="stat-label">Years Combined Experience</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">100%</h3>
                                    <p class="stat-label">Commitment to Excellence</p>
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

<!-- Board Members Section -->
<section class="py-5 board-members-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-user-tie"></i>
            </div>
            <h2 class="section-title">Our Board Members</h2>
            <p class="section-subtitle">Visionary leaders driving NSPG's success</p>
        </div>
        
        <div class="row">
            <!-- Dr. Amardeep Singh -->
            <div class="col-lg-6 mb-5">
                <div class="director-card">
                    <div class="director-image">
                        <img src="/images/nspg/b1.jpg" alt="Dr. Amardeep Singh" class="img-fluid">
                        <div class="image-overlay">
                            <div class="overlay-content">
                                <h4>Hon'ble Chairman</h4>
                                <p>Leading with Vision</p>
                            </div>
                        </div>
                    </div>
                    <div class="director-content">
                        <div class="director-badge">
                            <i class="fas fa-crown"></i>
                            Chairman
                        </div>
                        <h3 class="director-name">Dr. Amardeep Singh</h3>
                        <p class="director-title">Hon'ble Chairman</p>
                        <p class="director-description">
                            Dr. Amardeep Singh brings extensive experience in renewable energy and sustainable development. 
                            Under his leadership, NSPG has grown to become a trusted name in solar energy solutions across India.
                        </p>
                        <div class="director-achievements">
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>15+ Years in Renewable Energy</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>PhD in Engineering</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Industry Recognition</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ankita Singh -->
            <div class="col-lg-6 mb-5">
                <!-- <div class="director-card">
                    <div class="director-image">
                        <img src="/images/nspg/b2.jpg" alt="Ankita Singh" class="img-fluid">
                        <div class="image-overlay">
                            <div class="overlay-content">
                                <h4>Managing Director</h4>
                                <p>Driving Innovation</p>
                            </div>
                        </div>
                    </div>
                    <div class="director-content">
                        <div class="director-badge">
                            <i class="fas fa-briefcase"></i>
                            Managing Director
                        </div>
                        <h3 class="director-name">Ankita Singh</h3>
                        <p class="director-title">Managing Director</p>
                        <p class="director-description">
                            Ankita Singh leads NSPG's day-to-day operations with a focus on innovation and customer satisfaction. 
                            Her strategic vision has been instrumental in expanding NSPG's reach across multiple states.
                        </p>
                        <div class="director-achievements">
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Strategic Leadership</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Business Development</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Customer Focus</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<!-- Director's Message Section -->
<section class="py-5 directors-message-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
                <div class="message-content">
                    <div class="section-icon mb-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <h2 class="section-title mb-4">Director's Message</h2>
                    <div class="message-text">
                        <p class="mb-4">
                            NSPG Pvt Ltd is an EPC company established with a commitment to the environment and creating a more sustainable economy. 
                            We provide the best service through our technical team, our upfront and straightforward approach during installation, 
                            and most importantly, by putting our customers first.
                        </p>
                        <p class="mb-4">
                            Our goal is to help you reduce your dependence on non-renewable energy sources and achieve sustainability in your business or home. 
                            Our aim is to design and install the best system we can while offering great value for money.
                        </p>
                        <p class="mb-4">
                            NSPG strives to provide the highest level of professionalism. I invite all residential and business owners, as well as shareholders 
                            of modern society, to join hands in creating a clean, green, and bright future for generations to come.
                        </p>
                    </div>
                    <div class="message-signature">
                        <div class="signature-line"></div>
                        <p class="signature-text">Dr. Amardeep Singh</p>
                        <p class="signature-title">Hon'ble Chairman, NSPG Pvt. Ltd.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="message-image">
                    <div class="image-wrapper">
                        <img src="/images/nspg/b3.jpg" alt="Director's Message" class="img-fluid rounded-3">
                        <div class="image-overlay">
                            <div class="overlay-content">
                                <h4>Our Commitment</h4>
                                <p>To a sustainable future</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Values Section -->
<section class="py-5 company-values-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-heart"></i>
            </div>
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-subtitle">The principles that guide our leadership</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4 class="value-title">Environmental Commitment</h4>
                    <p class="value-text">Dedicated to creating a sustainable future through clean energy solutions.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="value-title">Customer First</h4>
                    <p class="value-text">Putting our customers at the center of everything we do.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4 class="value-title">Technical Excellence</h4>
                    <p class="value-text">Delivering the highest quality through our expert technical team.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="value-title">Professionalism</h4>
                    <p class="value-text">Maintaining the highest standards of professionalism in all our work.</p>
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
            <p class="section-subtitle">Get in touch with our leadership team</p>
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
                                    <p class="text-muted mb-0">info@nspg.in</p>
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
                                    <p class="text-muted mb-0">Monday to Saturday: 09:00 AM - 06:00 PM</p>
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
                <h2 class="fw-bold mb-3">Ready to Partner with NSPG?</h2>
                <p class="lead mb-0">Join us in creating a clean, green, and bright future for generations to come.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i>
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section Styles */
.board-hero {
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

/* Board Members Section */
.board-members-section {
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

.director-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.director-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
}

.director-image {
    position: relative;
    height: 700px;
    overflow: hidden;
}

.director-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.director-card:hover .director-image img {
    transform: scale(1.1);
}

.image-overlay {
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

.director-card:hover .image-overlay {
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

.director-content {
    padding: 2.5rem;
}

.director-badge {
    display: inline-block;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.director-badge i {
    margin-right: 0.5rem;
}

.director-name {
    font-size: 2rem;
    font-weight: 800;
    color: #FF6B35;
    margin-bottom: 0.5rem;
}

.director-title {
    font-size: 1.2rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.director-description {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 2rem;
    font-size: 1rem;
}

.director-achievements {
    margin-top: 1.5rem;
}

.achievement-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: #FF6B35;
}

.achievement-item i {
    margin-right: 1rem;
    font-size: 1.1rem;
}

/* Director's Message Section */
.directors-message-section {
    background: white;
    position: relative;
}

.message-content {
    padding: 2rem 0;
}

.message-text p {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.message-signature {
    margin-top: 3rem;
    text-align: right;
}

.signature-line {
    width: 200px;
    height: 2px;
    background: linear-gradient(90deg, #FF6B35, #FF8A65);
    margin: 0 0 1rem auto;
}

.signature-text {
    font-size: 1.3rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.25rem;
}

.signature-title {
    color: #64748b;
    font-style: italic;
    margin: 0;
}

.message-image {
    position: relative;
}

.image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

/* Company Values Section */
.company-values-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    position: relative;
}

.value-card {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.value-icon {
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

.value-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 1rem;
}

.value-text {
    color: #64748b;
    line-height: 1.7;
    font-size: 1rem;
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
    
    .director-content {
        padding: 2rem;
    }
    
    .value-card {
        padding: 2rem;
    }
    
    .contact-info-card {
        padding: 2rem;
    }
    
    .message-signature {
        text-align: center;
    }
    
    .signature-line {
        margin: 0 auto 1rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .director-content {
        padding: 1.5rem;
    }
    
    .value-card {
        padding: 1.5rem;
    }
    
    .contact-info-card {
        padding: 1.5rem;
    }
    
    .director-name {
        font-size: 1.5rem;
    }
    
    .director-title {
        font-size: 1rem;
    }
}
</style>
@endpush
