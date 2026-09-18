@extends('layouts.app')
@section('title', __('Verify Your Email') . ' — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:radial-gradient(ellipse at 50% 0%,#191207,var(--dark) 70%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <div style="font-size:2.4rem;color:var(--primary);line-height:1"><i class="bi bi-envelope-check"></i></div>
                        <h2 style="font-size:1.5rem;margin-top:.6rem">{{ __('Verify Your Email') }}</h2>
                        <p style="color:var(--gray);margin-bottom:0">
                            {{ __('We sent a verification link to :email. Please click it to confirm your address.', ['email' => auth()->user()->email]) }}
                        </p>
                    </div>

                    @if(session('status') === 'verification-link-sent')
                        <div class="alert alert-success">{{ __('A new verification link has been sent to your email address.') }}</div>
                    @endif

                    <p style="color:var(--gray);font-size:.9rem">
                        {{ __("Didn't receive the email? Check your spam folder, or request a new link below.") }}
                    </p>

                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-orange w-100">{{ __('Resend Verification Email') }}</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('shop') }}" style="color:var(--gray);font-size:.9rem">{{ __('Continue Shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
