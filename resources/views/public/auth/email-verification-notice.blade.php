@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])
@section('content')
    <div class="bg-primary bg-pattern mt-5 py-5">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card">
                        <div class="card-body p-4 text-center">
                            <h5 class="mb-3">{{ __('Email Verification Required') }}</h5>
                            <p class="mb-4">{{ __('Thank you for registering! Please check your email and click on the verification link to activate your account.') }}</p>

                            {{-- Display error messages --}}
                            @if (session('failed'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session('failed') }}</strong>
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

                            <form method="POST" action="{{ route('public.verification.resend') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $customer->email }}">
                                <button type="submit" class="btn btn-primary">{{ __('Resend Verification Email') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
