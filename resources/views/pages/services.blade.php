@extends('layouts.app')
@section('title', 'Why AEGEA — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('Why AEGEA') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Why AEGEA') }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-4">
            @foreach($services as $h)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('service.show', $h) }}" class="service-card">
                    <div class="icon"><i class="bi {{ $h->icon }}"></i></div>
                    <h4>{{ $h->title }}</h4>
                    <p>{{ $h->summary }}</p>
                    <span class="more">{{ __('Details') }} <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
