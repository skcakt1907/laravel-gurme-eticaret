@extends('layouts.app')
@section('title', 'My Cart — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('My Cart') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Cart') }}</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        @if(empty($items))
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h3>{{ __('Your cart is empty') }}</h3>
                <p>{{ __('You haven\'t added any products yet.') }}</p>
                <a href="{{ route('shop') }}" class="btn btn-orange">{{ __('Start Shopping') }}</a>
            </div>
        @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="side-card" style="padding:1rem 1.5rem">
                        <table class="cart-table">
                            <thead><tr><th>{{ __('Product') }}</th><th>{{ __('Price') }}</th><th>{{ __('Qty') }}</th><th>{{ __('Total') }}</th><th></th></tr></thead>
                            <tbody>
                            @foreach($items as $it)
                                <tr>
                                    <td>
                                        <div class="cart-prod">
                                            <img src="{{ $it['image'] }}" alt="">
                                            <div>
                                                <strong><a href="{{ route('product', $it['slug']) }}" style="color:var(--ink)">{{ $it['name'] }}</a></strong>
                                                <small>{{ $it['sku'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ money($it['price']) }}</td>
                                    <td>
                                        <div class="qty-box">
                                            <button type="button" class="qminus">−</button>
                                            <input type="number" name="qty[{{ $it['id'] }}]" value="{{ $it['qty'] }}" min="1" onchange="this.form.submit()">
                                            <button type="button" class="qplus">+</button>
                                        </div>
                                    </td>
                                    <td><strong>{{ money($it['price'] * $it['qty']) }}</strong></td>
                                    <td>
                                        <button type="submit" formaction="{{ route('cart.remove', $it['id']) }}" class="cart-remove" title="{{ __('Remove') }}"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('shop') }}" class="btn btn-line"><i class="bi bi-arrow-left me-2"></i> {{ __('Continue Shopping') }}</a>
                        <button type="submit" class="btn btn-line"><i class="bi bi-arrow-repeat me-2"></i> {{ __('Update Cart') }}</button>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4>{{ __('Order Summary') }}</h4>
                        <div class="summary-row"><span>{{ __('Subtotal') }}</span><span>{{ money($subtotal) }}</span></div>
                        <div class="summary-row"><span>{{ __('Shipping') }}</span><span>{{ $shipping > 0 ? money($shipping) : __('Free') }}</span></div>
                        <div class="summary-row total"><span>{{ __('Total') }}</span><span>{{ money($total) }}</span></div>
                        <a href="{{ route('checkout') }}" class="btn btn-orange">{{ __('Checkout') }} <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</section>
@endsection
