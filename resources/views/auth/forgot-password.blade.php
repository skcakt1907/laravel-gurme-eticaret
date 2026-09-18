@extends('layouts.app')
@section('title', 'Forgot Password — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:radial-gradient(ellipse at 50% 0%,#191207,var(--dark) 70%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">{{ __('Forgot Password') }}</h2>
                        <p style="color:var(--gray)">{{ __('Enter your email and we\'ll send a reset link.') }}</p>
                    </div>
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('password.email') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="mb-3"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <button type="submit" class="btn btn-orange w-100">{{ __('Send Reset Link') }}</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem"><a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">{{ __('Back to sign in') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
