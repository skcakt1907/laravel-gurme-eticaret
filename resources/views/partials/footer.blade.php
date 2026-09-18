<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="brand">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ setting('site_adi') }}">
                </div>
                <p>{{ tsetting('site_aciklama') }}</p>
                <div class="social">
                    <a href="{{ setting('instagram', '#') }}" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="{{ setting('facebook', '#') }}" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>{{ __('Shop') }}</h5>
                @foreach($navCategories as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>{{ __('Company') }}</h5>
                <a href="{{ route('about') }}">{{ __('About') }}</a>
                <a href="{{ route('services') }}">{{ __('Why AEGEA') }}</a>
                <a href="{{ route('blog') }}">{{ __('Journal') }}</a>
                <a href="{{ route('contact') }}">{{ __('Contact') }}</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>{{ __('Contact') }}</h5>
                <div class="contact-li"><i class="bi bi-geo-alt"></i><span>{{ setting('adres') }}</span></div>
                <div class="contact-li"><i class="bi bi-telephone"></i><a href="tel:{{ setting('telefon') }}">{{ setting('telefon') }}</a></div>
                <div class="contact-li"><i class="bi bi-envelope"></i><a href="mailto:{{ setting('eposta') }}">{{ setting('eposta') }}</a></div>
            </div>
        </div>
        <div class="footer-legal" style="border-top:1px solid rgba(255,255,255,.12);padding-top:16px;margin-top:8px;display:flex;flex-wrap:wrap;gap:8px 18px;font-size:.82rem">
            <a href="{{ route('legal', 'distance-sales-agreement') }}">{{ __('Distance Sales Agreement') }}</a>
            <a href="{{ route('legal', 'pre-information') }}">{{ __('Pre-Information Form') }}</a>
            <a href="{{ route('legal', 'returns-delivery') }}">{{ __('Returns & Delivery') }}</a>
            <a href="{{ route('legal', 'data-protection') }}">{{ __('Data Protection') }}</a>
            <a href="{{ route('legal', 'privacy-policy') }}">{{ __('Privacy Policy') }}</a>
            <a href="{{ route('legal', 'cookie-policy') }}">{{ __('Cookie Policy') }}</a>
        </div>
        @if(setting('firma_unvan'))
        <div class="footer-legal" style="border-top:1px solid rgba(201,162,74,.14);padding-top:14px;margin-top:6px;font-size:.78rem;color:var(--gray);line-height:1.7">
            <strong style="color:var(--body)">{{ __('Seller:') }}</strong> {{ setting('firma_unvan') }}<br>
            {{ setting('adres') }}
            @if(setting('ticaret_sicil_no')) · {{ __('Trade Reg. No') }}: {{ setting('ticaret_sicil_no') }}@endif
            @if(setting('mersis_no')) · MERSIS: {{ setting('mersis_no') }}@endif
            @if(setting('vergi_dairesi')) · {{ __('Tax Office:') }} {{ setting('vergi_dairesi') }} — {{ setting('vergi_no') }}@endif
            @if(setting('kep')) · KEP: {{ setting('kep') }}@endif
        </div>
        @endif
        <div class="footer-bottom">
            © {{ date('Y') }} {{ setting('site_adi') }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
