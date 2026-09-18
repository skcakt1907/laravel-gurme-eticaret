@extends('layouts.app')
@section('title', __('Order Received') . ' — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="order-success-icon">
                    @if($order->payment_status === 'paid')
                        <i class="bi bi-check-lg"></i>
                    @else
                        <i class="bi bi-bag-check"></i>
                    @endif
                </div>
                <h1>{{ __('Your Order Is Received!') }}</h1>
                <p style="color:var(--gray);font-size:1.1rem">{{ __('Your order number:') }} <strong style="color:var(--ink)">{{ $order->order_no }}</strong></p>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                {{-- Havale bilgileri --}}
                @if($order->payment_method === 'havale' && $order->payment_status !== 'paid')
                <div class="checkout-section">
                    <h4><i class="bi bi-bank me-2"></i> {{ __('Bank Transfer Details') }}</h4>
                    <p>{!! __('Send :amount to one of the accounts below and add :ref as the payment reference. We\'ll prepare your order once payment is confirmed.', ['amount' => '<strong>'.money($order->total).'</strong>', 'ref' => '<strong>'.$order->order_no.'</strong>']) !!}</p>
                    @include('partials.havale-hesaplar')
                    <ul class="pd-attrs">
                        <li><span>{{ __('Amount') }}</span><span>{{ money($order->total) }}</span></li>
                        <li><span>{{ __('Reference') }}</span><span>{{ $order->order_no }}</span></li>
                    </ul>
                </div>
                @elseif($order->payment_method === 'kapida')
                <div class="alert-soft mb-4"><i class="bi bi-cash-coin me-1"></i> {{ __('You\'ll pay on delivery. Your order is being prepared.') }}</div>
                @elseif($order->payment_status === 'paid')
                <div class="alert-soft mb-4"><i class="bi bi-check-circle me-1"></i> {{ __('Your payment was received. We\'ve started preparing your order.') }}</div>
                @endif

                {{-- Order summary --}}
                <div class="checkout-section">
                    <h4><i class="bi bi-receipt me-2"></i> {{ __('Order Summary') }}</h4>
                    <table class="cart-table">
                        <tbody>
                        @foreach($order->items as $it)
                            <tr><td>{{ $it->name }} × {{ $it->qty }}</td><td class="text-end">{{ money($it->total) }}</td></tr>
                        @endforeach
                        <tr><td>{{ __('Shipping') }}</td><td class="text-end">{{ $order->shipping > 0 ? money($order->shipping) : __('Free') }}</td></tr>
                        <tr><td><strong>{{ __('Total') }}</strong></td><td class="text-end"><strong>{{ money($order->total) }}</strong></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-orange">{{ __('Continue Shopping') }}</a>
                    @auth<a href="{{ route('account.orders') }}" class="btn btn-line ms-2">{{ __('My Orders') }}</a>@endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
