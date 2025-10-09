
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
        $websiteSettings = App\Helpers\WebsiteSettingsHelper::getWebsiteSettings();
    @endphp

    <title>@yield('title', $websiteSettings['title'])</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ $websiteSettings['title'] }}">
    <meta name="description" content="{{ $websiteSettings['description'] }}">
    <meta name="keywords" content="{{ $websiteSettings['keywords'] }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $websiteSettings['title'] }}">
    <meta property="og:description" content="{{ $websiteSettings['description'] }}">
    <meta property="og:image" content="{{ asset('storage/uploads/landing_page_image/' . $siteLogo) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $websiteSettings['title'] }}">
    <meta property="twitter:description" content="{{ $websiteSettings['description'] }}">
    <meta property="twitter:image" content="{{ asset('storage/uploads/landing_page_image/' . $siteLogo) }}">


    <!-- Favicon -->
    {{-- <link rel="icon" href="{{ $sup_logo . '/' . $adminSettings['company_favicon'] }}" type="image/x-icon" /> --}}

    <link rel="icon" href="{{ asset('storage/uploads/logo/' . $companyFavicon) }}"
        type="image/x-icon" />
    <!-- CSS -->

    @if (App::isLocale('ar'))
        <link id="stylesheet-rtl" rel="stylesheet" href="{{ asset('assets/landing/css/rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/version-7.0.0-web/css/all.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/landing/css/swiper-bundle.min.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Style -->
    <link id="stylesheet-main" rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">


    <style>
        :root {
            --color-customColor: {{ $customColor }};
        }

        .custom-alert {
            position: fixed;
            top: 20px;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 9000;
        }
    </style>

    @stack('scripts')
</head>

<body>
    <!-- Toast Container -->
    <!-- Toast Container at Bottom Right -->
    <!-- Only show toast messages when NOT on authentication pages -->
    @php
        $currentRoute = request()->route()->getName();
        $isAuthPage = in_array($currentRoute, [
            'public.login',
            'public.register',
            'public.login.submit',
            'public.register.submit',
            'public.password.request',
            'public.password.reset',
            'public.password.email',
            'public.password.update',
            'public.verification.notice',
            'public.verification.resend',
            'public.verification.verify'
        ]);
    @endphp

    @if (!$isAuthPage)
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
            @if (session('success'))
                <div class="toast align-items-center text-bg-success border-0 fade" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ __(session('success')) }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
                <audio id="toastSound" src="{{ asset('assets/sounds/success.mp3') }}"></audio>
            @elseif(session('failed'))
                <div class="toast align-items-center text-bg-danger border-0 fade" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ __(session('failed')) }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
                <audio id="toastSound" src="{{ asset('assets/sounds/failed.mp3') }}"></audio>
            @endif
        </div>
    @endif




    @if (isset($header) && $header !== false)
        <div class="main">
            <header class="position_top shadow-sm">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <div class="logo" style="width:100px;">
                                <a href="{{ route('public.home', ) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                    <img src="{{ asset('storage/uploads/landing_page_image/' . $siteLogo) }}"
                                        width="70" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-11 menu_bar">
                            <nav class="main-nav d-flex align-items-center justify-content-between">
                                {{-- Logo --}}
                                <div class="mobile-menu-logo" style="width:100px;">
                                    <a href="{{ route('public.home', ) }}">
                                        <img src="{{ asset('storage/uploads/landing_page_image/' . $siteLogo) }}"
                                            alt="Logo">
                                    </a>
                                </div>

                                {{-- Menu --}}
                                <div class="row">
                                    <div class="col-lg-11">
                                        <ul class="main-menu text-center d-lg-flex align-items-center m-0">
                                            {{-- Home Page --}}
                                            <li><a class="list_nav"
                                                    href="{{ route('public.home', ) }}">{{ __('Home') }}</a>
                                            </li>
                                            {{-- Plans Page --}}
                                            <li><a class="list_nav"
                                                    href="{{ route('public.pricing', ) }}">{{ __('Pricing') }}</a></li>
                                            {{-- Contact Page --}}
                                            <li><a class="list_nav"
                                                    href="{{ route('public.contact', ) }}">{{ __('Contact') }}</a></li>
                                            {{-- About Page --}}
                                            <li><a class="list_nav"
                                                    href="{{ route('public.page', ['slug' => 'about']) }}">{{ __('About') }}</a>
                                            </li>
                                        </ul>
                                    </div>


                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <ul class="main-menu d-lg-flex align-items-center m-0">
                                            {{-- Language Switcher --}}
                                            <li class="has-child list_nav">
                                                <a href="javascript:void(0)" class="text-dark">
                                                    {{ __('Languages') }}
                                                    <i class="bi bi-chevron-down text-dark pt-0"></i>
                                                </a>
                                                <ul class="sub-menu">
                                                    @foreach ($languages as $code => $language)
                                                        @php
                                                            $currentLocale = session('locale', config('locale.default', 'en-SA'));
                                                            $currentLangCode = substr($currentLocale, 0, 2);
                                                            $targetLocale = $localeMap[$code] ?? $code . '-SA';
                                                        @endphp
                                                        <li>
                                                            <a class="{{ $currentLangCode == $code ? 'active' : '' }}"
                                                                href="{{ route('public.change.language', $code) }}?return_to={{ urlencode(request()->path()) }}">
                                                                {{ ucfirst($language) }}
                                                                <small class="text-muted">({{ $targetLocale }})</small>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                            {{-- Authentication --}}
                                            @if (isset(Auth::user()->name))
                                                <li class="get-quate"><a
                                                        href="{{ route('redirect') }}">{{ Auth::user()->name }}</a>
                                                </li>
                                            @else
                                                @php
                                                    $currentLocale = session('locale', config('locale.default', 'en-SA'));
                                                @endphp
                                                <li class="get-quate"><a
                                                        href="{{ route('public.login', ['locale' => $currentLocale]) }}">{{ __('Login') }}</a></li>
                                                <li class="get-quate"><a
                                                        href="{{ route('public.register', ['locale' => $currentLocale]) }}">{{ __('Register') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                            </nav>

                            {{-- Mobile Menu Toggle --}}
                            <div class="mobile-menu">
                                <a href="javascript:void(0)" class="cross-btn">
                                    <span class="cross-top"></span>
                                    <span class="cross-middle"></span>
                                    <span class="cross-bottom"></span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        delay: 4000,
                        animation: true
                    });
                });

                toastList.forEach(toast => {
                    toast.show();
                    // Play sound when toast appears
                    var sound = document.getElementById('toastSound');
                    if (sound) sound.play();
                });
            });
        </script>

    @endif
