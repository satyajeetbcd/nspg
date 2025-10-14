@extends('frontend.layouts.app')

@section('title', 'Our Services - NSPG Solar | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section services-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-cogs me-2"></i>
                        Our Services
                    </div>
                    <h1 class="hero-title mb-4">
                        Complete Solar
                        <span class="text-primary">Solutions</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        From design to maintenance, NSPG provides comprehensive solar energy solutions 
                        that power your future with clean, renewable energy.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">5000+</h3>
                                    <p class="stat-label">Projects Completed</p>
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
                                    <h3 class="stat-number">10+</h3>
                                    <p class="stat-label">Years Experience</p>
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

<!-- Main Services Section -->
<section class="py-5 main-services-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-solar-panel"></i>
            </div>
            <h2 class="section-title">Our Core Services</h2>
            <p class="section-subtitle">Three comprehensive service categories to meet all your solar energy needs</p>
        </div>
        
        <div class="row">
            <!-- NSPG EPC Service -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="service-main-card">
                    <div class="service-image">
                        <img src="/images/nspg/epc1.jpg" alt="NSPG EPC Service" class="img-fluid">
                        <div class="service-overlay">
                            <div class="overlay-content">
                                <h4>NSPG EPC</h4>
                                <p>Engineering, Procurement & Construction</p>
                            </div>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="service-title">NSPG EPC</h3>
                        <p class="service-subtitle">Engineering, Procurement & Construction</p>
                        <p class="service-description">
                            Complete end-to-end solar project solutions including site assessment, 
                            design, procurement, construction, and commissioning.
                        </p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Site Assessment & Feasibility Study</li>
                            <li><i class="fas fa-check"></i> Custom System Design</li>
                            <li><i class="fas fa-check"></i> Equipment Procurement</li>
                            <li><i class="fas fa-check"></i> Professional Installation</li>
                            <li><i class="fas fa-check"></i> Grid Connection & Commissioning</li>
                        </ul>
                        <a href="#nspg-epc" class="btn btn-service">Learn More</a>
                    </div>
                </div>
            </div>
            
            <!-- Solar Finance Service -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="service-main-card">
                    <div class="service-image">
                        <img src="/images/nspg/epc2.jpg" alt="Solar Finance Service" class="img-fluid">
                        <div class="service-overlay">
                            <div class="overlay-content">
                                <h4>Solar Finance</h4>
                                <p>Financial Solutions</p>
                            </div>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h3 class="service-title">Solar Finance</h3>
                        <p class="service-subtitle">Financial Solutions</p>
                        <p class="service-description">
                            Flexible financing options to make solar energy accessible and affordable 
                            for residential, commercial, and industrial customers.
                        </p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Zero Down Payment Options</li>
                            <li><i class="fas fa-check"></i> EMI Plans Available</li>
                            <li><i class="fas fa-check"></i> Government Subsidy Assistance</li>
                            <li><i class="fas fa-check"></i> Bank Loan Facilitation</li>
                            <li><i class="fas fa-check"></i> ROI Analysis & Planning</li>
                        </ul>
                        <a href="#solar-finance" class="btn btn-service">Learn More</a>
                    </div>
                </div>
            </div>
            
            <!-- Operations & Maintenance Service -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="service-main-card">
                    <div class="service-image">
                        <img src="/images/nspg/epc3.jpg" alt="Operations & Maintenance Service" class="img-fluid">
                        <div class="service-overlay">
                            <div class="overlay-content">
                                <h4>Operations & Maintenance</h4>
                                <p>Ongoing Support</p>
                            </div>
                        </div>
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="service-title">Operations & Maintenance</h3>
                        <p class="service-subtitle">Ongoing Support</p>
                        <p class="service-description">
                            Comprehensive maintenance and monitoring services to ensure optimal 
                            performance and longevity of your solar system.
                        </p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> 24/7 Remote Monitoring</li>
                            <li><i class="fas fa-check"></i> Preventive Maintenance</li>
                            <li><i class="fas fa-check"></i> Performance Optimization</li>
                            <li><i class="fas fa-check"></i> Emergency Repairs</li>
                            <li><i class="fas fa-check"></i> Warranty Support</li>
                        </ul>
                        <a href="#operations-maintenance" class="btn btn-service">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NSPG EPC Detailed Section -->
<section id="nspg-epc" class="py-5 nspg-epc-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
                <div class="service-detail-content">
                    <div class="section-icon mb-4">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h2 class="section-title">NSPG EPC Services</h2>
                    <p class="service-detail-description">
                        Our Engineering, Procurement, and Construction (EPC) services provide complete 
                        solar project solutions from concept to commissioning. We handle every aspect 
                        of your solar installation with precision and expertise.
                    </p>
                    
                    <div class="service-process">
                        <div class="process-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Site Assessment</h4>
                                <p>Comprehensive site evaluation including shading analysis, structural assessment, and feasibility study.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>System Design</h4>
                                <p>Custom solar system design optimized for maximum energy generation and return on investment.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Procurement</h4>
                                <p>Quality equipment procurement from trusted manufacturers with warranty support.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h4>Installation</h4>
                                <p>Professional installation by certified technicians following industry best practices.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <h4>Commissioning</h4>
                                <p>System testing, grid connection, and performance validation for optimal operation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-detail-image">
                    <img src="/images/nspg/serv1.jpeg" alt="NSPG EPC Process" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solar Finance Detailed Section -->
<section id="solar-finance" class="py-5 solar-finance-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
                <div class="service-detail-image">
                    <img src="/images/nspg/serv2.png" alt="Solar Finance Solutions" class="img-fluid rounded-3" style="width: 70%; height: 60%;">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-detail-content">
                    <div class="section-icon mb-4">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h2 class="section-title">Solar Finance Solutions</h2>
                    <p class="service-detail-description">
                        Make solar energy accessible with our flexible financing options. We work with 
                        leading financial institutions to provide attractive loan schemes and payment 
                        plans tailored to your budget and requirements.
                    </p>
                    
                    <div class="finance-options">
                        <div class="finance-option">
                            <div class="option-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="option-content">
                                <h4>Residential Finance</h4>
                                <p>Home solar loans with competitive interest rates and flexible EMI options.</p>
                            </div>
                        </div>
                        <div class="finance-option">
                            <div class="option-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="option-content">
                                <h4>Commercial Finance</h4>
                                <p>Business solar financing with tax benefits and accelerated depreciation.</p>
                            </div>
                        </div>
                        <div class="finance-option">
                            <div class="option-icon">
                                <i class="fas fa-industry"></i>
                            </div>
                            <div class="option-content">
                                <h4>Industrial Finance</h4>
                                <p>Large-scale project financing with attractive terms and government incentives.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Operations & Maintenance Detailed Section -->
<section id="operations-maintenance" class="py-5 operations-maintenance-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
                <div class="service-detail-content">
                    <div class="section-icon mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h2 class="section-title">Operations & Maintenance</h2>
                    <p class="service-detail-description">
                        Ensure maximum performance and longevity of your solar system with our 
                        comprehensive O&M services. Our proactive approach prevents issues and 
                        maximizes your return on investment.
                    </p>
                    
                    <div class="maintenance-services">
                        <div class="maintenance-service">
                            <div class="service-icon-small">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="service-content-small">
                                <h4>Remote Monitoring</h4>
                                <p>24/7 real-time monitoring of system performance and energy generation.</p>
                            </div>
                        </div>
                        <div class="maintenance-service">
                            <div class="service-icon-small">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <div class="service-content-small">
                                <h4>Preventive Maintenance</h4>
                                <p>Regular cleaning, inspection, and maintenance to prevent issues.</p>
                            </div>
                        </div>
                        <div class="maintenance-service">
                            <div class="service-icon-small">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="service-content-small">
                                <h4>Performance Analysis</h4>
                                <p>Detailed performance reports and optimization recommendations.</p>
                            </div>
                        </div>
                        <div class="maintenance-service">
                            <div class="service-icon-small">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <div class="service-content-small">
                                <h4>Emergency Support</h4>
                                <p>Quick response and repair services for any system issues.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-detail-image">
                    <img src="/images/nspg/serv3.jpeg" alt="Operations & Maintenance" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solar Systems Section -->
<section class="py-5 solar-systems-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-solar-panel"></i>
            </div>
            <h2 class="section-title">Grid Connected Solar Systems</h2>
            <p class="section-subtitle">Choose the perfect solar system for your energy needs</p>
        </div>
        
        @if(isset($solarSystems) && $solarSystems->count() > 0)
        <div class="row">
            @foreach($solarSystems as $system)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="solar-system-card">
                    <div class="system-capacity">{{ $system->capacity }}</div>
                    <h4 class="mb-4">{{ $system->name }}</h4>
                    
                    <ul class="system-specs">
                        <li>
                            <span class="spec-label">Required Shade-free Rooftop Area:</span>
                            <span class="spec-value">{{ $system->rooftop_area }}</span>
                        </li>
                        <li>
                            <span class="spec-label">Required Inverter:</span>
                            <span class="spec-value">{{ $system->inverter_capacity }}</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Generation:</span>
                            <span class="spec-value">{{ $system->annual_generation }}</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Savings:</span>
                            <span class="spec-value">{{ $system->annual_savings }}</span>
                        </li>
                    </ul>
                    
                    @if($system->description)
                        <p class="text-muted mt-3">{{ $system->description }}</p>
                    @endif
                    
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom w-100 mt-3">
                        <i class="fas fa-phone me-2"></i>
                        Contact Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Default Solar Systems -->
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="solar-system-card">
                    <div class="system-capacity">5 kW</div>
                    <h4 class="mb-4">5 kW Solar System</h4>
                    
                    <ul class="system-specs">
                        <li>
                            <span class="spec-label">Required Shade-free Rooftop Area:</span>
                            <span class="spec-value">500 sq ft</span>
                        </li>
                        <li>
                            <span class="spec-label">Required Inverter:</span>
                            <span class="spec-value">5 kW</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Generation:</span>
                            <span class="spec-value">7,500 kWh</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Savings:</span>
                            <span class="spec-value">₹45,000</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom w-100 mt-3">
                        <i class="fas fa-phone me-2"></i>
                        Contact Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="solar-system-card">
                    <div class="system-capacity">10 kW</div>
                    <h4 class="mb-4">10 kW Solar System</h4>
                    
                    <ul class="system-specs">
                        <li>
                            <span class="spec-label">Required Shade-free Rooftop Area:</span>
                            <span class="spec-value">1,000 sq ft</span>
                        </li>
                        <li>
                            <span class="spec-label">Required Inverter:</span>
                            <span class="spec-value">10 kW</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Generation:</span>
                            <span class="spec-value">15,000 kWh</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Savings:</span>
                            <span class="spec-value">₹90,000</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom w-100 mt-3">
                        <i class="fas fa-phone me-2"></i>
                        Contact Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="solar-system-card">
                    <div class="system-capacity">15 kW</div>
                    <h4 class="mb-4">15 kW Solar System</h4>
                    
                    <ul class="system-specs">
                        <li>
                            <span class="spec-label">Required Shade-free Rooftop Area:</span>
                            <span class="spec-value">1,500 sq ft</span>
                        </li>
                        <li>
                            <span class="spec-label">Required Inverter:</span>
                            <span class="spec-value">15 kW</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Generation:</span>
                            <span class="spec-value">22,500 kWh</span>
                        </li>
                        <li>
                            <span class="spec-label">Annual Savings:</span>
                            <span class="spec-value">₹1,35,000</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom w-100 mt-3">
                        <i class="fas fa-phone me-2"></i>
                        Contact Now
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Ready to Go Solar?</h2>
                <p class="lead mb-0">Get a free consultation and quote for your solar energy project today.</p>
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
.services-hero {
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

/* Main Services Section */
.main-services-section {
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

.service-main-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.service-main-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
}

.service-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.service-main-card:hover .service-image img {
    transform: scale(1.1);
}

.service-overlay {
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

.service-main-card:hover .service-overlay {
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

.service-content {
    padding: 2.5rem;
}

.service-icon {
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

.service-title {
    font-size: 2rem;
    font-weight: 800;
    color: #FF6B35;
    margin-bottom: 0.5rem;
    text-align: center;
}

.service-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-align: center;
}

.service-description {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 2rem;
    text-align: center;
}

.service-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.service-features li {
    padding: 0.5rem 0;
    color: #64748b;
    font-weight: 500;
}

.service-features li i {
    color: #FF6B35;
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.btn-service {
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
    width: 100%;
    text-align: center;
}

.btn-service:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, #FF5722, #E64A19);
    color: white;
}

/* Detailed Service Sections */
.nspg-epc-section {
    background: white;
    position: relative;
}

.solar-finance-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    position: relative;
}

.operations-maintenance-section {
    background: white;
    position: relative;
}

.service-detail-content {
    padding: 2rem 0;
}

.service-detail-description {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 2rem;
}

.service-process {
    margin-top: 2rem;
}

.process-step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    gap: 1.5rem;
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.step-content h4 {
    color: #FF6B35;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
}

.step-content p {
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

.finance-options {
    margin-top: 2rem;
}

.finance-option {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    gap: 1.5rem;
}

.option-icon {
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

.option-content h4 {
    color: #FF6B35;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
}

.option-content p {
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

.maintenance-services {
    margin-top: 2rem;
}

.maintenance-service {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    gap: 1.5rem;
}

.service-icon-small {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.service-content-small h4 {
    color: #FF6B35;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.service-content-small p {
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

.service-detail-image {
    position: relative;
}

.service-detail-image img {
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Solar Systems Section */
.solar-systems-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.solar-system-card {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.solar-system-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.system-capacity {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 1.2rem;
    display: inline-block;
    margin-bottom: 1.5rem;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.system-specs {
    list-style: none;
    padding: 0;
    text-align: left;
    margin-bottom: 2rem;
}

.system-specs li {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.spec-label {
    color: #64748b;
    font-weight: 500;
    flex: 1;
}

.spec-value {
    color: #FF6B35;
    font-weight: 700;
    margin-left: 1rem;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
    color: white;
    text-decoration: none;
    display: inline-block;
}

.btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, #FF5722, #E64A19);
    color: white;
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
    
    .service-content {
        padding: 2rem;
    }
    
    .service-detail-content {
        padding: 1rem 0;
    }
    
    .solar-system-card {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .service-content {
        padding: 1.5rem;
    }
    
    .solar-system-card {
        padding: 1.5rem;
    }
    
    .service-title {
        font-size: 1.5rem;
    }
    
    .process-step, .finance-option, .maintenance-service {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush