@extends('web::layout')
@if($news->seo_title)
    @section('title', $news->seo_title)
@else
    @section('title', $news->title)
@endif

@if($news->seo_keyword)
    @section('keywords', $news->seo_keyword)
@endif

@if($news->seo_description)
    @section('description', $news->seo_description)
@endif
@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/news-desc.css') }}"/>
@stop

@section('breadcrumb')
    <nav aria-label="Breadcrumb">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('/') }}">首頁</a></li>
            <li><a href="{{ URL::to('news') }}">{{ $news->cate->name }}</a></li>
            <li class="active">{{ $news->title }}</li>
        </ul>
    </nav>
@stop

@section('page-header')@stop

@section('content')
    <article class="news-container">
        <header class="news-header">
            <img class="news-img" src="{{ storage_url($news->img) }}" alt="{{ $news->title }}">
            <h1 class="title">{{ $news->title }}</h1>
            <div class="source-date">
                <a class="text-underline" href="{{ URL::to($news->cate->uri) }}">{{ $news->cate->name_gb }}</a>
                <time datetime="{{ $news->release_at->format('Y-m-d') }}">{{ $news->release_at->format('M') }} {{ $news->release_at->format('d') }}, {{ $news->release_at->format('Y') }}</time>
            </div>
        </header>
        <section class="news-content">
            {!! $news->content !!}
        </section>
        <footer class="news-footer">
            <section class="news-share">
                <h2>分享該文章至：</h2>
                <ul class="share-list">
                    <li><a href="https://twitter.com/intent/tweet?url=https://0nlineviagra.com&text=威而鋼線上訂購官網" target="_blank" rel="noopener noreferrer nofollow">
                        <svg class="social-icons" xmlns="http://www.w3.org/2000/svg" text-rendering="geometricPrecision" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 452"><path fill-rule="nonzero" d="M403.229 0h78.506L310.219 196.04 512 462.799H354.002L230.261 301.007 88.669 462.799h-78.56l183.455-209.683L0 0h161.999l111.856 147.88L403.229 0zm-27.556 415.805h43.505L138.363 44.527h-46.68l283.99 371.278z"/></svg>
                    </a></li>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
                        <svg class="social-icons" viewBox="0 0 9 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="m8.67416189.00332907-2.15869076-.00332907c-2.42521503 0-3.99249553 1.5455198-3.99249553 3.93762159v1.81550721h-2.170467c-.18755412 0-.33943313.14614609-.33943313.32641512v2.63046305c0 .18026903.15205219.32624866.33943313.32624866h2.170467v6.63749567c0 .1802691.15187901.3262487.33943313.3262487h2.83184206c.18755412 0 .33943312-.1461461.33943312-.3262487v-6.63749567h2.53778214c.18755412 0 .33943312-.14597963.33943312-.32624866l.00103909-2.63046305c0-.08655577-.0358483-.16944956-.09940542-.23070441s-.1501472-.09571071-.24020089-.09571071h-2.53864804v-1.53902812c0-.7397189.1833978-1.11523776 1.18593777-1.11523776l1.45419385-.00049936c.18738094 0 .33925994-.14614609.33925994-.32624867v-2.44253716c0-.17993612-.15170582-.32591576-.33891358-.32624866z"></path>
                        </svg>
                    </a></li>
                    <li><a href="https://www.linkedin.com/sharing/share-offsite/?url=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
                        <svg class="social-icons" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="m16 9.82727973v6.18916327h-3.4306819v-5.7775259c0-1.45258443-.4946577-2.43981378-1.7360032-2.43981378-.94932925 0-1.50933678.66838985-1.7593258 1.31163672-.09001077.23164451-.11734861.55605189-.11734861.87629211v6.02867545h-3.42730229s.04600922-9.78152668 0-10.79456435h3.42800498v1.53000939c-.00465112.01257149-.01465603.02300687-.01934061.03697908h.01934061v-.03697908c.45798417-.73534439 1.26931912-1.78329507 3.09131782-1.78329507 2.261345.00003502 3.951339 1.5426159 3.951339 4.85942216zm-14.05934771-9.81083678c-1.17264961 0-1.94065229.8051354-1.94065229 1.86702327 0 1.03327811.74534941 1.86562254 1.89665074 1.86562254h.02067905c1.198649 0 1.94132151-.83234443 1.94132151-1.86562254-.02332249-1.06188787-.74263904-1.86702327-1.91799901-1.86702327zm-1.73596981 15.99996495h3.42867421v-10.79592999h-3.42867421z"></path>
                        </svg>
                    </a></li>
                    <li><a href="https://social-plugins.line.me/lineit/share?url=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
                        <svg t="1695262777179" class="social-icons" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="36545" width="200" height="200"><path d="M826.24 420.821333a26.922667 26.922667 0 0 1 0 53.802667H751.36v48h74.88a26.88 26.88 0 1 1 0 53.717333h-101.802667a26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88h101.802667a26.88 26.88 0 0 1-0.128 53.76H751.36v48h74.88z m-164.48 128.682667a26.88 26.88 0 0 1-26.922667 26.752 26.368 26.368 0 0 1-21.76-10.666667l-104.234666-141.525333v125.44a26.88 26.88 0 0 1-53.632 0V345.941333a26.752 26.752 0 0 1 26.624-26.794666c8.32 0 16 4.437333 21.12 10.837333l105.045333 142.08V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.72 0 26.88 12.16 26.88 26.88v203.562667z m-244.949333 0a26.965333 26.965333 0 0 1-26.922667 26.837333 26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.762667 0 26.794667 12.16 26.794667 26.88v203.562667z m-105.216 26.837333H209.792a27.050667 27.050667 0 0 1-26.88-26.837333V345.941333c0-14.72 12.16-26.88 26.88-26.88 14.848 0 26.88 12.16 26.88 26.88v176.682667h74.922667a26.88 26.88 0 0 1 0 53.717333M1024 440.064C1024 210.901333 794.24 24.405333 512 24.405333S0 210.901333 0 440.064c0 205.269333 182.186667 377.258667 428.16 409.941333 16.682667 3.498667 39.381333 11.008 45.141333 25.173334 5.12 12.842667 3.370667 32.682667 1.621334 46.08l-6.997334 43.52c-1.92 12.842667-10.24 50.602667 44.757334 27.52 55.082667-22.997333 295.082667-173.994667 402.602666-297.6C988.842667 614.101333 1024 531.541333 1024 440.064"  p-id="36546"></path></svg>
                    </a></li>
                </ul>
            </section>
            <section class="recommend">
                <h2>推薦閱讀：</h2>
                <ul class="recommend-list">
                @foreach($recommend as $item)
                    <li>
                        <a class="recommend-item" href="{{ $item->uri }}" title="閱讀 {{ $item->title }}全部內容">
                            <img class="news-image" src="{{ storage_url($item->img) }}" loading="lazy" alt="{{ $item->title }}">
                            <h3 class="news-title">{{ $item->title }}</h3>
                            <span class="more text-underline">閱讀全文</span>
                        </a>
                    </li>
                @endforeach
                </ul>
            </section>
        </footer>
    </article>
@endsection
