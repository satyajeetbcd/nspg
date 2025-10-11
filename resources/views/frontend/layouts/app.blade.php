<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'NSPG - Nirmala Solar Power Generation')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/new-1.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/solar-theme.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-orange:rgb(119, 40, 11);
            --primary-blue: #1E3A8A;
            --secondary-blue: #3B82F6;
            --accent-yellow: #FBBF24;
            --text-dark: #1F2937;
            --text-light: #6B7280;
            --bg-light: #F9FAFB;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
            min-height: 60px;
        }
        
        /* Mobile navbar adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.25rem 0;
                min-height: 50px;
            }
            
            .navbar-toggler {
                display: block !important;
                border: 2px solid rgba(255, 255, 255, 0.5);
                background: rgba(255, 255, 255, 0.15);
                padding: 6px 10px;
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            }
            
            .navbar-collapse {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
                margin-top: 15px;
                padding: 25px 20px;
                border-radius: 20px;
                backdrop-filter: blur(15px);
                border: 2px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                position: relative;
                overflow: hidden;
            }
            
            .navbar-collapse::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                pointer-events: none;
                z-index: 1;
            }
            
            .navbar-nav {
                text-align: center;
                position: relative;
                z-index: 2;
            }
            
            .nav-item {
                margin: 12px 0;
            }
            
            .nav-link {
                padding: 15px 25px !important;
                border-radius: 12px;
                transition: all 0.3s ease;
                font-size: 1.1rem;
                font-weight: 600;
                color: #1f2937 !important;
                text-decoration: none;
                display: block;
                position: relative;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.7);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .nav-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
                transition: left 0.5s ease;
            }
            
            .nav-link:hover::before {
                left: 100%;
            }
            
            .nav-link:hover {
                background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(247, 147, 30, 0.1));
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(255, 107, 53, 0.2);
                color: #ff6b35 !important;
                border-color: rgba(255, 107, 53, 0.2);
            }
            
            .nav-link.btn {
                margin: 20px 0 !important;
                display: block;
                width: 100%;
                padding: 18px 25px !important;
                font-size: 1.2rem;
                font-weight: 600;
                border-radius: 15px;
                background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
                border: none !important;
                box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
                transition: all 0.3s ease;
                position: relative;
                z-index: 2;
            }
            
            .nav-link.btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 35px rgba(255, 107, 53, 0.4);
                background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
                color: white !important;
            }
        }
        
        @media (max-width: 576px) {
            .navbar {
                padding: 0.2rem 0;
                min-height: 45px;
            }
            
            .navbar-toggler {
                display: block !important;
                border: 2px solid rgba(255, 255, 255, 0.6);
                background: rgba(255, 255, 255, 0.2);
                padding: 5px 8px;
                font-size: 0.9rem;
            }
            
            .navbar-toggler-icon {
                width: 20px;
                height: 20px;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
            
            .navbar-collapse {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
                margin-top: 10px;
                padding: 20px 15px;
                border-radius: 18px;
                backdrop-filter: blur(15px);
                border: 2px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                position: relative;
                overflow: hidden;
            }
            
            .navbar-collapse::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.05"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                pointer-events: none;
                z-index: 1;
            }
            
            .nav-link {
                padding: 12px 20px !important;
                font-size: 1rem;
                font-weight: 600;
                color: #1f2937 !important;
                border-radius: 10px;
                transition: all 0.3s ease;
                position: relative;
                z-index: 2;
                background: rgba(255, 255, 255, 0.7);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .nav-link:hover {
                background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(247, 147, 30, 0.1));
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 107, 53, 0.2);
                color: #ff6b35 !important;
                border-color: rgba(255, 107, 53, 0.2);
            }
            
            .nav-link.btn {
                padding: 15px 20px !important;
                font-size: 1.1rem;
                font-weight: 600;
                background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
                border: none !important;
                box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
                border-radius: 12px;
                margin: 15px 0 !important;
            }
            
            .nav-link.btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
                background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
                color: white !important;
            }
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: white !important;
        }
        
        /* Mobile Menu Toggle Button */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.8) !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            transition: all 0.3s ease !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 1051 !important;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 24px;
            height: 24px;
        }
        
        /* Ensure mobile menu button is always visible on mobile */
        @media (max-width: 991.98px) {
            .navbar-toggler {
                display: block !important;
                z-index: 1050;
                position: relative;
            }
        }
        
        @media (min-width: 992px) {
            .navbar-toggler {
                display: none !important;
            }
        }
        
        /* Force mobile menu button visibility */
        .navbar-toggler {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure mobile menu icon is dark colored */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }
        
        @media (min-width: 992px) {
            .navbar-toggler {
                display: none !important;
            }
        }
        
        .navbar-brand img {
            max-height: 100px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand img:hover {
            transform: scale(1.05);
        }
        
        .brand-text {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        /* Responsive logo sizing */
        @media (max-width: 768px) {
            .navbar-brand {
                justify-content: flex-start;
                width: auto;
                margin: 0;
            }
            
            .navbar-brand img {
                max-height: 100px;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand {
                justify-content: flex-start;
                width: auto;
                margin: 0;
            }
            
            .navbar-brand img {
                max-height: 100px;
            }
        }
        
        /* Orange Button Styles - Default Colors */
        .btn {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-dark {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        .btn-light {
            background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
            color: white !important;
            border: 2px solid #ff6b35 !important;
        }
        
        /* Button Hover Effects */
        .btn:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            border-color: #f7931e !important;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-dark:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }
        
        .btn-light:hover {
            background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
            color: white !important;
            border-color: #f7931e !important;
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 100px;
            right: 20px;
            background-color: #25d366;
            color: white;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            z-index: 10000;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            background-color: #128c7e;
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
            color: white;
            text-decoration: none;
        }
        
        .whatsapp-float i {
            font-size: 30px;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        /* Responsive WhatsApp button */
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 55px;
                height: 55px;
                bottom: 90px;
                right: 15px;
                font-size: 25px;
            }
            
            .whatsapp-float i {
                font-size: 25px;
            }
        }
        
        @media (max-width: 576px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 85px;
                right: 10px;
                font-size: 22px;
            }
            
            .whatsapp-float i {
                font-size: 22px;
            }
        }
        
        .nav-link {
            color: white !important;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.6rem 1rem !important;
            font-size: 0.95rem;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            color: var(--accent-yellow) !important;
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Navigation spacing for longer menu */
        .navbar-nav {
            gap: 0.25rem;
        }
        
        @media (min-width: 992px) {
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem !important;
            }
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1110-27.13,1200,52.47V0Z"></path></svg>') repeat-x;
            background-size: 1000px 100px;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-primary-custom {
            background: var(--primary-orange);
            border: none;
            padding: 15px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-primary-custom:hover {
            background: #E55A2B;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-dark);
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #FF8A65 100%);
            color: white;
            border: none;
            padding: 20px;
            text-align: center;
        }
        
        .card-title-custom {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-yellow) 0%, #F59E0B 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }
        
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-section {
            height: 100%;
        }
        
        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--accent-yellow);
            position: relative;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-yellow), #f59e0b);
            border-radius: 2px;
        }
        
        .footer-link {
            color: #D1D5DB;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            padding: 8px 0;
            font-size: 0.95rem;
        }
        
        .footer-link:hover {
            color: var(--accent-yellow);
            transform: translateX(5px);
        }
        
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .footer-contact-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .contact-icon-wrapper {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent-yellow), #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }
        
        .contact-icon-wrapper i {
            color: white;
            font-size: 1.2rem;
        }
        
        .contact-details {
            flex: 1;
        }
        
        .contact-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }
        
        .contact-text {
            color: #D1D5DB;
            margin: 0;
            line-height: 1.5;
            font-size: 0.95rem;
        }
        
        .footer-links-grid {
            display: flex;
            flex-direction: column;
        }
        
        .footer-links-column {
            flex: 1;
        }
        
        .footer-links-column ul {
            margin: 0;
        }
        
        .footer-links-column li {
            margin-bottom: 5px;
        }
        
        /* Footer Responsive Design */
        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
            }
            
            .footer-contact-item {
                padding: 15px;
                gap: 12px;
            }
            
            .contact-icon-wrapper {
                width: 45px;
                height: 45px;
            }
            
            .contact-icon-wrapper i {
                font-size: 1rem;
            }
            
            .contact-title {
                font-size: 1rem;
            }
            
            .contact-text {
                font-size: 0.9rem;
            }
            
            .footer-title {
                font-size: 1.3rem;
                margin-bottom: 20px;
            }
            
            .footer-link {
                font-size: 0.9rem;
                padding: 6px 0;
            }
        }
        
        @media (max-width: 576px) {
            .footer-contact-item {
                padding: 12px;
                gap: 10px;
            }
            
            .contact-icon-wrapper {
                width: 40px;
                height: 40px;
            }
            
            .contact-icon-wrapper i {
                font-size: 0.9rem;
            }
            
            .footer-title {
                font-size: 1.2rem;
            }
        }
        
        .banner-slider {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }
        
        .banner-slide {
            position: relative;
            height: 500px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .banner-content {
            text-align: center;
            color: white;
            z-index: 2;
            position: relative;
        }
        
        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1;
        }
        
        .solar-system-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .solar-system-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-orange);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .system-capacity {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }
        
        .system-specs {
            list-style: none;
            padding: 0;
        }
        
        .system-specs li {
            padding: 8px 0;
            border-bottom: 1px solid #E5E7EB;
            color: var(--text-light);
        }
        
        .system-specs li:last-child {
            border-bottom: none;
        }
        
        .spec-label {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .spec-value {
            color: var(--primary-orange);
            font-weight: 700;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .hero-section {
                padding: 60px 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <!-- <div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="top-bar-info">
                    <span class="me-4"><i class="fas fa-phone me-1"></i> +91 931 948 3455</span>
                    <span><i class="fas fa-envelope me-1"></i> infonspg.in@gmail.com</span>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="top-bar-social">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div> -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="/images/new-1.png" alt="NSPG Logo" height="100" class="me-3">
            </a>
            
            <!-- Mobile Menu Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('our-clients') }}">Our Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('calculator') }}">NSPG Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('business-and-partnership') }}">Partnership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('download') }}">Download</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item d-lg-block d-none">
                        <a class="nav-link btn btn-warning text-dark fw-bold ms-2" href="{{ route('contact') }}">
                            <i class="fas fa-phone me-1"></i>
                            Contact Now
                        </a>
                    </li>
                    <!-- Mobile Contact Button -->
                    <li class="nav-item d-lg-none mt-3">
                        <a class="nav-link btn btn-warning text-dark fw-bold w-100 text-center" href="{{ route('contact') }}">
                            <i class="fas fa-phone me-1"></i>
                            Contact Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-4 mb-4">
                    <div class="footer-section">
                        <div class="footer-contact-item mb-4">
                            <div class="contact-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="contact-title">Visit The Office</h6>
                                <p class="contact-text">N1/66R-15K, Samne Ghat, Nagwa Lanka, Varanasi, Uttar Pradesh 221005</p>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item mb-4">
                            <div class="contact-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="contact-title">Phone Inquiry</h6>
                                <p class="contact-text">9319483455</p>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item mb-4">
                            <div class="contact-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h6 class="contact-title">Send Email</h6>
                                <p class="contact-text">infonspg.in@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-4 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Quick Links</h5>
                        <div class="footer-links-grid">
                            <div class="footer-links-column">
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
                                    <li><a href="#" class="footer-link">Careers</a></li>
                                    <li><a href="#" class="footer-link">Case Studies</a></li>
                                    <li><a href="#" class="footer-link">Meet Our Team</a></li>
                                    <li><a href="#" class="footer-link">Testimonials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Our Services -->
                <div class="col-lg-4 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Our Services</h5>
                        <div class="footer-links-grid">
                            <div class="footer-links-column">
                                <ul class="list-unstyled">
                                    <li><a href="#" class="footer-link">Installation & Monitoring</a></li>
                                    <li><a href="#" class="footer-link">After Sales Service</a></li>
                                    <li><a href="#" class="footer-link">Free Replacement</a></li>
                                    <li><a href="#" class="footer-link">Warranty Claims</a></li>
                                    <li><a href="#" class="footer-link">Energy Equipments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: #374151;">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; {{ date('Y') }} NSPG. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-light mb-0">Developed by <a href="https://nextgenweb.co.in" target="_blank" class="text-light">NextGenWeb</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure mobile menu button is visible
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.style.display = 'block';
                navbarToggler.style.visibility = 'visible';
                navbarToggler.style.opacity = '1';
            }
            
            // Mobile menu toggle functionality
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navLinks = document.querySelectorAll('.nav-link');
            
            // Close mobile menu when clicking on a link
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
    
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/919319483455?text=Hello%20NSPG,%20I%20am%20interested%20in%20your%20solar%20power%20solutions.%20Please%20provide%20more%20information." 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</body>
</html>
