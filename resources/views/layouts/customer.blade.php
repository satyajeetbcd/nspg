<!DOCTYPE html>
<html lang="{{ $uiLocale }}" dir="{{ $textDir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Dashboard') - {{ config('app.name', 'FERP Controller') }}</title>

    @if ($textDir=='rtl')
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.min.css') }}">
    @endif

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap');

        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        html[dir="rtl"] > body {
            font-family: 'Tajawal', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        /* RTL: place sidebar on the right */
        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        /* RTL: hover slide direction flips */
        [dir="rtl"] .sidebar .nav-link:hover,
        [dir="rtl"] .sidebar .nav-link.active {
            transform: translateX(-5px);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        /* RTL: icon spacing flips */
        [dir="rtl"] .sidebar .nav-link i {
            margin-right: 0;
            margin-left: 10px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* RTL: push content from the right side */
        [dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: var(--sidebar-width);
        }

        .top-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 12px 30px;
            margin-bottom: 20px;
        }

        .content-area {
            padding: 0 30px 30px;
        }

        .user-profile-dropdown .dropdown-toggle::after {
            display: none;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            padding: 20px;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px 5px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }

            /* RTL: slide sidebar in/out from the right on mobile */
            [dir="rtl"] .sidebar {
                transform: translateX(100%);
            }

            [dir="rtl"] .sidebar.show {
                transform: translateX(0);
            }
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: bold;
        }

        /* Breadcrumbs UX */
        nav.breadcrumb-wrap {
            margin-bottom: 0;
        }
        .breadcrumb {
            --bs-breadcrumb-divider: '›';
            font-size: 1.05rem;
            margin-bottom: 0;
        }
        .breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
            padding-right: .5rem;
            padding-left: .5rem;
        }
        .breadcrumb .breadcrumb-item a {
            color: #495057;
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb .breadcrumb-item a:hover {
            color: #0d6efd;
            text-decoration: underline;
        }
        .breadcrumb .breadcrumb-item.active {
            color: #0d6efd;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <a href="{{ route('customer.dashboard', ) }}" class="brand-logo">
            <i class="fas fa-chart-line me-2"></i>
            FERP Controller
        </a>

        @include('partials.customer.sidebar')
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center w-100">
                <button class="btn btn-outline-secondary d-md-none me-3 mobile-toggle" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-grow-1">
                    @hasSection('breadcrumbs')
                        @yield('breadcrumbs')
                    @else
                        @include('partials.customer.breadcrumbs', ['items' => $breadcrumbs ?? []])
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center">
                <!-- Notifications -->
                <div class="dropdown_menu me-3">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger badge-sm">3</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">Email verification pending</a></li>
                        <li><a class="dropdown-item" href="#">Plan expires in 30 days</a></li>
                        <li><a class="dropdown-item" href="#">New invoice available</a></li>
                    </ul>
                </div>

                <!-- Language Switcher -->
                <div class="dropdown me-3">
                    <button class="btn btn-outline-secondary d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe me-1"></i>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">{{ __('Language') }}</li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('public.change.language', ['lang' => 'en', 'return_to' => request()->path()]) }}">
                                <span class="me-2">🇺🇸</span> English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('public.change.language', ['lang' => 'ar', 'return_to' => request()->path()]) }}">
                                <span class="me-2">🇸🇦</span> العربية
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Profile -->
                <div class="dropdown user-profile-dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <img src="{{ auth()->guard('customer')->user()->avatar }}"
                             class="rounded-circle me-2" width="32" height="32" alt="Profile">
                        <span>{{ auth()->guard('customer')->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('customer.profile.index', ) }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('public.logout', ) }}">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
