@extends('layouts.app')
@section('title', 'Sign In — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:radial-gradient(ellipse at 50% 0%,#191207,var(--dark) 70%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">{{ __('Welcome Back') }}</h2>
                        <p style="color:var(--gray)">{{ __('Sign in to your account') }}</p>
                    </div>
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('login') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="mb-3"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <div class="mb-3"><label class="form-label">{{ __('Password') }}</label><input type="password" name="password" class="form-control" required></div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check mb-0"><input type="checkbox" name="remember" class="form-check-input" id="rmb"><label class="form-check-label" for="rmb" style="font-size:.9rem">{{ __('Remember me') }}</label></div>
                            <a href="{{ route('password.request') }}" style="font-size:.85rem;color:var(--gray)">{{ __('Forgot password?') }}</a>
                        </div>
                        <button type="submit" class="btn btn-orange w-100">{{ __('Sign In') }}</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem">{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600">{{ __('Sign Up') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
