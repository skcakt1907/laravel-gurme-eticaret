<div class="product-card">
    <a href="{{ route('product', $product->slug) }}" class="pc-img">
        @if(fiyat_goster() && $product->on_sale)
            <span class="pc-badge">{{ round((1 - $product->current_price / $product->price) * 100) }}% OFF</span>
        @elseif(!$product->in_stock)
            <span class="pc-badge out">{{ __('Sold Out') }}</span>
        @endif
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
    </a>
    <div class="pc-body">
        <div class="pc-brand">{{ $product->brand ?: $product->category?->name }}</div>
        <h3 class="pc-title"><a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a></h3>

        @if(fiyat_goster())
            <div class="pc-price">
                <span class="now">{{ money($product->current_price) }}</span>
                @if($product->on_sale)<span class="old">{{ money($product->price) }}</span>@endif
            </div>
            @if($product->in_stock)
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button class="pc-add" type="submit"><i class="bi bi-bag-plus"></i> {{ __('Add to Cart') }}</button>
                </form>
            @else
                <span class="pc-add disabled"><i class="bi bi-x-circle"></i> {{ __('Out of Stock') }}</span>
            @endif
        @else
            <div class="pc-price"><span class="ask">{{ __('Contact us for pricing') }}</span></div>
            <a href="{{ route('contact') }}?product={{ $product->slug }}" class="pc-add"><i class="bi bi-envelope"></i> {{ __('Request Quote') }}</a>
        @endif
    </div>
</div>
