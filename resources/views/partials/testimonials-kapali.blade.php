{{--
    MÜŞTERİ YORUMLARI — ŞU AN KULLANILMIYOR

    Ana sayfadan çıkarıldı: yorumlar uydurma örnek metindi (isim, ünvan ve
    avatarlar dahil). Premium bir markada sahte referans, hiç referans
    olmamasından daha çok zarar verir.

    GERİ AÇMAK İÇİN:
      1. Panelden gerçek yorumları gir — gerçek isim, gerçek restoran/ünvan,
         mümkünse fotoğraf ve kişinin yayın izni.
      2. home.blade.php içinde Journal bölümünden önce şu satırı ekle:
         @include('partials.testimonials-kapali')
--}}

@if($testimonials->count())
<section class="services-grid">
    <div class="container">
        <div class="section-head center">
            <span class="mini">{{ __('The Chef\'s Table') }}</span>
            <h2>{!! __('What Gourmets <span>Say</span>') !!}</h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $r)
            <div class="col-lg-4 col-md-6">
                <div class="testi">
                    <div class="stars">{{ str_repeat('★', (int) $r->stars) }}</div>
                    <p>"{{ $r->comment }}"</p>
                    <div class="testi-user">
                        {{-- Fotoğraf yoksa baş harf rozeti. Eskiden ui-avatars.com'dan
                             çekiliyordu: sitenin tek üçüncü taraf isteğiydi ve ziyaretçinin
                             IP'si oraya gidiyordu. Ayrıca "gerçek müşteri mi" izlenimini
                             zayıflatıyordu (bkz. müşteri incelemesi, 9. madde). --}}
                        @if($r->photo)
                            <img src="{{ $r->photo }}" alt="{{ $r->name }}">
                        @else
                            <span class="testi-initials" aria-hidden="true">{{ mb_strtoupper(mb_substr(trim($r->name), 0, 1)) }}</span>
                        @endif
                        <div><h6>{{ $r->name }}</h6><span>{{ $r->title }}</span></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
