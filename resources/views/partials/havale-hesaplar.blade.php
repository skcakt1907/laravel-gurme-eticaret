@php
    $__hesaplar = collect(explode("\n", (string) setting('havale_hesaplar')))
        ->map(fn ($s) => array_map('trim', explode('|', $s)))
        ->filter(fn ($p) => count($p) === 3 && $p[2] !== '');
@endphp
@if($__hesaplar->isNotEmpty())
<div style="overflow-x:auto">
    <table class="cart-table" style="margin-top:.4rem">
        <thead>
            <tr><th>{{ __('Bank') }}</th><th>{{ __('Currency') }}</th><th>IBAN</th></tr>
        </thead>
        <tbody>
        @foreach($__hesaplar as $h)
            <tr>
                <td>{{ $h[0] }}</td>
                <td>{{ $h[1] }}</td>
                <td style="font-family:monospace;letter-spacing:.02em">{{ $h[2] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<p style="font-size:.85rem;color:var(--gray);margin-top:.6rem">{{ __('Account name:') }} <strong>{{ setting('havale_hesap_adi') }}</strong> — {{ __('you may pay to the account matching your currency.') }}</p>
@else
    <ul class="pd-attrs">
        <li><span>{{ __('Bank') }}</span><span>{{ setting('havale_banka') }}</span></li>
        <li><span>{{ __('Account Name') }}</span><span>{{ setting('havale_hesap_adi') }}</span></li>
        <li><span>IBAN</span><span>{{ setting('havale_iban') }}</span></li>
    </ul>
@endif
