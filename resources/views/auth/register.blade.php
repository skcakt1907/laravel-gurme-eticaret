@extends('layouts.app')
@section('title', 'Sign Up — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:radial-gradient(ellipse at 50% 0%,#191207,var(--dark) 70%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">{{ __('Create Account') }}</h2>
                        <p style="color:var(--gray)">{{ __('Quick and easy sign-up') }}</p>
                    </div>
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('register') }}" method="POST" class="contact-form">
                        @csrf
                    @include('partials.antispam')
                        <div class="mb-3"><label class="form-label">{{ __('Full Name') }}</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="mb-3"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <div class="mb-3"><label class="form-label">{{ __('Phone') }}</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="mb-3"><label class="form-label">{{ __('Password') }}</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">{{ __('Confirm Password') }}</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <button type="submit" class="btn btn-orange w-100">{{ __('Sign Up') }}</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem">{{ __('Already have an account?') }} <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">{{ __('Sign In') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
