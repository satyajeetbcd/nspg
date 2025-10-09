@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])

@section('content')
    @php

        $local = app()->getLocale();

        $countService = 0;
        $items = [
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-1.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-2.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-3.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-4.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-5.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-6.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-7.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-8.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-9.jpg',
            ],
            [
                'name' => 'www.thefuture-erp.com',
                'img' => 'assets/landing/parenter/par-10.jpg',
            ],
        ];
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .video-demo {
            background-size: 22px;
            height: 500px;
            background: url('assets/landing/img/hololVideoImage.jpg') no-repeat center center;
            background-position: center;

        }
    </style>
    {{-- <!-- Hero area %%%%%%%%%%%%%%%%%%%%%%%%%% --> --}}
    <section class="hero-area">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="hero-content-wrapper">
                                    <div class="hero-content-wrap">
                                        <div class="hero-content-img">
                                            <img src="assets/landing/img/hero-slider-1.jpg" alt />
                                        </div>
                                        <div class="hero-content">
                                            <!-- <h2>{{ __('Creative') }}</h2> -->
                                            <h1>{{ __('business_title') }}</h1>
                                            <p>
                                                {{ __('business_paragraph') }}
                                            </p>
                                            <a href="{{ route('public.page', ['slug' => 'about']) }}"
                                                class="about-btn">{{ __('About us') }}</a>
                                            <a href="#"
                                                class="work-btn">{{ __('Share your opinion') }}</a>
                                            <div class="slider-num">
                                                <span>01</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="hero-content-wrapper">
                                    <div class="hero-content-wrap">
                                        <div class="hero-content-img">
                                            <img src="assets/landing/img/hero-slider-2.png" alt />
                                        </div>
                                        <div class="hero-content">
                                            <!-- <h2>{{ __('Creative') }}</h2> -->
                                            <h1>{{ __('markets_title') }}</h1>
                                            <p>
                                                {{ __('markets_paragraph') }}
                                            </p>
                                            <a href="{{ route('public.page', ['slug' => 'about']) }}"
                                                class="about-btn">{{ __('About us') }}</a>
                                            <a href="#"
                                                class="work-btn">{{ __('Share your opinion') }}</a>
                                            <div class="slider-num">
                                                <span>02</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="hero-content-wrapper">
                                    <div class="hero-content-wrap">
                                        <div class="hero-content-img">
                                            <img src="assets/landing/img/hero-slider-3.jpg" alt />
                                        </div>
                                        <div class="hero-content">
                                            <!-- <h2>{{ __('Creative') }}</h2> -->
                                            <h1>{{ __('finances_title') }}</h1>
                                            <p>
                                                {{ __('finances_paragraph') }}
                                            </p>
                                            <a href="{{ route('public.page', ['slug' => 'about']) }}"
                                                class="about-btn">{{ __('About us') }}</a>
                                            <a href="#"
                                                class="work-btn">{{ __('Share your opinion') }}</a>
                                            <div class="slider-num">
                                                <span>03</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>


        @php
            $websiteSettings = App\Helpers\WebsiteSettingsHelper::getWebsiteSettings();
        @endphp
        <div class="social-media">
            <ul class="social-list">
                @if(isset($websiteSettings['social_media_links']))
                    @foreach($websiteSettings['social_media_links'] as $socialLink)
                        <li><a target="_blank" href="{{ $socialLink['url'] }}">{{ ucfirst($socialLink['platform']) }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </section>

    {{-- <!-- End Hero area %%%%%%%%%%%%%%%%% --> --}}

    {{-- <!-- service area %%%%%%%%%%%%%%%%%%%%%%%% --> --}}
    <section id="services-section" class="service-area sec-pad">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="title">
                        <span>
                            {{ __('what we do') }}
                        </span>
                        <h2>
                            {{ __('we work performed for client happy.') }}
                        </h2>
                        <div class="cmn-btn">
                            <!-- Update the button to trigger expansion of services -->
                            <a href="javascript:void(0);" id="view-more-btn">
                                {{ __('view all services') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-8 col-xl-8">
                    <div class="row g-4" id="services-container">
                        @foreach ($globalSetting->discover_of_features as $index => $service)
                            @php
                                // Use icon from database settings, fallback to default
                                $serviceIcon = $service->discover_icon ?? 'fas fa-cog';
                                // Hide services beyond the first 4 by default
                                $isHidden = $loop->index >= 4 ? 'd-none' : '';
                            @endphp
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 service-item {{ $isHidden }}" data-service-index="{{ $loop->index }}">

                                <div class="single-service">
                                    <span class="count">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                                    <div class="service-icon">
                                        <i class="{{ $serviceIcon }}"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4>{{ __($service->discover_heading) }}</h4>
                                        <p data-full="{{ __($service->discover_description) }} ">
                                            {{ Str::limit(__($service->discover_description), 100) }}</p>
                                        <a class="btn-show-more">
                                            {{ __('read more') }}
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>

        </div>
        </div>
    </section>

    <!-- js -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select all <p> elements with 'data-full' and all 'Read more' buttons
                const paragraphs = document.querySelectorAll('p[data-full]');
                const btnShowMore = document.querySelectorAll('.btn-show-more');

                // Define the translated strings in JavaScript
                const readMoreText = "{{ __('read more') }}";
                const readLessText = "{{ __('read less') }}";
                const readMoreService = "{{ __('view all services') }}";
                const readLessService = "{{ __('view less') }}";

                // Loop through each button and add an event listener
                btnShowMore.forEach((btn, index) => {
                    let isExpanded = false; // Track if the paragraph is expanded

                    btn.addEventListener('click', function() {
                        const fullText = paragraphs[index].dataset.full;
                        const truncatedText = fullText.slice(0, 100); // Truncate text to 100 characters

                        // Toggle between expanded and collapsed states
                        if (isExpanded) {
                            paragraphs[index].textContent = truncatedText +
                                '...'; // Show truncated text
                            btn.textContent = readMoreText; // Change button text back to 'Read more'
                        } else {
                            paragraphs[index].textContent = fullText; // Show full text
                            btn.textContent = readLessText; // Change button text to 'Read less'
                        }

                        isExpanded = !isExpanded; // Toggle the expanded state
                    });
                });

                // View more services functionality
                const viewMoreBtn = document.getElementById('view-more-btn');
                const serviceItems = document.querySelectorAll('.service-item');

                if (viewMoreBtn && serviceItems.length > 0) {
                    let showingAll = false; // Track if all services are visible

                    viewMoreBtn.addEventListener('click', function() {
                        // Toggle visibility of services beyond the first 4
                        serviceItems.forEach((item, index) => {
                            if (index >= 4) { // Services 5 and beyond (0-indexed)
                                item.classList.toggle('d-none');
                            }
                        });

                        // Toggle the state and update button text
                        showingAll = !showingAll;

                        if (showingAll) {
                            this.textContent = readLessService; // "View Less"
                        } else {
                            this.textContent = readMoreService; // "View All Services"
                        }
                    });
                }
            });
        </script>
    @endpush
    <!-- End Service area %%%%%%%%%%%%%%%%%%%%%% -->








    <!-- About Area %%%%%%%%%%%%%%%%%%%%% -->
    <section id="about-us-section" class="about-area sec-mar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="about-left">
                        <div class="title black">
                            <span>{{ __('About us') }}</span>
                            <h2 class="mb-15">{{ __('Direction with our company.') }}</h2>
                        </div>
                        <div class="our_copany">
                            {{ __('Our company') }}
                            <div class="bg-gray-100 py-12">
                                <div class="max-w-6xl mx-auto px-6">
                                    <ul class="">
                                        {{-- Service One --}}
                                        <li
                                            class="flex items-start space-x-4 bg-white shadow-md rounded-lg p-4 border-l-4 border-[#004f86]">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="text-[#004f86] text-2xl position-relative">
                                                        <span
                                                            style="font-size: 90px; position: absolute; left: -28px; top: -12px;">🔍</span>
                                                        {{-- Replace with an actual icon --}}
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <h3 class="text-xl font-semibold text-[#004f86]">{{ __('vision') }}
                                                    </h3>
                                                    <p class="text-gray-700 mt-1">
                                                        <span x-data="{ open: false }">
                                                            <span x-show="!open">
                                                                {{ __("To become the leading partner for companies and factories in their journey towards digital transformation by providing the world's first system that enables the highest...") }}
                                                            </span>
                                                            <span x-show="open">
                                                                {{ __('levels of efficiency and integration across various departments within organizations, supporting their sustainable growth in a dynamic and ever-changing market. We aspire for the solutions we offer to be a benchmark for quality and innovation in business management across all forms.') }}
                                                            </span>
                                                            <a @click="open = !open" class="text-blue-500  underline"
                                                                style="cursor:pointer;">
                                                                <span x-show="!open">{{ __('Read More') }}</span>
                                                                <span x-show="open">{{ __('Read Less') }}</span>
                                                            </a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>

                                        {{-- Service Two --}}
                                        <li
                                            class="flex items-start space-x-4 bg-white shadow-md rounded-lg p-4 border-l-4 border-[#004f86]">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="text-[#004f86] text-2xl position-relative">
                                                        <span
                                                            style="font-size: 90px; position: absolute; left: -28px; top: -12px;">
                                                            🎯 </span>{{-- Replace with an actual icon --}}
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <h3 class="text-xl font-semibold text-[#004f86]">{{ __('goal') }}
                                                    </h3>
                                                    <p class="text-gray-700 mt-1">
                                                        <span x-data="{ open: false }">
                                                            <span x-show="!open">
                                                                {{ __('We aim to empower companies to achieve the highest levels of efficiency and effectiveness...') }}
                                                            </span>
                                                            <span x-show="open">
                                                                {{ __('increase their business volume, and accommodate that growth. Therefore, we continuously strive to develop the services we offer and improve business processes by integrating all company departments into a single platform. This enhances collaboration, facilitates data-driven decision-making, and supports sustainable growth. We are committed to providing tailored solutions that help companies achieve their strategic goals and overcome the challenges of an ever-changing market.') }}
                                                            </span>
                                                            <a @click="open = !open" class="text-blue-500  underline"
                                                                style="cursor:pointer;">
                                                                <span x-show="!open">{{ __('Read More') }}</span>
                                                                <span x-show="open">{{ __('Read Less') }}</span>
                                                            </a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                        </li>

                                        {{-- Service Three --}}
                                        <li
                                            class="flex items-start space-x-4 bg-white shadow-md rounded-lg p-4 border-l-4 border-[#004f86]">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="text-[#004f86] text-2xl position-relative">
                                                        <i class="fas fa-file-alt"
                                                           style="font-size: 60px; position: absolute; left: -20px; top: -10px;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <h3 class="text-xl font-semibold text-[#004f86]">{{ __('mission') }}
                                                    </h3>
                                                    <p class="text-gray-700 mt-1">
                                                        <span x-data="{ open: false }">
                                                            <span x-show="!open">
                                                                {{ __('Achieving the concept of sustainability by reducing the use of paper and ink in written reports and replacing them with electronic reports...') }}
                                                            </span>
                                                            <span x-show="open">
                                                                {{ __("Communicating in the language of the modern era using the latest software tools and technologies to serve companies and factories, helping them accelerate and simplify sales processes and cost calculations across businesses of all sizes at minimal costs. Establishing a new concept of automation as the world's new vision for relying on technology by executing all operations within an organization or company through automated software systems that connect all departments practically and administratively to facilitate their work. Reducing industrial and administrative costs by controlling the accounting of input and output in operations and manufacturing across all production stages, ensuring precise cost calculations in real-time, and achieving the objectives set by top management.") }}
                                                            </span>
                                                            <a @click="open = !open" class="text-blue-500  underline"
                                                                style="cursor:pointer;">
                                                                <span x-show="!open">{{ __('Read More') }}</span>
                                                                <span x-show="open">{{ __('Read Less') }}</span>
                                                            </a>
                                                        </span>
                                                    </p>

                                                </div>
                                            </div>


                                        </li>
                                    </ul>
                                </div>
                            </div>



                        </div>
                        <div class="cmn-btn text-center">
                            <a
                                href="{{ route('public.page', ['slug' => 'about']) }}">{{ __('Learn more about us') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6">
                    <div class="about-right">
                        <div class="group-images">
                            <img src="assets/landing/img/team.jpg" alt />

                            <div class="row pt-5">
                                <div class="col-2">
                                    <div class="msn-icon">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <h5>{{ __('Our Mission') }}</h5>
                                    <p>{{ __('Our mission') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="features-count">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="single-count">
                                <i class="fas fa-users"></i>
                                <div class="counter">
                                    <span class="odometer">250</span><sup>+</sup>
                                </div>
                                <p>
                                    {{ __('SatisfiedClients') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="single-count">
                                <i class="fas fa-user-tie"></i>
                                <div class="counter">
                                    <span class="odometer">150</span><sup>+</sup>
                                </div>
                                <p>
                                    {{ __('ExpertTeams') }}
                                </p>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                  <div class="single-count xsm">
                                    <i><img src="assets/landing/img/icons/count-4.png" alt /></i>
                                    <div class="counter">
                                      <span class="odometer">28</span><sup>+</sup>
                                    </div>
                                    <p>
                                      {{ __('Win Awards') }}
                                    </p>
                                  </div>
                                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area %%%%%%%%%%%%%%%% -->

    <!-- parenter area %%%%%%%%%%%%%%%% -->
    <section class="our-partner">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row align-items-center g-0">
                <div class="col-12 col-xl-6">
                    <div class="newsletter">
                        <div class="subscribes">
                            <span>
                                {{ __('Get In Touch') }}
                            </span>
                            <h1>
                                {{ __('Subscribe Our') }}
                            </h1>
                            <h2>
                                {{ __('Newsletter') }}
                            </h2>
                            <div class="subscribe-form">
                                <form action="#" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="email" name="email" placeholder="{{ __('Type Your Email') }}" />
                                    <input type="submit" value="{{ __('Connect') }}" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="our-clients">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-lg-4 col-xl-6">
                                <div class="title">
                                    <span>
                                        {{ __('Our partner') }}
                                    </span>
                                    <h2>
                                        {{ __('Join our Holol community.') }}
                                    </h2>
                                </div>
                            </div>
                            @foreach ($items as $item)
                                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                    <div class="single-client">
                                        <img class="w-100 h-100" src="{{ asset($item['img']) }}" alt />
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End parenter Area %%%%%%%%%%%%%% -->

    <!-- why choice us %%%%%%%%%%%%%%% -->
    <section class="why-choose-us sec-mar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="title black">
                        <span class="pricing_plan">
                            {{ __('Why Choose Us') }}<i class="fa-solid fa-circle-user"></i>
                        </span>
                        <h2 class="mb-15">
                            {{ __('Success awaits you with the Future System') }}
                        </h2>
                    </div>
                    <div class="video-demo" style="height: 500px;">

                        <div class="play-btn">
                            <a class="popup-video" href="{{ asset('public/assets/landing/futureerp.mp4') }}"><i
                                    class="fas fa-play"></i>
                                {{ __('Play now') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>

    </section>
    <!-- End Why Choice us %%%%%%%%%%%%%% -->
    <!-- Let Talk %%%%%%%%%%%%%%%% -->
    <section class="lets-talk sec-pad">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9 col-lg-8 col-xl-8">
                    <div class="title special">
                        <span>
                            {{ __('Let’s Talk') }}
                        </span>
                        <h2>{{ __('About Your Next') }} <b>{{ __('Projectk') }}</b> {{ __('Your Mind') }}</h2>
                    </div>
                </div>
                <div class="col-md-3 col-lg-4 col-xl-4 text-end">
                    <div class="getin-touch">
                        <div class="cmn-btn">
                            <a href="contact"
                                style="width: 346px;text-align: center;font-size: 42px;font-weight: 800;">{{ __('Get In Touch') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Let Talk %%%%%%%%%%%%%%%%%% -->

    {{-- Removed currency toggle script; prices now follow locale/currency selection server-side --}}


@endsection
