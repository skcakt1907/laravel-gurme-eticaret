{{-- Spam koruması: görünmez tuzak + şifreli zaman damgası + (varsa) Turnstile kutusu --}}
<div style="position:absolute;left:-9999px;top:-9999px" aria-hidden="true">
    <label>Website</label>
    <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
</div>
<input type="hidden" name="_ts" value="{{ encrypt(time()) }}">

@php $__tsKey = setting('turnstile_site_key'); @endphp
@if(filled($__tsKey))
    <div class="cf-turnstile my-3" data-sitekey="{{ $__tsKey }}" data-theme="dark" data-language="{{ app()->getLocale() }}"></div>
    @once
        @push('scripts')
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endpush
    @endonce
@endif
