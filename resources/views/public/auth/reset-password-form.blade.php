@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])
@section('content')
    <link rel="stylesheet" href="public/assets/xoric/app.min.css">
    <div class="bg-primary bg-pattern mt-5 py-5">
        <div class="account-pages mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2">
                                    <h5 class="mb-5 text-center">{{ __('Reset Password') }}</h5>
                                    <form class="form-horizontal" action="{{ route('public.password.update', ) }}" method="POST">
                                        @csrf
                                        {{-- Hidden token --}}
                                        <input type="hidden" name="token"
                                            value="{{ $token ?? request()->route('token') }}">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-4">
                                                    <label for="email">{{ __('Email') }}</label>
                                                    <input type="email" name="email"
                                                        value="{{ old('email', $email ?? request()->email) }}" required>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-4">
                                                    <label for="password">{{ __('New Password') }}</label>
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" required>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-4">
                                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        id="password-confirm" required>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success d-block w-100 waves-effect waves-light"
                                                    type="submit">{{ __('Reset Password') }}</button>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <p class="my-4 text-center">{{ __('Back to') }} <a
                                                        href="{{ route('public.login', ) }}"
                                                        class="text-primary">{{ __('Login') }}</a></p>
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
@endsection
