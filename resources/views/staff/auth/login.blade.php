<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FERP Controller') }} - Staff Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* -----------------------
           Subtle Modern Background
        ------------------------ */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            overflow: hidden;
        }

        .background-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .background-shapes span {
            position: absolute;
            display: block;
            width: 100px;
            height: 100px;
            background: rgba(0, 123, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .background-shapes span:nth-child(1) { left: 10%; top: 20%; animation-duration: 12s; }
        .background-shapes span:nth-child(2) { left: 80%; top: 10%; animation-duration: 18s; }
        .background-shapes span:nth-child(3) { left: 50%; top: 80%; animation-duration: 20s; }
        .background-shapes span:nth-child(4) { left: 30%; top: 60%; animation-duration: 25s; }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(45deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        /* Login container */
        .staff-login-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .staff-login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            color: #333;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .staff-logo-img {
            width: 150px;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .staff-title {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #007bff;
        }

        .staff-form .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        .staff-btn-primary {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .staff-btn-primary:hover {
            background-color: #0069d9;
            box-shadow: 0 0 10px rgba(0,123,255,0.3);
        }

        .staff-footer-text {
            font-size: 0.875rem;
            text-align: center;
            color: #6c757d;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <!-- Subtle Animated Background Shapes -->
    <div class="background-shapes">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Login Form -->
    <div class="staff-login-container">
        <div class="staff-login-card">

            <!-- Logo -->
            <div class="text-center">
                <a href="{{ route('public.home') }}">
                    <img src="{{ asset('assets/images/site_logo.png') }}" alt="{{ env('APP_NAME') }} Logo" class="staff-logo-img">
                </a>
            </div>

            <!-- Title -->
            <h4 class="staff-title">{{ __('Staff Dashboard') }}</h4>

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="staff-email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" id="staff-email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ __('Enter your email') }}" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="staff-password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" id="staff-password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('Enter your password') }}" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn staff-btn-primary btn-lg">{{ __('Login') }}</button>
                </div>
            </form>

            <!-- Footer -->
            <div class="staff-footer-text">
                &copy; {{ date('Y') }} {{ env('APP_NAME') }}. {{ __('All rights reserved.') }}
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Validation Script -->
    <script>
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    })();
    </script>

</body>
</html>
