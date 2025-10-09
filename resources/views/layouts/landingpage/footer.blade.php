@if (isset($footer) && $footer !== false)

    <footer>

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="{{ route('public.home') }}">
                                <img src="{{ asset('storage/uploads/landing_page_image/' . $siteLogo) }}"
                                    style="max-width:100px;" alt="">
                            </a>
                        </div>
                        @php
                            $websiteSettings = App\Helpers\WebsiteSettingsHelper::getWebsiteSettings();
                        @endphp
                        <address>
                            <h4>{{ __('Office') }}</h4>
                            @if (isset($websiteSettings['contact_info']['addresses']))
                                @php
                                    $currentLang = App::isLocale('ar') ? 'ar' : 'en';
                                    $addresses = $websiteSettings['contact_info']['addresses'][$currentLang] ?? [];
                                @endphp
                                @foreach ($addresses as $address)
                                    <p><i class="fas fa-map-marker-alt text-danger"></i>
                                        {{ $address }}</p>
                                @endforeach
                            @else
                                <p><i class="fas fa-map-marker-alt text-danger"></i>
                                    {{ $websiteSettings['address'] }}</p>
                            @endif
                        </address>
                        <ul class="social-media-icons">
                            @if (isset($websiteSettings['social_media_links']))
                                @foreach ($websiteSettings['social_media_links'] as $socialLink)
                                    <li><a target="_blank" href="{{ $socialLink['url'] }}"><i
                                                class="{{ $socialLink['icon'] }}"></i></a></li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="d-flex w-100 justify-content-start mt-2 align-items-center">
                            <img src="{{ asset('assets/dashboard/images/visa&mastercard.png') }}" style="width:200px"
                                alt="">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="footer-widget">
                        <h4>{{ __('Company') }}</h4>
                        <ul class="footer-menu">
                            <li>
                                <a href="{{ route('public.page', ['slug' => 'about']) }}">
                                    {{ __('About Us') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.page', ['slug' => 'terms']) }}">
                                    {{ __('Terms and Conditions') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.page', ['slug' => 'privacy']) }}">
                                    {{ __('Privacy Policy') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.contact') }}" class="active">
                                    {{ __('Contact Us') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.page', ['slug' => 'refund']) }}" class="active">
                                    {{ __('Refund Policy') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="footer-widget">
                        {{-- Section Title --}}
                        <h4>{{ __('Contact') }}</h4>

                        {{--  Check if "contact_phone" key exists in $websiteSettings --}}
                        @if (isset($websiteSettings['contact_phone']))

                            {{--  Check if "contact_phone" array is not empty --}}
                            @if (!empty($websiteSettings['contact_phone']))

                                {{-- ==================== Contact Phones ==================== --}}
                                <div class="row mb-4">
                                    {{-- Phone Icon Column --}}
                                    <div class="col-1 align-items-center d-flex justify-content-start">
                                        <i class="fa-solid fa-phone text-primary me-2"></i>
                                    </div>

                                    {{-- Phone Numbers Column --}}
                                    <div class="col-8">
                                        {{-- Loop through each phone entry --}}
                                        @if(isset($websiteSettings['contact_phone']) && is_array($websiteSettings['contact_phone']))
                                            @foreach ($websiteSettings['contact_phone'] as $phone)
                                            <div class="">
                                                <span class="text-white fs-6">
                                                    {{-- Display Country and Phone Number --}}
                                                    {{ $phone['country'] }}: {{ $phone['value'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="">
                                                <span class="text-white fs-6">
                                                    Contact: +1-555-0123
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- ================== End Contact Phones ================== --}}

                                {{-- ==================== Contact Emails ==================== --}}
                                <div class="row">
                                    {{-- Email Icon Column --}}
                                    <div class="col-1 align-items-center d-flex justify-content-start">
                                        <i class="fa-solid fa-envelope text-primary me-2"></i>
                                    </div>

                                    {{-- Email Addresses Column --}}
                                    <div class="col-8">
                                        {{-- Loop through each email entry --}}
                                        @if(isset($websiteSettings['contact_email']) && is_array($websiteSettings['contact_email']))
                                            @foreach ($websiteSettings['contact_email'] as $phone)
                                            <div class="">
                                                <span class="text-white fs-6">
                                                    {{-- Display Email Address --}}
                                                    {{ $phone['value'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="">
                                                <span class="text-white fs-6">
                                                    {{ $websiteSettings['contact_email'] ?? 'info@futureerp.com' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- ================== End Contact Emails ================== --}}

                            @endif
                            {{-- End Check if "contact_phone" not empty --}}

                        @endif
                        {{-- End Check if "contact_phone" key exists --}}

                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 col-lg-4 col-xl-5">
                        <div class="copy-txt">
                            <span>Copyright by {{ $websiteSettings['title'] }} © {{ date('Y') }}.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.getElementById('customAlert');
        if (alertBox) setTimeout(() => alertBox.remove(), 3000);
    });
</script>
<div class="scroll-top"><span>Top<i class="bi bi-arrow-up"></i></span></div>
<script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/version-5.3.8-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/jQuery-plugin-progressbar.js') }}"></script>
<script src="{{ asset('assets/landing/js/jquery.barfiller.js') }}"></script>
<script src="{{ asset('assets/landing/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/landing/js/custom.js') }}"></script>
</body>

</html>
