{{-- Üst şerit --}}
<div class="topbar">
    <div class="container">
        <div class="tb-left">
            <span style="color:var(--primary-text)">{{ __('FOLLOW US:') }}</span>
            <a href="{{ setting('instagram', '#') }}" target="_blank">Instagram</a>
            <a href="{{ setting('facebook', '#') }}" target="_blank">Facebook</a>
        </div>
        <div class="tb-ship">
            ✦ WILD-CAUGHT · HAND-CURED · SUN-DRIED ✦
        </div>
        <div class="tb-right">
            <a href="{{ route('about') }}">{{ __('About') }}</a>
            <a href="{{ route('contact') }}">{{ __('Contact') }}</a>
            <span class="lang-switch">
                <a href="{{ route('lang.switch', 'tr') }}" class="{{ app()->getLocale()==='tr' ? 'on' : '' }}">TR</a>
                <span style="opacity:.4">|</span>
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale()==='en' ? 'on' : '' }}">EN</a>
            </span>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="{{ setting('site_adi') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link {{ request()->routeIs('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">{{ __('Shop') }} <i class="bi bi-chevron-down" style="font-size:.6rem"></i></a>
                    <div class="dropdown-panel">
                        @foreach($navCategories as $cat)
                            <a href="{{ route('shop', ['category' => $cat->slug]) }}"><i class="bi {{ $cat->icon ?: 'bi-stars' }}"></i> {{ $cat->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('About') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">{{ __('Journal') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contact') }}</a></li>

                @auth
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link" href="{{ route('account') }}"><i class="bi bi-person-circle"></i></a>
                        <div class="dropdown-panel" style="min-width:220px">
                            <a href="{{ route('account') }}"><i class="bi bi-person"></i> {{ __('My Account') }}</a>
                            <a href="{{ route('account.orders') }}"><i class="bi bi-bag"></i> {{ __('My Orders') }}</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('Admin Panel') }}</a>
                            @endif
                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Log out') }}</a>
                        </div>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-circle"></i></a></li>
                @endauth

                @if(fiyat_goster())
                <li class="nav-item">
                    <a class="nav-cart" href="{{ route('cart') }}" title="{{ __('Cart') }}">
                        <i class="bi bi-bag"></i>
                        @if($cartCount > 0)<span class="badge">{{ $cartCount }}</span>@endif
                    </a>
                </li>
                @else
                <li class="nav-item"><a class="nav-link nav-cta" href="{{ route('contact') }}">{{ __('Request Quote') }}</a></li>
                @endif

                <li class="nav-item lang-switch-mobile">
                    <a class="nav-link {{ app()->getLocale()==='tr' ? 'active' : '' }}" href="{{ route('lang.switch', 'tr') }}">TR</a>
                    <a class="nav-link {{ app()->getLocale()==='en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">EN</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
