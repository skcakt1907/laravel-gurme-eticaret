@extends('layouts.app')
@section('title', 'Journal — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ __('Journal') }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Journal') }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-4">
            @foreach($posts as $b)
            <div class="col-lg-4 col-md-6">
                <div class="blog-card">
                    <div class="img">
                        <img src="{{ $b->image_url }}" alt="">
                        <span class="cat">{{ $b->category }}</span>
                    </div>
                    <div class="blog-body">
                        <div class="meta"><i class="bi bi-calendar3"></i>{{ optional($b->tarih)->format('d M Y') }}</div>
                        <h5><a href="{{ route('blog.show', $b) }}">{{ $b->title }}</a></h5>
                        <p>{{ $b->summary }}</p>
                        <a href="{{ route('blog.show', $b) }}" style="color:var(--primary);font-weight:600">{{ __('Read More') }} <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
