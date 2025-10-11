@extends('frontend.layouts.app')

@section('title', 'NSPG Calculator - Solar Savings Calculator | Nirmala Solar Power Generation')

@section('content')
<!-- Hero Section -->
<section class="hero-section calculator-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container mt-5">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-12 mx-auto text-center">
                    <div class="hero-badge mt-5">
                        <i class="fas fa-calculator me-2"></i>
                        Solar Calculator
                    </div>
                    <h1 class="hero-title mb-4">
                        NSPG
                        <span class="text-primary">Calculator</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Calculate your potential savings with solar energy. 
                        Discover how much you can save on your electricity bills and reduce your carbon footprint.
                    </p>
                    <div class="">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">25+</h3>
                                    <p class="stat-label">Years Savings</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">60%</h3>
                                    <p class="stat-label">Max Subsidy</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">100%</h3>
                                    <p class="stat-label">Free Consultation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solar Calculator Section -->
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

<!-- Benefits Section -->
<section class="py-5 benefits-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Choose Solar Energy?</h2>
            <p class="section-subtitle">Discover the benefits of switching to solar power</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h4>Save Money</h4>
                    <p>Reduce your electricity bills by up to 90% and save thousands of rupees annually.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4>Eco-Friendly</h4>
                    <p>Reduce your carbon footprint and contribute to a cleaner, greener environment.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Long-term Investment</h4>
                    <p>Solar panels last 25+ years with minimal maintenance, providing long-term returns.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-trending-up"></i>
                    </div>
                    <h4>Energy Independence</h4>
                    <p>Reduce dependence on grid electricity and protect against rising energy costs.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4>Government Subsidies</h4>
                    <p>Avail up to 60% government subsidies and additional NSPG discounts.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4>Increase Property Value</h4>
                    <p>Solar installations increase your property value and market appeal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

</script>
@endpush

@push('styles')
<style>
:root {
    --primary-orange: #ff6b35;
    --primary-orange-light: #f7931e;
    --text-dark: #333;
    --text-light: #6c757d;
}


/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.calculator-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e40af 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.calculator-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.calculator-hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 20% 80%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(30, 58, 138, 0.1) 0%, rgba(59, 130, 246, 0.2) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
    animation: fadeInUp 1s ease-out;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 100vh;
    padding: 60px 0;
}

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

.hero-badge {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.hero-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(255, 107, 53, 0.4);
}

.hero-badge i {
    margin-right: 8px;
    font-size: 1.1em;
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 25px;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    letter-spacing: -1px;
}

.hero-title .text-primary {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none;
    position: relative;
}

.hero-title .text-primary::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 2px;
}

.hero-subtitle {
    font-size: 1.4rem;
    margin-bottom: 40px;
    opacity: 0.95;
    line-height: 1.7;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    font-weight: 400;
    position: relative;
}

.hero-subtitle::before {
    content: '';
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 2px;
}


.hero-stats {
    display: flex;
    gap: 60px;
    justify-content: center;
    margin-top: 20px;
    position: relative;
}

.hero-stats::before {
    content: '';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 2px;
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.3) 0%, rgba(59, 130, 246, 0.3) 100%);
    border-radius: 1px;
}

.stat-item {
    text-align: center;
    padding: 25px 20px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    min-width: 180px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.stat-item:hover::before {
    left: 100%;
}

.stat-item:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 107, 53, 0.5);
}

.stat-item:hover .stat-number {
    color: #ff6b35;
    transform: scale(1.1);
    text-shadow: 0 4px 8px rgba(255, 107, 53, 0.4);
}

.stat-item:hover .stat-label {
    color: #ff6b35;
    text-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
    background: rgba(255, 107, 53, 0.2);
    transform: scale(1.05);
}

.stat-item .stat-number,
.stat-item .stat-label {
    position: relative;
    z-index: 1;
}

.stat-item .stat-number {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none;
}

.stat-item:hover .stat-number {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none;
}

.stat-item h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-orange);
    margin: 0;
    position: relative;
    z-index: 1;
}

.stat-item p {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.stat-number {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 15px;
    color: #ff6b35;
    text-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);
    display: block;
    transition: all 0.3s ease;
    line-height: 1;
    letter-spacing: -1px;
}

.stat-label {
    font-size: 1.2rem;
    margin: 0;
    opacity: 1;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.3s ease;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    line-height: 1.2;
    background: rgba(0, 0, 0, 0.2);
    padding: 5px 10px;
    border-radius: 8px;
    display: inline-block;
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

.section-subtitle {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--text-light);
    margin-bottom: 30px;
}


/* Benefits Section */
.benefits-section {
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


/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.8rem;
    }
    
    .hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

    .hero-badge {
        padding: 10px 25px;
    font-size: 0.9rem;
}

    .section-title {
        font-size: 2rem;
    }
    
    .hero-stats {
    flex-direction: column;
        gap: 25px;
        margin-top: 30px;
    align-items: center;
    }
    
    .stat-item {
        padding: 20px;
        min-width: 200px;
        max-width: 250px;
    }
    
    .stat-item h3 {
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 3rem;
    }
    
    .stat-label {
        font-size: 1.1rem;
    }
    
    .benefits-section {
        padding: 60px 0;
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
        font-size: 2.2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
        margin-bottom: 25px;
    }
    
    .hero-badge {
        padding: 8px 20px;
        font-size: 0.85rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .hero-stats {
        gap: 20px;
        margin-top: 25px;
        align-items: center;
    }
    
    .stat-item {
        padding: 18px;
        min-width: 180px;
        max-width: 220px;
    }
    
    .stat-number {
        font-size: 2.8rem;
    }
    
    .stat-label {
        font-size: 1rem;
    }
    
    .benefits-section {
        padding: 40px 0;
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
@endpush