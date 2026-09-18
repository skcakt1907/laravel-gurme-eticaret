<div class="account-nav">
    <a href="{{ route('account') }}" class="{{ request()->routeIs('account') && !request()->routeIs('account.*') ? 'active' : '' }}"><i class="bi bi-person"></i> {{ __('My Account') }}</a>
    <a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') || request()->routeIs('account.order') ? 'active' : '' }}"><i class="bi bi-bag"></i> {{ __('My Orders') }}</a>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('Admin Panel') }}</a>
    @endif
    <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Log Out') }}</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</div>
