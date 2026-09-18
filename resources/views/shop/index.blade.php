@extends('layouts.app')
@section('title', ($activeCat->name ?? __('Shop')) . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $activeCat->name ?? __('All Products') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('Shop') }}</a></li>
            @if($activeCat)<li class="breadcrumb-item active">{{ $activeCat->name }}</li>@endif
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-4">
            {{-- Side filter --}}
            <div class="col-lg-3">
                <div class="shop-filter">
                    <h5>{{ __('Categories') }}</h5>
                    <ul class="f-list">
                        <li><a href="{{ route('shop') }}" class="{{ !$activeCat ? 'active' : '' }}">{{ __('All') }}</a></li>
                        @foreach($categories as $cat)
                            <li><a href="{{ route('shop', ['category' => $cat->slug]) }}" class="{{ $activeCat?->id === $cat->id ? 'active' : '' }}">
                                {{ $cat->name }} <span>{{ $cat->products_count }}</span>
                            </a></li>
                        @endforeach
                    </ul>

                    <h5>{{ __('Search') }}</h5>
                    <form action="{{ route('shop') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('Search products...') }}" style="border-radius:100px 0 0 100px;border:1px solid var(--line)">
                            <button class="btn btn-orange" style="border-radius:0 100px 100px 0"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Ürün listesi --}}
            <div class="col-lg-9">
                <div class="shop-toolbar">
                    <span class="count">{{ $products->total() }} {{ __('products found') }}</span>
                    <form method="GET" id="sortForm">
                        @foreach(request()->except('sort','page') as $k => $v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                        <select name="sort" onchange="document.getElementById('sortForm').submit()">
                            <option value="">{{ __('Recommended') }}</option>
                            <option value="newest" @selected(request('sort')=='newest')>{{ __('Newest') }}</option>
                            <option value="price-asc" @selected(request('sort')=='price-asc')>{{ __('Price (Low to High)') }}</option>
                            <option value="price-desc" @selected(request('sort')=='price-desc')>{{ __('Price (High to Low)') }}</option>
                        </select>
                    </form>
                </div>

                @if($products->count())
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">@include('partials.product-card')</div>
                        @endforeach
                    </div>
                    <div class="mt-5">{{ $products->links() }}</div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-search"></i>
                        <h3>{{ __('No products found') }}</h3>
                        <p>{{ __('No products match your search.') }}</p>
                        <a href="{{ route('shop') }}" class="btn btn-orange">{{ __('All Products') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
