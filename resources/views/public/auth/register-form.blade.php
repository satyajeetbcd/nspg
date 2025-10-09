@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])
@section('content')
    <div class="bg-primary bg-pattern mt-5 py-5">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4 text-center">{{ __('Register Account') }}</h5>

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

                            {{-- Display warning messages --}}
                            @if (session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ session('warning') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('public.register.submit', ['locale' => session('locale', config('locale.default', 'en-SA'))]) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                        autocomplete="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="new-password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Password Confirmation') }}</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        autocomplete="new-password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="term-conditionCheck" required>
                                    <label class="form-check-label" for="term-conditionCheck">
                                        {{ __('I accept') }} <a href="{{ route('public.page', ['locale' => session('locale', config('locale.default', 'en-SA')), 'slug' => 'terms']) }}"
                                            class="text-primary">{{ __('Terms and Conditions') }}</a>
                                    </label>
                                </div>
                                <button class="btn btn-success w-100" type="submit">{{ __('Register') }}</button>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('public.login', ['locale' => session('locale', config('locale.default', 'en-SA'))]) }}" class="text-muted">
                                        <i class="mdi mdi-account-circle me-1"></i>{{ __('Already have account?') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
