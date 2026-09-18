@extends('layouts.app')
@section('title', 'About — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('About Us') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('About') }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="about-img-wrap">
                    <img src="{{ asset('img/hero-visual.jpg') }}" alt="">
                    <div class="exp-badge"><span class="num">{{ setting('yil') }}+</span><span class="lbl">{{ __('Years of Experience') }}</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-head">
                    <span class="mini">{{ __('About Us') }}</span>
                    <h2>{!! __('Gold of the Sea,<br><span>Crafted by Time</span>') !!}</h2>
                    <p class="desc">{{ tsetting('site_aciklama') }}</p>
                </div>
                <ul class="about-features">
                    <li><i class="bi bi-check"></i> {{ __('Wild-Caught Aegean Grey-Mullet Roe') }}</li>
                    <li><i class="bi bi-check"></i> {{ __('Hand-Salted · Sun-Dried') }}</li>
                    <li><i class="bi bi-check"></i> {{ __('Additive- & Preservative-Free') }}</li>
                    <li><i class="bi bi-check"></i> {{ __('Cold Chain & Careful Packaging') }}</li>
                </ul>
                <a href="{{ route('shop') }}" class="btn btn-orange mt-4">{{ __('Browse Products') }} <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<section class="services-grid">
    <div class="container">
        <div class="section-head center"><span class="mini">{{ __('Why AEGEA') }}</span><h2>{!! __('What Makes Us <span>Different</span>') !!}</h2></div>
        <div class="row g-4">
            @foreach($services as $h)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('service.show', $h) }}" class="service-card">
                    <div class="icon"><i class="bi {{ $h->icon }}"></i></div>
                    <h4>{{ $h->title }}</h4>
                    <p>{{ $h->summary }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
