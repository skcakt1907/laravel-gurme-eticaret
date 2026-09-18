@extends('layouts.app')
@section('title', 'Checkout — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('Checkout') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">{{ __('Cart') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Checkout') }}</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="checkout-section">
                        <h4><span class="step">1</span> {{ __('Delivery Details') }}</h4>
                        <div class="row g-3 contact-form">
                            @php $u = auth()->user(); @endphp
                            <div class="col-md-6"><label class="form-label">{{ __('Full Name') }} *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $u->name ?? '') }}"></div>
                            <div class="col-md-6"><label class="form-label">{{ __('Phone') }} *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone', $u->phone ?? '') }}"></div>
                            <div class="col-md-6"><label class="form-label">{{ __('Email') }} *</label><input type="email" name="email" class="form-control" required value="{{ old('email', $u->email ?? '') }}"></div>
                            <div class="col-md-3"><label class="form-label">{{ __('City') }} *</label><input type="text" name="city" class="form-control" required value="{{ old('city') }}"></div>
                            <div class="col-md-3"><label class="form-label">{{ __('District / State') }}</label><input type="text" name="district" class="form-control" value="{{ old('district') }}"></div>
                            <div class="col-12"><label class="form-label">{{ __('Address') }} *</label><textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea></div>
                            <div class="col-12"><label class="form-label">{{ __('Order Note') }}</label><textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea></div>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h4><span class="step">2</span> {{ __('Payment Method') }}</h4>

                        <label class="pay-opt active">
                            <input type="radio" name="payment_method" value="havale" checked>
                            <i class="bi bi-bank ic"></i>
                            <div><strong>{{ __('Bank Transfer') }}</strong><small>{{ __('IBAN details are shown after you place the order.') }}</small></div>
                        </label>

                        @if(setting('iyzico_aktif') == '1')
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="iyzico">
                            <i class="bi bi-credit-card ic"></i>
                            <div><strong>{{ __('Credit / Debit Card') }}</strong><small>{{ __('Secure 3D Secure payment (iyzico).') }}</small></div>
                        </label>
                        @endif

                        @if(setting('kapida_aktif') == '1')
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="kapida">
                            <i class="bi bi-cash-coin ic"></i>
                            <div><strong>{{ __('Cash on Delivery') }}</strong><small>{{ __('Pay by cash/card when your order arrives.') }}</small></div>
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4>{{ __('Order Summary') }}</h4>
                        @foreach($items as $it)
                            <div class="summary-row"><span>{{ $it['name'] }} × {{ $it['qty'] }}</span><span>{{ money($it['price'] * $it['qty']) }}</span></div>
                        @endforeach
                        <hr style="border-color:var(--line)">
                        <div class="summary-row"><span>{{ __('Subtotal') }}</span><span>{{ money($subtotal) }}</span></div>
                        <div class="summary-row"><span>{{ __('Shipping') }}</span><span>{{ $shipping > 0 ? money($shipping) : __('Free') }}</span></div>
                        <div class="summary-row total"><span>{{ __('Total') }}</span><span>{{ money($total) }}</span></div>
                        <div class="form-check my-3" style="font-size:.85rem">
                            <input type="checkbox" name="sozlesme" value="1" class="form-check-input" id="sozlesme" {{ old('sozlesme') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="sozlesme">
                                I have read and accept the
                                <a href="{{ route('legal', 'pre-information') }}" target="_blank">{{ __('Pre-Information Form') }}</a> and the
                                <a href="{{ route('legal', 'distance-sales-agreement') }}" target="_blank">{{ __('Distance Sales Agreement') }}</a>.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-orange">{{ __('Place Order') }} <i class="bi bi-check2 ms-2"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.pay-opt input').forEach(r => r.addEventListener('change', () => {
    document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('active'));
    r.closest('.pay-opt').classList.add('active');
}));
</script>
@endpush
@endsection
