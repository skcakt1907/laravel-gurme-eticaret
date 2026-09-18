@extends('layouts.app')
@section('title', 'Contact — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('Contact Us') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Contact') }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-geo-alt"></i><h5>{{ __('Address') }}</h5><p>{{ setting('adres') }}</p></div></div>
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-telephone"></i><h5>{{ __('Phone') }}</h5><p><a href="tel:{{ setting('telefon') }}">{{ setting('telefon') }}</a></p></div></div>
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-envelope"></i><h5>{{ __('Email') }}</h5><p><a href="mailto:{{ setting('eposta') }}">{{ setting('eposta') }}</a></p></div></div>
        </div>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-head"><span class="mini">{{ __('Wholesale & Trade') }}</span><h2>{!! __('Restaurant &amp; Trade <span>Order Request</span>') !!}</h2></div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('appointment') }}" method="POST" class="contact-form">
                    @csrf
                    @include('partials.antispam')
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Full Name') }} *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Phone') }} *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Requested Delivery Date') }}</label><input type="date" name="date" class="form-control" value="{{ old('date') }}"></div>
                        <div class="col-12"><label class="form-label">{{ __('Your Request (product / quantity / notes)') }}</label><textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea></div>
                        <div class="col-12"><button type="submit" class="btn btn-orange">{{ __('Send Request') }} <i class="bi bi-arrow-right ms-2"></i></button></div>
                    </div>
                </form>

                <div class="section-head mt-5"><span class="mini">{{ __('Contact') }}</span><h2>{!! __('Write to <span>Us</span>') !!}</h2></div>
                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                    @csrf
                    @include('partials.antispam')
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Full Name') }} *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Phone') }}</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Subject') }}</label><input type="text" name="subject" class="form-control" value="{{ old('subject') }}"></div>
                        <div class="col-12"><label class="form-label">{{ __('Your Message') }} *</label><textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea></div>
                        <div class="col-12"><button type="submit" class="btn btn-line">{{ __('Send Message') }} <i class="bi bi-send ms-2"></i></button></div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="quote-call">
                    <div class="quote-call-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div><small>{{ __('Call Us Now') }}</small><a href="tel:{{ setting('telefon') }}">{{ setting('telefon') }}</a></div>
                </div>
                <ul class="quote-perks">
                    <li><i class="bi bi-flower1"></i><div><strong>{{ __('Additive-Free & Natural') }}</strong><span>{{ __('No preservatives') }}</span></div></li>
                    <li><i class="bi bi-award"></i><div><strong>{{ __('Heritage Quality') }}</strong><span>{{ __('Traditional method') }}</span></div></li>
                    <li><i class="bi bi-box-seam"></i><div><strong>{{ __('Careful Packaging') }}</strong><span>{{ __('Cold chain & fresh dispatch') }}</span></div></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
