@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])

@section('content')
{{-- CSS is already included in the master layout --}}
<div class="bg-primary bg-pattern mt-5 py-5" >
    <div class="account-pages mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="p-2">
                                <h5 class="mb-5 text-center">{{ __('Sign in to continue') }}</h5>

                                {{-- Display error messages --}}
                                @if (session('failed'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ session('failed') }}</strong>
                                        @if (session('unactivated_email'))
                                            <div class="mt-2">
                                                <form method="POST" action="{{ route('public.verification.resend') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{ session('unactivated_email') }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="mdi mdi-email"></i> Resend Activation Email
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Display success messages --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Display status messages --}}
                                @if (session('status'))
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <strong>{{ session('status') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form class="form-horizontal" action="{{ route('public.login.submit', ['locale' => session('locale', config('locale.default', 'en-SA'))]) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="email" class="col-form-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" value="{{ session('unactivated_email') ?? old('email') }}" class="form-control" id="email" placeholder="{{ __('Enter Email') }}">
                                            @error('email')
                                                <span class="error invalid-email text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <label for="userpassword" class="col-form-label">{{ __('Password') }}</label>
                                            <input type="password" name="password" class="form-control" id="userpassword" placeholder="{{ __('Enter Password') }}">
                                            @error('password')
                                                <span class="error invalid-password text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="mt-2">
                                                <a href="{{ route('public.password.request', ['locale' => session('locale', config('locale.default', 'en-SA'))]) }}" class="text-muted"><i class="mdi mdi-lock"></i>{{ __('Forgot your password?') }}</a>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success d-block w-100 waves-effect waves-light"
                                                    type="submit">{{ __('Log In') }}</button>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <a href="{{ route('public.register', ['locale' => session('locale', config('locale.default', 'en-SA'))]) }}" class="text-muted"><i class="mdi mdi-account-circle me-1"></i>{{ __('Create an account') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
         const email = $('#email');
         email.keyup(function() {
             let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
             if (!emailRegex.test(email.val())) {
                 email.addClass('is-invalid');
                 if (email.siblings('.invalid-feedback').length === 0) {
                     email.after('<div class="invalid-feedback">Please enter a valid email address.</div>');
                 }
             } else {
                 email.removeClass('is-invalid');
                 email.siblings('.invalid-feedback').remove();
             }
        });
    });
</script>
@endsection
