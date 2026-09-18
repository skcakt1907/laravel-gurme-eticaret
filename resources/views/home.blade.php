@extends('layouts.app')

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge"><i class="bi bi-circle-fill"></i> {{ __('Aegean Selection · Product of Turkey') }}</span>
                <h1>{!! __('The Purest Taste<br>of the <span>Aegean.</span>') !!}</h1>
                <p>{{ tsetting('site_aciklama') }}</p>
                <div class="hero-cta">
                    <a href="{{ route('shop') }}" class="btn btn-orange">{{ __('Explore Products') }} <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="#how-we-cure" class="btn btn-line">{{ __('How We Cure') }}</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual">
                    {{-- ?v=filemtime: görsel değişince tarayıcı eskisini göstermesin --}}
                    <img src="{{ asset('img/hero-visual.jpg') }}?v={{ @filemtime(public_path('img/hero-visual.jpg')) }}" alt="{{ setting('site_adi') }}">
                    <div class="hero-float">
                        <i class="bi bi-truck"></i>
                        <div><strong>{{ __('Careful Shipping') }}</strong><small>{{ __('Worldwide delivery') }}</small></div>
                    </div>
                    <div class="hero-float top">
                        <i class="bi bi-award"></i>
                        <div><strong>{{ __('Heritage Delicacy') }}</strong><small>{{ __('Traditional method') }}</small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-meta">
            <div class="row g-3">
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-water"></i><div><strong>{{ __('Wild-Caught') }}</strong><small>{{ __('From Aegean waters') }}</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-hand-index"></i><div><strong>{{ __('Hand-Cured') }}</strong><small>{{ __('Sea salt only') }}</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-brightness-high"></i><div><strong>{{ __('Sun-Dried') }}</strong><small>{{ __('Additive-free') }}</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-shield-check"></i><div><strong>{{ __('Secure Payment') }}</strong><small>3D Secure</small></div></div></div>
            </div>
        </div>
    </div>
</section>

{{-- OUR SELECTION — categories --}}
<section class="services-grid">
    <div class="container">
        <div class="section-head center">
            <span class="mini">{{ __('Our Selection') }}</span>
            <h2>{!! __('Choose Your Bottarga <span>Style</span>') !!}</h2>
            <p class="desc">{{ __('From finely grated to waxed whole — find the form that suits your palate.') }}</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $cat)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="service-card text-center" style="align-items:center">
                    <div class="icon mx-auto"><i class="bi {{ $cat->icon ?: 'bi-stars' }}"></i></div>
                    <h4 style="font-size:1.2rem">{{ $cat->name }}</h4>
                    <span class="more">{{ __('Explore') }} <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featured->count())
<section>
    <div class="container">
        <div class="section-head d-flex justify-content-between align-items-end flex-wrap">
            <div>
                <span class="mini">{{ __('Showcase') }}</span>
                <h2>{!! __('Our Finest <span>Bottarga</span>') !!}</h2>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-orange">{{ __('View All') }} <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        <div class="row g-4">
            @foreach($featured as $product)
                <div class="col-lg-3 col-md-6">@include('partials.product-card')</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- EXCLUSIVE OFFERS — 2 promo banners --}}
<section class="services-grid" style="padding-top:40px">
    <div class="container">
        <div class="section-head center">
            <span class="mini">{{ __('For Gourmets') }}</span>
            @if(fiyat_goster())
                <h2>{!! __('Special Prices on <span>Fine Bottarga</span>') !!}</h2>
            @else
                <h2>{!! __('Chefs &amp; <span>Trade Buyers</span>') !!}</h2>
            @endif
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="cta-strip" style="margin:0;max-width:none">
                    <div class="container">
                        <div style="font-family:var(--display);letter-spacing:.3em;color:var(--primary-text);font-size:.8rem;margin-bottom:.7rem">{{ fiyat_goster() ? '15% OFF' : 'WHOLESALE & EXPORT' }}</div>
                        <h3>For Chefs &amp; Fine-Food Retailers</h3>
                        <p>{{ fiyat_goster() ? __('Preferential pricing for restaurants and wholesale orders.') : __('We supply restaurants, hotels and gourmet retailers on special terms.') }}</p>
                        <a href="{{ route('contact') }}" class="btn mt-3">{{ __('Get in Touch') }} <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="cta-strip" style="margin:0;max-width:none">
                    <div class="container">
                        <div style="font-family:var(--display);letter-spacing:.3em;color:var(--primary-text);font-size:.8rem;margin-bottom:.7rem">{{ fiyat_goster() ? 'ONLINE ORDER' : 'PRICE QUOTE' }}</div>
                        @if(fiyat_goster())
                            <h3>{{ __('Order Online') }}</h3>
                            <p>{{ __('Add to cart and finish in minutes — the shipping cost is shown in your cart.') }}</p>
                            <a href="{{ route('shop') }}" class="btn mt-3">{{ __('Start Shopping') }} <i class="bi bi-arrow-right ms-2"></i></a>
                        @else
                            <h3>{{ __('Current Price List') }}</h3>
                            <p>{{ __('Tell us the product and quantity — we\'ll send our current quote the same day.') }}</p>
                            <a href="{{ route('contact') }}" class="btn mt-3">{{ __('Request Quote') }} <i class="bi bi-arrow-right ms-2"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HOW WE CURE --}}
<section id="how-we-cure">
    <div class="container">
        <div class="section-head center">
            <span class="mini">{{ __('Artisanal Process') }}</span>
            <h2>{!! __('How We <span>Cure Our Bottarga</span>') !!}</h2>
            <p class="desc">{{ __('Discover the traditional process behind authentic Aegean bottarga.') }}</p>
        </div>
        <div class="row g-4">
            @foreach($services as $h)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('service.show', $h) }}" class="service-card">
                    <div class="icon"><i class="bi {{ $h->icon }}"></i></div>
                    <h4>{{ $h->title }}</h4>
                    <p>{{ $h->summary }}</p>
                    <span class="more">{{ __('Details') }} <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Müşteri yorumları bölümü kaldırıldı (uydurma referanslardı).
     Markup duruyor: resources/views/partials/testimonials-kapali.blade.php
     Gerçek yorumlar girilince oradaki not tarif ediyor. --}}

{{-- JOURNAL --}}
@if($posts->count())
<section>
    <div class="container">
        <div class="section-head center">
            <span class="mini">{{ __('Journal') }}</span>
            <h2>{!! __('Kitchen &amp; <span>Flavour Guide</span>') !!}</h2>
        </div>
        <div class="row g-4">
            @foreach($posts as $b)
            <div class="col-lg-4 col-md-6">
                <div class="blog-card">
                    <div class="img">
                        <img src="{{ $b->image_url }}" alt="">
                        <span class="cat">{{ $b->category }}</span>
                    </div>
                    <div class="blog-body">
                        <div class="meta"><i class="bi bi-calendar3"></i>{{ optional($b->tarih)->format('d M Y') }}</div>
                        <h5><a href="{{ route('blog.show', $b) }}">{{ $b->title }}</a></h5>
                        <p>{{ $b->summary }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
