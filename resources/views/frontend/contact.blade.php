@extends('frontend.layouts.app')

@section('title', 'Contact Us - NSPG Solar | Nirmala Solar Power Generation')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section contact-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center ">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-solar-panel me-2"></i>
                        Get In Touch
                    </div>
                    <h1 class="hero-title mb-4">
                        Let's Power Your Future
                        <span class="text-primary">Together</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Ready to make the switch to clean, renewable solar energy? 
                        Our expert team is here to guide you every step of the way.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">4200+</h3>
                                    <p class="stat-label">Happy Customers</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">10+</h3>
                                    <p class="stat-label">Years Experience</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">24/7</h3>
                                    <p class="stat-label">Support Available</p>
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

<!-- Contact Section -->
<section class="py-5 contact-section">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5">
                <div class="contact-form-card">
                    <div class="form-header text-center mb-5">
                        <div class="form-icon mb-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Send us a Message</h3>
                        <p class="text-muted">Fill out the form below and we'll get back to you within 24 hours</p>
                    </div>
                    <form id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="system_capacity" class="form-label">Solar System Capacity</label>
                                <select class="form-select" id="system_capacity" name="system_capacity">
                                    <option value="">Choose</option>
                                    <option value="5kW">5 kW</option>
                                    <option value="8kW">8 kW</option>
                                    <option value="10kW">10 kW</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Service Required</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="installation" name="services[]" value="Installation">
                                        <label class="form-check-label" for="installation">
                                            Installation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="maintenance" name="services[]" value="Maintenance">
                                        <label class="form-check-label" for="maintenance">
                                            Maintenance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="replacement" name="services[]" value="Replacement">
                                        <label class="form-check-label" for="replacement">
                                            Replacement
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="other" name="services[]" value="Other">
                                        <label class="form-check-label" for="other">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="contact-info-card">
                    <div class="info-header text-center mb-4">
                        <div class="info-icon mb-3">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Contact Information</h3>
                        <p class="text-muted">Get in touch with our solar experts</p>
                    </div>
                    
                    @if(isset($contactInfos) && $contactInfos->count() > 0)
                        @foreach($contactInfos as $contact)
                            <div class="contact-item mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-{{ $contact->type === 'phone' ? 'phone' : ($contact->type === 'email' ? 'envelope' : ($contact->type === 'address' ? 'map-marker-alt' : 'globe')) }}"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">{{ $contact->label ?? ucfirst($contact->type) }}</h6>
                                    <p class="text-muted mb-0">{{ $contact->value }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Varanasi Office -->
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="fw-bold mb-1">Varanasi Office</h6>
                                <p class="text-muted mb-0">N1/66R-15K, Samne Ghat, Nagwa Lanka, Varanasi, Uttar Pradesh 221005</p>
                            </div>
                        </div>
                        
                        <!-- Noida Head Office -->
                        <!-- <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="fw-bold mb-1">Noida Head Office</h6>
                                <p class="text-muted mb-0">i2/001, Plot No. 11, Golf City, Sector 75, Noida, Uttar Pradesh 201301</p>
                            </div>
                        </div> -->
                        
                        <!-- Phone Numbers -->
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="fw-bold mb-1">Call Us</h6>
                                <p class="text-muted mb-1">+91 93194 83455</p>
                                <p class="text-muted mb-0">+91 94503 04472</p>
                            </div>
                        </div>
                        
                        <!-- Email Addresses -->
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                           
                                <h6 class="fw-bold mb-1">Send Email</h6>
                                <p class="text-muted mb-1">infonspg.in@gmail.com</p>
                                <!-- <p class="text-muted mb-0">infonspg.in@gmail.com</p> -->
                            </div>
                        </div>
                        
                        <!-- Office Hours -->
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="fw-bold mb-1">Office Hours</h6>
                                <p class="text-muted mb-0">Monday to Saturday: 09:30 AM - 06:30 PM</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3">Social Media</h6>
                        <div class="social-links">
                            <a href="#" class="social-link me-3">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link me-3">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link me-3">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 map-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <h2 class="section-title">Our Location</h2>
            <p class="section-subtitle">Visit our offices or explore our locations on the map</p>
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

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Answers to common questions about solar systems</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                How long does it take to install a solar system?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Solar system installation usually takes 2-3 days. It depends on the capacity and complexity of the system.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                What is the warranty on solar systems?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Solar panels have 25 year warranty and inverter has 10 year warranty. Also, free maintenance is provided for 5 years.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                How much investment is required in solar system?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Solar system cost depends on capacity. 5 kW system costs around 2-3 lakh rupees, which is recovered in 2-3 years.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                How does solar system work?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Solar panels convert sunlight into electricity. This electricity is made ready for home use through inverter. Excess electricity can be sent to the grid.
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
                <h2 class="fw-bold mb-3">Contact Us Now</h2>
                <p class="lead mb-0">Our expert team is ready to help you. Contact us today!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="tel:+919319483455" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i>
                    +91 93194 83455
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section Styles */
.contact-hero {
    background: linear-gradient(135deg,rgb(206, 67, 20) 0%,rgb(58, 8, 82) 50%,rgb(135, 56, 32) 100%);
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

/* Contact Section Styles */
.contact-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.contact-form-card {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
    overflow: hidden;
}

.contact-form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #FF6B35, #FF8A65, #FFAB91);
}

.form-icon {
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
}

.contact-info-card {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    height: fit-content;
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
    background: linear-gradient(90deg, #FF8A65, #FF6B35, #FF5722);
}

.info-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF8A65, #FF6B35);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
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

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--secondary-color);
    color: white;
    transform: translateY(-2px);
}

.map-container {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.accordion-item {
    border: 1px solid var(--border-color);
    border-radius: 10px !important;
    margin-bottom: 1rem;
}

.accordion-button {
    background: var(--light-color);
    border: none;
    border-radius: 10px !important;
    font-weight: 600;
    color: var(--primary-color);
}

.accordion-button:not(.collapsed) {
    background: var(--primary-color);
    color: white;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: var(--primary-color);
}

.form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px 20px;
    transition: all 0.3s ease;
    background: #f8fafc;
    font-size: 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #FF6B35;
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
    background: white;
    transform: translateY(-2px);
}

.form-label {
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.form-check {
    margin-bottom: 1rem;
    padding: 1rem;
    background: rgba(255, 107, 53, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(255, 107, 53, 0.1);
    transition: all 0.3s ease;
}

.form-check:hover {
    background: rgba(255, 107, 53, 0.1);
    transform: translateY(-2px);
}

.form-check-input {
    margin-top: 0.25rem;
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #FF6B35;
}

.form-check-input:checked {
    background-color: #FF6B35;
    border-color: #FF6B35;
}

.form-check-label {
    font-weight: 600;
    color: #FF6B35;
    margin-left: 0.75rem;
    font-size: 1rem;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, #FF5722, #FF6B35);
}

.btn-primary-custom:active {
    transform: translateY(-1px);
}

/* Map Section Styles */
.map-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
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

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 4px solid white;
}

.map-container iframe {
    border-radius: 16px;
}

/* FAQ Section Enhancement */
.accordion-item {
    border: 1px solid #e2e8f0;
    border-radius: 15px !important;
    margin-bottom: 1rem;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.accordion-item:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.accordion-button {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border: none;
    border-radius: 15px !important;
    font-weight: 700;
    color: #FF6B35;
    padding: 1.5rem;
    font-size: 1.1rem;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    color: white;
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
    border-color: #FF6B35;
}

.accordion-body {
    padding: 1.5rem;
    color: #64748b;
    line-height: 1.7;
    font-size: 1rem;
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
    
    .contact-form-card,
    .contact-info-card {
        padding: 2rem;
    }
    
    .stat-item {
        margin-bottom: 1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .form-check {
        padding: 0.75rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .contact-form-card,
    .contact-info-card {
        padding: 1.5rem;
    }
    
    .btn-primary-custom {
        padding: 12px 30px;
        font-size: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            submitBtn.disabled = true;
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                showAlert('error', 'CSRF token not found. Please refresh the page and try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }
            
            // Make AJAX call
            fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Reset form
                    this.reset();
                    
                    // Show success message
                    showAlert('success', data.message);
                } else {
                    // Show error message
                    showAlert('error', data.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Sorry, there was an error sending your message. Please try again later.');
            })
            .finally(() => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

function showAlert(type, message) {
    // Remove any existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Insert at the top of the form
    const form = document.getElementById('contactForm');
    if (form) {
        form.insertBefore(alertDiv, form.firstChild);
        
        // Scroll to alert
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Auto remove after 8 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 8000);
    }
}
</script>
@endpush