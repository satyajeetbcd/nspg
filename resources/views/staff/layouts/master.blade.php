{{--
    File: resources/views/layouts/master.blade.php
    Staff Dashboard Master Layout
    Clean and structured for ERP system
--}}

<!DOCTYPE html>
<html lang="{{ $uiLocale }}" dir="{{ $textDir }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <meta name="title" content="{{ $globalSetting?->meta_title ?? '' }}">
    <meta name="description" content="{{ $globalSetting?->meta_desc ?? '' }}">

    <title>{{ config('app.name', 'Holol-tec') }} - @yield('page-title')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/fonts/tabler-icons.min.css') }}">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap-utilities.rtl.min.css') }}">

    {{-- Plugins --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.2.1/hamburgers.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">

    {{-- Unified Staff Panel Design System --}}
    @include('staff.layouts.styles')

    @stack('style')

    <style>
        /* Global Custom Color */
        :root {
            --color-customColor: #074170;
            --color-primary: #074170;
            --color-secondary: #6c757d;
            --color-success: #198754;
            --color-danger: #dc3545;
            --color-warning: #ffc107;
            --color-info: #0dcaf0;
            --color-light: #f8f9fa;
            --color-dark: #212529;
            --border-radius: 0.5rem;
            --box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --box-shadow-lg: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        main {
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        /* Container for consistent width */
        .container {
            max-width: 1200px;
        }

        /* Enhanced Card Styles */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--box-shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        /* Enhanced Button Styles */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--box-shadow);
        }

        /* Enhanced Form Styles */
        .form-control,
        .form-select {
            border-radius: var(--border-radius);
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(7, 65, 112, 0.25);
        }

        /* Enhanced Table Styles */
        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .table thead th {
            border-bottom: 2px solid var(--color-primary);
            font-weight: 600;
            color: black;
        }

        /* Enhanced Badge Styles */
        .badge {
            border-radius: var(--border-radius);
            font-weight: 500;
        }

        /* Enhanced Dropdown Styles */
        .dropdown-menu {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-lg);
        }

        .dropdown-item {
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--color-light);
            transform: translateX(5px);
        }

        /* Enhanced Sidebar Styles */
        #sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        /* Main content area with sidebar offset */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Mobile sidebar toggle */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Sidebar toggle button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 1px;
            z-index: 1001;
            align-items: center;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            box-shadow: var(--box-shadow);
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
        }

        /* Modern Header Styles */
        .modern-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .header-content {
            min-height: 70px;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 4px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background-color: #f8f9fa;
        }

        .hamburger-line {
            width: 24px;
            height: 2px;
            background-color: #495057;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .mobile-menu-btn.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-btn.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Page Info */
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .breadcrumb-nav {
            margin-top: 4px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            font-size: 0.875rem;
        }

        .breadcrumb-link {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-link:hover {
            color: var(--color-primary);
        }

        /* Search Container */
        .search-container {
            position: relative;
            min-width: 300px;
        }

        .search-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            color: #6c757d;
            z-index: 2;
        }

        .search-input {
            width: 100%;
            padding: 10px 12px 10px 40px;
            border: 1px solid #e9ecef;
            border-radius: 25px;
            background-color: #f8f9fa;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--color-primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(7, 65, 112, 0.1);
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        .search-result-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-no-results {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }

        /* Quick Actions */
        .quick-actions {
            gap: 8px;
        }

        .quick-action-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .quick-action-btn:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .quick-action-btn:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* Notification Container */
        .notification-container {
            position: relative;
        }

        .notification-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notification-btn:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Language Selector */
        .language-selector .dropdown-toggle::after {
            display: none;
        }

        .language-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #e9ecef;
            background: white;
            border-radius: 20px;
            color: #495057;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .language-btn:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .language-code {
            font-weight: 600;
        }

        .language-dropdown {
            min-width: 150px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .language-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .language-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .flag-icon {
            font-size: 1.2rem;
        }

        /* User Profile */
        .user-profile {
            position: relative;
        }

        .user-profile .dropdown {
            position: relative;
        }

        .user-profile .dropdown-toggle::after {
            display: none;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border: 1px solid #e9ecef;
            background: white;
            border-radius: 25px;
            color: #495057;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .profile-btn:hover {
            border-color: var(--color-primary);
            box-shadow: 0 2px 8px rgba(7, 65, 112, 0.1);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--color-primary), #0a4a6b);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex: 1;
        }

        .profile-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #212529;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 0.75rem;
            color: #6c757d;
            line-height: 1.2;
        }

        .profile-arrow {
            font-size: 0.75rem;
            color: #6c757d;
            transition: transform 0.3s ease;
        }

        .profile-btn[aria-expanded="true"] .profile-arrow {
            transform: rotate(180deg);
        }

        .profile-dropdown {
            min-width: 280px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 8px 0;
            z-index: 1050;
            position: absolute;
            top: 100%;
            right: 0;
            display: none;
        }

        .profile-dropdown.show {
            display: block !important;
        }

        /* Ensure dropdown is visible */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1;
            visibility: visible;
        }

        .profile-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
        }

        .profile-header-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-header-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }

        .profile-header-email {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .profile-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .profile-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .logout-btn {
            color: #dc3545 !important;
        }

        .logout-btn:hover {
            background-color: #f8d7da !important;
        }

        /* Modern Notifications */
        .modern-notifications {
            border: none;
            box-shadow: -4px 0 12px rgba(0,0,0,0.1);
        }

        .notifications-header {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 16px;
        }

        .notification-count {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--color-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #adb5bd;
        }

        .notification-close {
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .notification-close:hover {
            color: #dc3545;
            background-color: #f8d7da;
        }

        .no-notifications {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-notifications i {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .search-container {
                display: none !important;
            }
            
            .quick-actions {
                display: none !important;
            }
            
            .profile-btn {
                min-width: auto;
                padding: 8px;
            }
            
            .profile-info {
                display: none;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
        }

        /* Enhanced Breadcrumb Styles */
        .breadcrumb-glass {
            background: linear-gradient(135deg, var(--color-primary) 0%, #0a4a6b 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Enhanced KPI Card Styles */
        .kpi-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }

        /* Enhanced Modal Styles */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-lg);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, #0a4a6b 100%);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        /* Enhanced Alert Styles */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            border-left: 4px solid;
        }

        /* Enhanced Pagination Styles */
        .pagination .page-link {
            border-radius: var(--border-radius);
            margin: 0 2px;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* Enhanced Toggle Switch Styles */
        .form-check-input:checked {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* Enhanced Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Enhanced Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Enhanced Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .card {
                margin-bottom: 1rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Enhanced Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            :root {
                --color-light: #343a40;
                --color-dark: #ffffff;
            }
        }

        /* Enhanced Accessibility */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Enhanced Focus States */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* Modern Sidebar Enhancements */
        .hover-bg-light:hover {
            background-color: var(--color-light) !important;
            transition: all 0.2s ease;
        }

        /* Enhanced Sidebar Submenu Styles */
        .sidebar-submenu {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
        }

        .sidebar-submenu-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 2px 0;
        }

        .sidebar-submenu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-submenu-item:hover::before {
            left: 100%;
        }

        .sidebar-submenu-item:hover {
            background: linear-gradient(135deg, rgba(7, 65, 112, 0.1), rgba(10, 74, 107, 0.15));
            color: var(--color-primary) !important;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(7, 65, 112, 0.2);
        }

        .sidebar-submenu-item:hover .submenu-icon {
            color: var(--color-primary);
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        /* Enhanced submenu item states */
        .sidebar-submenu-item:active {
            transform: translateX(2px) scale(0.98);
        }

        .sidebar-submenu-item:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* Smooth transitions for all sidebar elements */
        .sidebar-submenu-item,
        .sidebar-submenu-item *,
        .sidebar-main-item,
        .sidebar-main-item * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Improved submenu container */
        .sidebar-submenu {
            background: rgba(255, 255, 255, 0.02);
            border-left: 2px solid rgba(7, 65, 112, 0.1);
            margin-left: 8px;
            border-radius: 0 8px 8px 0;
        }

        /* Submenu item spacing and alignment */
        .sidebar-submenu-item {
            position: relative;
            margin: 1px 0;
            border-radius: 6px;
        }

        .sidebar-submenu-item:first-child {
            margin-top: 4px;
        }

        .sidebar-submenu-item:last-child {
            margin-bottom: 4px;
        }

        .sidebar-submenu-item.active {
            background: linear-gradient(135deg, var(--color-primary), #0a4a6b);
            color: white !important;
            box-shadow: 0 4px 12px rgba(7, 65, 112, 0.3);
        }

        .sidebar-submenu-item.active .submenu-icon {
            color: white;
        }

        /* Submenu Animation */
        .sidebar-submenu.collapse {
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }

        .sidebar-submenu.collapse.show {
            max-height: 500px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Chevron rotation animation */
        .fas.fa-chevron-down {
            transition: transform 0.3s ease;
        }

        /* Main Menu Item Hover Effects */
        .sidebar-main-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-main-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-main-item:hover::after {
            left: 100%;
        }

        .sidebar-main-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar Scrollbar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: var(--color-primary) transparent;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #0a4a6b;
        }

        /* Sidebar collapse animation */
        .collapse {
            transition: height 0.3s ease;
        }

        /* Modern button hover effects */
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Enhanced card animations */
        .staff-fade-in {
            animation: staffFadeIn 0.6s ease-out;
        }

        @keyframes staffFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modern gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, #0a4a6b 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, var(--color-success) 0%, #0f5132 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, var(--color-warning) 0%, #664d03 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, var(--color-info) 0%, #055160 100%);
        }

        /* Enhanced stats card hover effects */
        .staff-stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0a4a6b;
        }

        /* Enhanced mobile responsiveness */
        @media (max-width: 768px) {
            .staff-stats-card {
                margin-bottom: 1rem;
            }
            
            .staff-page-title {
                font-size: 1.5rem;
            }
            
            .staff-stats-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    {{-- Sidebar Toggle Button (Mobile) --}}
    <button class="sidebar-toggle" id="sidebarToggle">
        <div class="hamburger-inner"></div>

    </button>

    {{-- Sidebar --}}
    <nav id="sidebar" >
        @include('partials.staff.menu')
    </nav>

    {{-- Main Content Area --}}
    <div class="main-content">
        {{-- Header --}}
        @if (!isset($header) || $header != false)
            @include('staff.layouts.header')
        @endif

        {{-- Main Content Container --}}
        <main class="flex-grow-1 p-4">
            {{-- Breadcrumb is now handled in the header --}}

            {{-- Page Title is now handled in the header --}}
            {{-- Action buttons can be added here if needed --}}
            @hasSection('action-btn')
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                                @yield('action-btn')
                        </div>
                    </div>
                </div>
            @endif

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Page Content --}}
            <div class="fade-in">
                @yield('content')
            </div>
        </main>
    </div>
    {{-- Notifications, Modals, and Toasts --}}
    <x-staff.modals.notification />
    <x-staff.modals.basic />
    <x-staff.modals.over />
    <x-staff.toast />

    {{-- Footer --}}
    @include('staff.layouts.footer')

    {{-- Validation Script --}}
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    {{-- Sidebar Toggle Script --}}


    {{-- Modern Dashboard Scripts --}}
    <script src="{{ asset('assets/bootstrap/version-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    {{-- Modern Dashboard JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                    mainContent.classList.toggle('sidebar-collapsed');
                });
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Initialize DataTables with proper Bootstrap 5 support
            if (document.querySelector('.data-table, .datatable') && typeof $.fn.DataTable !== 'undefined') {
                // Ensure Bootstrap is available for DataTables
                if (typeof bootstrap === 'undefined') {
                    console.warn('Bootstrap not available for DataTables');
                    return;
                }
                
                $('.data-table, .datatable').each(function() {
                    if (!$.fn.DataTable.isDataTable(this)) {
                        try {
                            $(this).DataTable({
                                responsive: true,
                                pageLength: 25,
                                order: [[0, 'desc']],
                                language: {
                                    search: "Search:",
                                    lengthMenu: "Show _MENU_ entries",
                                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                    paginate: {
                                        first: "First",
                                        last: "Last",
                                        next: "Next",
                                        previous: "Previous"
                                    }
                                }
                            });
                        } catch (error) {
                            console.error('DataTables initialization error:', error);
                        }
                    }
                });
            }

            // Initialize Select2
            if (document.querySelector('.select2')) {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states to forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';
                    }
                });
            });

            // Check if sidebar elements exist
            const sidebarMenu = document.getElementById('sidebarMenu');
            console.log('Sidebar menu found:', !!sidebarMenu);
            
            if (sidebarMenu) {
                const sidebarButtons = sidebarMenu.querySelectorAll('button[data-bs-target]');
                console.log('Sidebar buttons found:', sidebarButtons.length);
            }

            // Initialize charts if present
            initializeCharts();

            // Initialize sidebar interactions
            initializeSidebar();
        });

        function initializeSidebar() {
            // Simple menu toggle - just open/close
            document.querySelectorAll('#sidebarMenu button[data-bs-target]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const target = document.querySelector(this.getAttribute('data-bs-target'));
                    const chevron = this.querySelector('.fas.fa-chevron-down');
                    
                    if (target.classList.contains('show')) {
                        // Close menu
                        target.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                        chevron.style.transform = 'rotate(0deg)';
                    } else {
                        // Open menu
                        target.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        chevron.style.transform = 'rotate(180deg)';
                    }
                });
            });
        }

        function setActiveSubmenuItem() {
            const currentPath = window.location.pathname;
            const submenuItems = document.querySelectorAll('.sidebar-submenu-item');
            
            submenuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.split('/').pop())) {
                    item.classList.add('active');
                }
            });
        }

        function initializeCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                try {
                    // Get dynamic chart data from the server with safe defaults
                    const chartData = @json($chartData ?? []);
                    const months = Array.isArray(chartData.months) ? chartData.months : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    const revenue = Array.isArray(chartData.revenue) ? chartData.revenue : [0, 0, 0, 0, 0, 0];
                    
                    new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Revenue',
                                data: revenue,
                                borderColor: 'rgb(13, 110, 253)',
                                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.1)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Revenue chart error:', error);
                }
            }

            // Customer Distribution Chart
            const customerCtx = document.getElementById('customerChart');
            if (customerCtx) {
                try {
                    // Get dynamic customer data from the server with safe defaults
                    const customerDistribution = @json($customerDistribution ?? {});
                    const active = (customerDistribution && typeof customerDistribution.active === 'number') ? customerDistribution.active : 0;
                    const inactive = (customerDistribution && typeof customerDistribution.inactive === 'number') ? customerDistribution.inactive : 0;
                    const pending = (customerDistribution && typeof customerDistribution.pending === 'number') ? customerDistribution.pending : 0;
                    
                    new Chart(customerCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Active Customers', 'Inactive Customers', 'Pending Customers'],
                            datasets: [{
                                data: [active, inactive, pending],
                                backgroundColor: [
                                    'rgb(25, 135, 84)',
                                    'rgb(220, 53, 69)',
                                    'rgb(255, 193, 7)'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Customer chart error:', error);
                }
            }
        }

        // Utility functions
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            const toast = createToast(message, type);
            toastContainer.appendChild(toast);
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }

        function createToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            return toast;
        }
    </script>

    {{-- Scripts Page Specific --}}
    @stack('scripts-page')
</body>

</html>
