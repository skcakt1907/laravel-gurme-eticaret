@extends('layouts.app')
@section('title', $product->name . ' — ' . setting('site_adi'))
@section('meta', $product->short_desc)

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('Shop') }}</a></li>
            @if($product->category)<li class="breadcrumb-item"><a href="{{ route('shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>@endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                @php
                    // Galeri: images[] + cover birleşimi, tekrarsız.
                    $__gorseller = collect($product->images ?: [])
                        ->map(fn ($g) => \Illuminate\Support\Str::startsWith($g, ['http://', 'https://']) ? $g : asset($g))
                        ->prepend($product->image_url)
                        ->unique()
                        ->values();
                @endphp

                <div class="pd-gallery">
                    <img id="pdMain" src="{{ $__gorseller->first() }}" alt="{{ $product->name }}">
                </div>

                @if($__gorseller->count() > 1)
                    <div class="pd-thumbs">
                        @foreach($__gorseller as $i => $g)
                            <button type="button" class="pd-thumb {{ $i === 0 ? 'on' : '' }}" data-src="{{ $g }}">
                                <img src="{{ $g }}" alt="{{ $product->name }} {{ $i + 1 }}" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="pd-brand">{{ $product->brand ?: $product->category?->name }}</div>
                <h1 class="pd-title">{{ $product->name }}</h1>

                @if(fiyat_goster())
                <div class="pd-price">
                    <span class="now">{{ money($product->current_price) }}</span>
                    @if($product->on_sale)
                        <span class="old">{{ money($product->price) }}</span>
                        <span class="save">{{ round((1 - $product->current_price / $product->price) * 100) }}% off</span>
                    @endif
                </div>
                @else
                <div class="pd-price"><span class="ask">{{ __('Contact us for pricing') }}</span></div>
                @endif

                @if($product->in_stock)
                    <div class="pd-stock in"><i class="bi bi-check-circle-fill"></i> {{ __('In stock') }} — {{ __('ready to ship') }}</div>
                @else
                    <div class="pd-stock out"><i class="bi bi-x-circle-fill"></i> {{ __('Out of stock') }}</div>
                @endif

                <p>{{ $product->short_desc }}</p>

                @if($product->attributes)
                <ul class="pd-attrs">
                    @foreach($product->attributes as $key => $val)
                        <li><span>{{ ucfirst(str_replace('_',' ',$key)) }}</span><span>{{ $val }}</span></li>
                    @endforeach
                </ul>
                @endif

                @if(fiyat_goster())
                    @if($product->in_stock)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="pd-actions">
                        @csrf
                        <div class="qty-box">
                            <button type="button" class="qminus">−</button>
                            <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" class="qplus">+</button>
                        </div>
                        <button type="submit" class="btn btn-orange"><i class="bi bi-bag-plus me-2"></i> {{ __('Add to Cart') }}</button>
                    </form>
                    @else
                        <a href="{{ route('contact') }}" class="btn btn-line">{{ __('Ask about availability') }}</a>
                    @endif
                @else
                    <div class="pd-actions">
                        <a href="{{ route('contact') }}?product={{ $product->slug }}" class="btn btn-orange"><i class="bi bi-envelope me-2"></i> {{ __('Request Quote') }}</a>
                        <a href="https://wa.me/{{ setting('whatsapp') }}?text={{ urlencode('I\'d like a price for '.$product->name.'.') }}" target="_blank" class="btn btn-line"><i class="bi bi-whatsapp me-2"></i> WhatsApp</a>
                    </div>
                @endif

                <div class="alert-soft mt-4">
                    <i class="bi bi-info-circle me-1"></i> {{ __('Fresh and fragile items ship with cold chain and special packaging.') }}
                    @if(fiyat_goster()) {{ __('The shipping cost is shown in your cart.') }} @else {{ __('Contact us for wholesale and trade orders.') }} @endif
                </div>
            </div>
        </div>

        {{-- Açıklama --}}
        <div class="row mt-5">
            <div class="col-lg-8">
                <h3 class="mb-3">{{ __('Product Description') }}</h3>
                <div style="color:var(--body)">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>

        {{-- Benzer ürünler --}}
        @if($related->count())
        <div class="mt-5 pt-4">
            <div class="section-head"><span class="mini">{{ __('Related Products') }}</span><h2>{!! __('You Might Also <span>Like</span>') !!}</h2></div>
            <div class="row g-4">
                @foreach($related as $product)
                    <div class="col-lg-3 col-md-6">@include('partials.product-card')</div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    var ana = document.getElementById('pdMain');
    var kucukler = document.querySelectorAll('.pd-thumb');
    if (!ana || !kucukler.length) return;

    kucukler.forEach(function (t) {
        t.addEventListener('click', function () {
            var src = t.dataset.src;
            if (!src || ana.getAttribute('src') === src) return;

            ana.style.opacity = 0;
            var yeni = new Image();
            yeni.onload = function () {
                ana.src = src;
                ana.style.opacity = 1;
            };
            yeni.src = src;

            kucukler.forEach(function (d) { d.classList.remove('on'); });
            t.classList.add('on');
        });
    });
})();
</script>
@endpush
