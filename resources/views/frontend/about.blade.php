@extends('frontend.layouts.app')

@section('title', 'About Us - NSPG Solar | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section about-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-solar-panel me-2"></i>
                        About NSPG
                    </div>
                    <h1 class="hero-title mb-4">
                        WHO ARE
                        <span class="text-primary">NSPG</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Nirmala Solar Power Generation is committed to enabling solar everywhere and bringing the power of the sun to people in the most efficient and cost-effective way possible.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">500+</h3>
                                    <p class="stat-label">Projects Completed</p>
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
                                    <h3 class="stat-number">50MW+</h3>
                                    <p class="stat-label">Solar Capacity</p>
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

<!-- About NSPG Section -->
<section class="py-5 about-nspg-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
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
                </div>
            </div>
            <div class="col-lg-6">
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

<!-- Company Story Section -->
<section class="py-5 company-story-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5">
                <div class="story-content">
                    <div class="section-icon mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h2 class="section-title mb-4">Our Story</h2>
                    <p class="story-text mb-4">
                        Established in 2015, NSPG prides itself as a pioneer in developing green energy solutions that are environmentally friendly, energy-efficient, and capable of delivering a quick return on investment. The company focuses on installing solar panels on rooftops across the country, achieving better value for money.
                    </p>
                    <p class="story-text mb-4">
                        Nirmala Solar Power Generation Pvt. Ltd. (NSPG) is committed to enabling solar energy access everywhere, bringing the power of the sun to people in the most efficient and cost-effective way possible.
                    </p>
                    <div class="story-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-check-circle"></i>
                            <span>ISO 9001:2015 Certified</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-check-circle"></i>
                            <span>MNRE Approved Installer</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-check-circle"></i>
                            <span>5+ Years Warranty</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="story-image">
                    <div class="image-wrapper">
                        <img src="/images/nspg/about.jpeg" alt="NSPG Team" class="img-fluid rounded-3">
                        <div class="image-overlay">
                            <div class="overlay-content">
                                <h4>Excellence in Every Project</h4>
                                <p>Quality is our commitment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Board Members Section -->
<section class="board-members-section">
    <div class="container">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <h2 class="section-title">Our Board Members</h2>
            <p class="section-subtitle">Visionary leaders driving NSPG's success</p>
            <div class="section-decoration">
                <div class="decoration-line"></div>
                <div class="decoration-dot"></div>
                <div class="decoration-line"></div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <!-- Dr. Amardeep Singh -->
            <div class="col-lg-10 col-xl-8">
                <div class="director-card">
                    <div class="card-glow"></div>
                    <div class="row align-items-center">
                        <!-- Image Column -->
                        <div class="col-lg-5 col-md-6">
                            <div class="director-image">
                                <img src="/images/nspg/b1.jpg" alt="Dr. Amardeep Singh" class="img-fluid">
                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <div class="overlay-icon">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                        <h4>Hon'ble Chairman</h4>
                                        <p>Leading with Vision & Excellence</p>
                                    </div>
                                </div>
                                <div class="image-badge">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Content Column -->
                        <div class="col-lg-7 col-md-6">
                            <div class="director-content">
                                <div class="director-badge">
                                    <i class="fas fa-crown"></i>
                                    <span>Chairman</span>
                                </div>
                                <h3 class="director-name">Dr. Amardeep Singh</h3>
                                <p class="director-title">Hon'ble Chairman</p>
                                <p class="director-description">
                                    Dr. Amardeep Singh brings extensive experience in renewable energy and sustainable development. 
                                    Under his visionary leadership, NSPG has grown to become a trusted name in solar energy solutions across India.
                                </p>
                                <div class="director-achievements">
                                    <div class="achievement-item">
                                        <div class="achievement-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <span>15+ Years in Renewable Energy</span>
                                    </div>
                                    <div class="achievement-item">
                                        <div class="achievement-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <span>PhD in Engineering</span>
                                    </div>
                                    <div class="achievement-item">
                                        <div class="achievement-icon">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <span>Industry Recognition</span>
                                    </div>
                                </div>
                                <div class="director-quote">
                                    <i class="fas fa-quote-left"></i>
                                    <p>"Leading the green energy revolution with innovation and integrity."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

<!-- Mission & Vision Section -->
<section class="py-5 mission-vision-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-target"></i>
            </div>
            <h2 class="section-title">Our Mission & Vision</h2>
            <p class="section-subtitle">Driving India towards a sustainable energy future</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="mission-card">
                    <div class="card-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="card-title">Our Mission</h3>
                    <p class="card-text">
                        Within the next 5 years, grow NSPG solar products into a choice in India, creating value for all shareholders and customers.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="vision-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="card-title">Our Vision</h3>
                    <p class="card-text">
                        At NSPG Pvt Ltd, we believe in delivering cost-effective, better quality, and highly efficient sustainable energy products, enabling the future of clean and green energy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-5 values-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-heart"></i>
            </div>
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-subtitle">The principles that guide everything we do</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="value-title">Quality</h4>
                    <p class="value-text">We never compromise on quality. Every component, every installation, every service meets the highest standards.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="value-title">Trust</h4>
                    <p class="value-text">Building lasting relationships through transparency, honesty, and reliable service delivery.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4 class="value-title">Innovation</h4>
                    <p class="value-text">Continuously improving our technology and processes to deliver better solar solutions.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4 class="value-title">Sustainability</h4>
                    <p class="value-text">Committed to environmental responsibility and creating a sustainable future for all.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 team-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-users"></i>
            </div>
            <h2 class="section-title">Meet Our Team</h2>
            <p class="section-subtitle">The experts behind your solar success</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-image">
                        <img src="/images/nspg/about11.jpeg" alt="Team Member" class="img-fluid">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-content">
                        <h4 class="team-name">Project Manager</h4>
                        <p class="team-position">Varanasi</p>
                        <p class="team-description">Our experienced Project Manager based in Prayagraj, committed to delivering exceptional solar solutions.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-image">
                        <img src="/images/nspg/about3.jpeg" alt="Team Member" class="img-fluid">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-content">
                        <h4 class="team-name">Project Manager</h4>
                        <p class="team-position">Prayagraj</p>
                        <p class="team-description">Our dedicated HR Manager, ensuring our team is well-supported and our company culture thrives.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-image">
                        <img src="/images/nspg/about33.jpeg" alt="Team Member" class="img-fluid">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-content">
                        <h4 class="team-name">Technical Team</h4>
                        <p class="team-position">Solar Experts</p>
                        <p class="team-description">Our skilled technical team with expertise in solar system design, installation, and maintenance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company History Section -->
<section class="py-5 company-history-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-history"></i>
            </div>
            <h2 class="section-title">Company History</h2>
            <p class="section-subtitle">Key milestones in our journey</p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-content">
                    <h4>Best Tech Award</h4>
                    <p>Received the Best Tech Award for innovation in solar technology</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2017</div>
                <div class="timeline-content">
                    <h4>Company Established</h4>
                    <p>NSPG Pvt. Ltd. was established as a pioneer in green energy solutions</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2018</div>
                <div class="timeline-content">
                    <h4>Features & Add-ons</h4>
                    <p>Introduced new features and add-ons to enhance solar solutions</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2019</div>
                <div class="timeline-content">
                    <h4>Major Milestones</h4>
                    <p>Achieved "Temtaris daspo" and "narid aspolas kola" milestones</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="py-5 achievements-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-icon mb-4">
                <i class="fas fa-trophy"></i>
            </div>
            <h2 class="section-title">Our Achievements</h2>
            <p class="section-subtitle">Recognition and milestones that drive us forward</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="achievement-number">500+</h3>
                    <p class="achievement-label">Happy Customers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-solar-panel"></i>
                    </div>
                    <h3 class="achievement-number">50MW+</h3>
                    <p class="achievement-label">Solar Capacity Installed</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="achievement-number">4.9/5</h3>
                    <p class="achievement-label">Customer Rating</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="achievement-number">10+</h3>
                    <p class="achievement-label">Industry Awards</p>
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
            <p class="section-subtitle">Get in touch with our solar experts</p>
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
                                    <h6 class="fw-bold mb-1">Office Address</h6>
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
                                    <h6 class="fw-bold mb-1">Phone Number</h6>
                                    <p class="text-muted mb-0">+91 93194 83455</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-bold mb-1">Email Address</h6>
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
                <h2 class="fw-bold mb-3">Ready to Go Solar?</h2>
                <p class="lead mb-0">Join thousands of satisfied customers who have made the switch to clean energy with NSPG.</p>
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
/* About NSPG Section Styles */
.about-nspg-section {
    padding: 100px 0;
}

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

.achievements {
    margin-bottom: 30px;
}

.achievement-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 15px;
}

.achievement-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-orange);
    margin: 0;
}

.achievement-label {
    color: var(--text-light);
    margin: 0;
    font-size: 0.9rem;
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

/* Responsive Design for About NSPG Section */
@media (max-width: 768px) {
    .about-nspg-section {
        padding: 60px 0;
    }
    
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
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .about-nspg-section {
        padding: 40px 0;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .achievement-number {
        font-size: 1.5rem;
    }
    
    /* Board Members Section Mobile */
    .board-members-section {
        padding: 80px 0;
    }
    
    .section-icon {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
    }
    
    .director-card {
        margin: 0 15px;
    }
    
    .director-image {
        height: 350px;
        margin: 15px;
    }
    
    .director-content {
        padding: 30px 25px;
        height: auto;
    }
    
    .director-name {
        font-size: 1.8rem;
    }
    
    .director-title {
        font-size: 1.1rem;
    }
    
    .director-description {
        font-size: 1rem;
    }
    
    .achievement-item {
        padding: 10px 14px;
    }
    
    .achievement-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
        color: #ff6b35 !important;
        background: white !important;
        border: 2px solid #ff6b35 !important;
    }
    
    .achievement-icon i {
        color: #ff6b35 !important;
        font-size: 0.8rem !important;
    }
    
    .achievement-item {
        padding: 6px 10px;
    }
    
    .director-quote {
        padding: 20px;
    }
    
    .director-quote p {
        font-size: 1rem;
    }
    
    .overlay-icon {
        font-size: 3rem;
    }
    
    .image-badge {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .board-members-section {
        padding: 60px 0;
    }
    
    .section-icon {
        width: 70px;
        height: 70px;
        font-size: 1.8rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .director-card {
        margin: 0 10px;
    }
    
    .director-image {
        height: 300px;
        margin: 10px;
    }
    
    .director-content {
        padding: 25px 20px;
        height: auto;
    }
    
    .director-name {
        font-size: 1.6rem;
    }
    
    .director-title {
        font-size: 1rem;
    }
    
    .director-description {
        font-size: 0.95rem;
    }
    
    .achievement-item {
        padding: 8px 12px;
    }
    
    .achievement-icon {
        width: 26px;
        height: 26px;
        font-size: 0.7rem;
        color: #ff6b35 !important;
        background: white !important;
        border: 2px solid #ff6b35 !important;
    }
    
    .achievement-icon i {
        color: #ff6b35 !important;
        font-size: 0.7rem !important;
    }
    
    .achievement-item {
        padding: 5px 8px;
    }
    
    .director-quote {
        padding: 18px;
    }
    
    .director-quote p {
        font-size: 0.95rem;
    }
    
    .overlay-icon {
        font-size: 2.5rem;
    }
    
    .image-badge {
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }
}

/* Board Members Section Styles */
.board-members-section {
    padding: 120px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);
    position: relative;
    overflow: hidden;
}

.board-members-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ff6b35" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.section-header {
    text-align: center;
    margin-bottom: 80px;
    position: relative;
    z-index: 2;
}

.section-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    font-size: 2.5rem;
    color: white;
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.3);
    position: relative;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.section-icon::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    opacity: 0.3;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 0.3; }
    50% { transform: scale(1.1); opacity: 0.1; }
    100% { transform: scale(1); opacity: 0.3; }
}

.section-title {
    font-size: 3rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 20px;
    position: relative;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle {
    font-size: 1.3rem;
    color: #6c757d;
    margin-bottom: 30px;
    font-weight: 500;
}

.section-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
}

.decoration-line {
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 2px;
}

.decoration-dot {
    width: 12px;
    height: 12px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.director-card {
    background: white;
    border-radius: 30px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    border: 1px solid rgba(255, 107, 53, 0.1);
    min-height: 540px;
}

.director-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
}

.card-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 107, 53, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}

.director-card:hover .card-glow {
    opacity: 1;
}

.director-image {
    position: relative;
    overflow: hidden;
    height: 500px;
    border-radius: 20px;
    margin: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.director-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    filter: brightness(1.1) contrast(1.1);
    border-radius: 20px;
}

.director-card:hover .director-image img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.95) 0%, rgba(247, 147, 30, 0.95) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
    backdrop-filter: blur(5px);
}

.director-card:hover .image-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.director-card:hover .overlay-content {
    transform: translateY(0);
}

.overlay-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
    color: #ff6b35;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    filter: drop-shadow(0 2px 4px rgba(255, 107, 53, 0.5));
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

.overlay-content h4 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.overlay-content p {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
}

.image-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 20px rgba(255, 107, 53, 0.5);
    animation: rotate 3s linear infinite;
    border: 3px solid rgba(255, 255, 255, 0.3);
    z-index: 10;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.director-content {
    padding: 40px 40px 40px 20px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.director-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.director-badge i {
    margin-right: 10px;
    font-size: 1.1rem;
}

.director-name {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 8px;
    line-height: 1.2;
}

.director-title {
    color: #6c757d;
    font-size: 1.2rem;
    margin-bottom: 20px;
    font-weight: 600;
}

.director-description {
    color: #6c757d;
    line-height: 1.7;
    margin-bottom: 30px;
    font-size: 1.05rem;
}

.director-achievements {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 25px;
}

.achievement-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    transition: all 0.3s ease;
    border-left: 3px solid #ff6b35;
}

.achievement-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.achievement-icon {
    width: 30px;
    height: 30px;
    background: white !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: #ff6b35 !important;
    font-size: 0.9rem;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
    border: 2px solid #ff6b35 !important;
    transition: all 0.3s ease;
}

.achievement-icon i {
    color: #ff6b35 !important;
    font-size: 0.9rem !important;
}

.achievement-item span {
    color: #495057;
    font-weight: 600;
    font-size: 0.95rem;
}

.director-quote {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 25px;
    border-radius: 20px;
    text-align: center;
    position: relative;
    margin-top: 20px;
}

.director-quote i {
    font-size: 2rem;
    color: rgba(255, 255, 255, 0.3);
    margin-bottom: 15px;
    display: block;
}

.director-quote p {
    font-size: 1.1rem;
    font-style: italic;
    margin: 0;
    font-weight: 500;
    line-height: 1.6;
}

/* Director's Message Section */
.directors-message-section {
    padding: 100px 0;
    background: white;
}

.message-content {
    padding-right: 30px;
}

.section-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.section-icon i {
    font-size: 2rem;
    color: white;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 20px;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 30px;
}

.message-text p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #6c757d;
}

.message-signature {
    margin-top: 30px;
    text-align: left;
}

.signature-line {
    width: 100px;
    height: 3px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    margin-bottom: 15px;
}

.signature-text {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 5px;
}

.signature-title {
    color: #6c757d;
    font-size: 1rem;
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

.image-wrapper img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.9) 0%, rgba(247, 147, 30, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
}

.overlay-content h4 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.overlay-content p {
    font-size: 1.1rem;
    margin: 0;
}

/* Company Values Section */
.company-values-section {
    padding: 100px 0;
    background: #f8f9fa;
}

.value-card {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.value-icon i {
    font-size: 2rem;
    color: white;
}

.value-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 15px;
}

.value-text {
    color: #6c757d;
    line-height: 1.6;
    margin: 0;
}

/* Responsive Design for Board Sections */
@media (max-width: 768px) {
    .board-members-section,
    .directors-message-section,
    .company-values-section {
        padding: 60px 0;
    }
    
    .director-content {
        padding: 20px;
    }
    
    .director-name {
        font-size: 1.5rem;
    }
    
    .message-content {
        padding-right: 0;
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .value-card {
        padding: 30px 20px;
        margin-bottom: 20px;
    }
}

@media (max-width: 576px) {
    .board-members-section,
    .directors-message-section,
    .company-values-section {
        padding: 40px 0;
    }
    
    .director-image {
        height: 250px;
    }
    
    .director-content {
        padding: 15px;
    }
    
    .director-name {
        font-size: 1.3rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .value-card {
        padding: 25px 15px;
    }
    
    .value-icon {
        width: 60px;
        height: 60px;
    }
    
    .value-icon i {
        font-size: 1.5rem;
    }
}
</style>
@endpush

@push('styles')
<style>
/* Hero Section Styles */
.about-hero {
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

/* Company Story Section */
.company-story-section {
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

.story-text {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
}

.story-highlights {
    margin-top: 2rem;
}

.highlight-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #FF6B35;
}

.highlight-item i {
    margin-right: 1rem;
    font-size: 1.2rem;
}

.story-image {
    position: relative;
}

.image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    color: white;
    padding: 2rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.image-wrapper:hover .image-overlay {
    transform: translateY(0);
}

.overlay-content h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

/* Mission & Vision Section */
.mission-vision-section {
    background: white;
    position: relative;
}

.mission-card, .vision-card {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.mission-card:hover, .vision-card:hover {
    transform: translateY(-10px);
}

.mission-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #FF6B35, #FF8A65);
}

.vision-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #FF8A65, #FF6B35);
}

.card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin-bottom: 2rem;
}

.card-title {
    font-size: 2rem;
    font-weight: 800;
    color: #FF6B35;
    margin-bottom: 1.5rem;
}

.card-text {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 2rem;
}

.mission-points, .vision-points {
    list-style: none;
    padding: 0;
}

.mission-points li, .vision-points li {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
    color: #64748b;
    font-weight: 500;
    position: relative;
    padding-left: 2rem;
}

.mission-points li:before, .vision-points li:before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #FF6B35;
    font-weight: bold;
    font-size: 1.2rem;
}

/* Values Section */
.values-section {
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

/* Team Section */
.team-section {
    background: white;
    position: relative;
}

.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.team-image {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.team-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-card:hover .team-image img {
    transform: scale(1.1);
}

.team-overlay {
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

.team-card:hover .team-overlay {
    opacity: 1;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    width: 50px;
    height: 50px;
    background: white;
    color: #FF6B35;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: #FF6B35;
    color: white;
    transform: scale(1.1);
}

.team-content {
    padding: 2rem;
}

.team-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 0.5rem;
}

.team-position {
    color: #64748b;
    font-weight: 600;
    margin-bottom: 1rem;
}

.team-description {
    color: #64748b;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Company History Section */
.company-history-section {
    background: white;
    position: relative;
}

.timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    transform: translateX(-50%);
    border-radius: 2px;
}

.timeline-item {
    display: flex;
    margin-bottom: 3rem;
    position: relative;
}

.timeline-item:nth-child(odd) {
    flex-direction: row;
}

.timeline-item:nth-child(even) {
    flex-direction: row-reverse;
}

.timeline-year {
    background: linear-gradient(135deg, #FF6B35, #FF8A65);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.2rem;
    white-space: nowrap;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
    position: relative;
    z-index: 2;
}

.timeline-item:nth-child(odd) .timeline-year {
    margin-right: 2rem;
}

.timeline-item:nth-child(even) .timeline-year {
    margin-left: 2rem;
}

.timeline-content {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    flex: 1;
    position: relative;
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-left: 1rem;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-right: 1rem;
}

.timeline-content h4 {
    color: #FF6B35;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
}

.timeline-content p {
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    width: 20px;
    height: 20px;
    background: #FF6B35;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    z-index: 3;
    border: 4px solid white;
    box-shadow: 0 0 0 4px #FF6B35;
}

/* Achievements Section */
.achievements-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.achievements-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.achievements-section .section-title {
    color: white;
}

.achievements-section .section-subtitle {
    color: rgba(255, 255, 255, 0.9);
}

.achievement-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 2.5rem;
    border-radius: 20px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.achievement-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
}

.achievement-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.achievement-number {
    font-size: 3rem;
    font-weight: 800;
    color: #FFE0B2;
    margin-bottom: 0.5rem;
}

.achievement-label {
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
    
    .mission-card, .vision-card {
        padding: 2rem;
    }
    
    .value-card {
        padding: 2rem;
    }
    
    .team-content {
        padding: 1.5rem;
    }
    
    .achievement-card {
        padding: 2rem;
    }
    
    .timeline::before {
        left: 30px;
    }
    
    .timeline-item {
        flex-direction: column !important;
        padding-left: 60px;
    }
    
    .timeline-item:nth-child(odd),
    .timeline-item:nth-child(even) {
        flex-direction: column !important;
    }
    
    .timeline-year {
        margin: 0 0 1rem 0 !important;
        align-self: flex-start;
    }
    
    .timeline-content {
        margin: 0 !important;
    }
    
    .timeline-item::before {
        left: 30px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .mission-card, .vision-card {
        padding: 1.5rem;
    }
    
    .value-card {
        padding: 1.5rem;
    }
    
    .team-content {
        padding: 1rem;
    }
    
    .achievement-card {
        padding: 1.5rem;
    }
}
</style>
@endpush