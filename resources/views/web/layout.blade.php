<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mate->title ?? view()->yieldContent('title') }}</title>
    <meta name="keywords" content="{{ $mate->key_word ?? view()->yieldContent('keywords') }}"/>
    <meta name="description" content="{{ $mate->description ?? view()->yieldContent('description') }}"/>
    <meta property="og:title" content="{{ $mate->title ?? view()->yieldContent('title') }}">
    <meta name="twitter:title" content="{{ $mate->title ?? view()->yieldContent('title') }}">
    <meta property="og:description" content="{{ $mate->description ?? view()->yieldContent('description') }}"/>
    <meta name="twitter:description" content="{{ $mate->description ?? view()->yieldContent('description') }}"/>
    <meta property="og:locale" content="zh_TW" />
    @if(request()->is('/'))
        <meta property="og:type" content="website" />
    @elseif(request()->is('/product'))
        <meta property="og:type" content="product" />
    @else
        <meta property="og:type" content="article" />
    @endif
    <meta property="og:url" content="{{ config('app.url') }}/{{ trim(request()->path(),'/') }}" />
    <meta property="og:site_name" content="{{ $setting->get('site_name') }}" />
    <meta name="robots" content="noarchive" />
    <link rel="canonical" href="{{ config('app.url') }}/{{ trim(request()->path(),'/') }}">

    <link rel="shortcut icon" href="{{ ($favicon = $setting->get('favicon')->value()) ? storage_url($favicon) : '/favicon.svg' }}">
    <style>
        :root{
            --main-color: {{ $setting->get('main_color') }};
            --sub-color: {{ $setting->get('sub_color') }};
            --link-hover-color:{{ $setting->get('link_hover_color') }};
            --product_hover_color:{{ $setting->get('product_hover_color') }};
            --product_btn_hover_color:{{ $setting->get('product_btn_hover_color') }};
        }
    </style>
    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ assetv('static/css/style.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ assetv('static/css/common.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ assetv('static/less/global.css') }}"/>
        <link rel="stylesheet" href="{{ assetv('static/font_3122894_ix34x1wtlao/iconfont.css') }}">
        <link rel="stylesheet" href="{{ assetv('static/swiper4/swiper.min.css') }}">
        <link rel="stylesheet" href="{{ assetv('static/less/section.css') }}">
    @show
    <script src="{{ assetv('static/js/jquery.min.js') }}"></script>
    <script>
        var is_ajax_get_cart = 0;
        var flash_data = '{!! session()->get('flash') !!}';

        if(flash_data){
            flash_data = JSON.parse('{!! session()->get('flash') !!}');

        }else{
            flash_data = false;
        }

        var province = [];

        var free_shipping_where = parseInt("{{ $setting->get('freight_where',0) }}");
        var free_shipping_freight = parseInt("{{ $setting->get('freight',0) }}");
        var is_mobile_domain = parseInt("{{ is_mobile()?"1":"0" }}");
    </script>

    <link rel="stylesheet" href="{{ asset('static/swiper/swiper-bundle.min.css') }}" />
    <script src="{{ asset('static/swiper/swiper-bundle.min.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const isPC = !/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            const swiper = new Swiper('.swiper-container', {
                loop: true,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: true,
                speed: 1000,
                allowTouchMove: !isPC
            });
            swiper.on('slideChangeTransitionStart', () => {
                const slides = document.querySelectorAll('.swiper-slide');
                slides.forEach(slide => {
                    slide.style.opacity = '0'; // 預設透明
                });

                // 更新當前、前一個、後一個
                swiper.slides[swiper.activeIndex].style.opacity = '1';
                const prevIndex = swiper.activeIndex === 0 ? swiper.slides.length - 1 : swiper.activeIndex - 1;
                const nextIndex = (swiper.activeIndex + 1) % swiper.slides.length;

                swiper.slides[prevIndex].style.opacity = '0';
                swiper.slides[nextIndex].style.opacity = '0';
            });
        });
        function closeAside() {
            const aside = document.querySelector('.ad-carousel');
            aside.style.display = "none";
        }
    </script>
</head>
<body>

@section('header')
<header class="main-head">
    <a href="{{ URL::to('/') }}" class="logo-sec-link">
        @if($setting->get('logo_type') == '1')
            {!! $setting->get('logo_svg') !!}
        @else
            <img class="g-logo" src="{{ storage_url($setting->get('logo')) }}" alt="輝瑞威而鋼壯陽藥官網logo">
        @endif
    </a>
    <nav class="nav-sec" aria-label="主選單">
        <a class="menu-btn nav-heading close-btn" href="javascript:;" onclick="closeMobileMenu()">
            <span class="text">關閉選單</span>
            <i class="iconfont">&#xeca0;</i>
        </a>
        <div class="base">
            <div class="link-parent" tabindex="0">
                <p class="base-link">威而鋼 VIAGRA<sup>®</sup>&nbsp;線上訂購<i class="iconfont">&#xeca2;</i></p>
                <div class="mega-menu">
                    @foreach($categorys as $item)
                    <div class="link-item"><a href="{{ $item->uri?url($item->uri):"javascript:;" }}">威而鋼 VIAGRA<sup>®</sup>&nbsp;{{ $item->name }}</a></div>
                    @endforeach
                </div>
            </div>
            @foreach($navigations as $nav)
                <div class="link-parent" tabindex="0">
                    <p class="base-link">{{ $nav->name }}<i class="iconfont">&#xeca2;</i></p>
                    @if($nav->sub && count($nav->sub))
                        <div class="mega-menu">
                            @foreach($nav->sub as $sub)
                            <div class="link-item"><a href="{{ $sub->link?url($sub->link):"javascript:;" }}">{{ $sub->name }}</a></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </nav>
    <a class="menu-btn" href="javascript:;" onclick="showMobileMenu()">
        <span class="text">選單</span>
        <i class="iconfont">&#xe62c;</i>
    </a>
    <div class="shade" onclick="closeMobileMenu()"></div>
</header>

@show

@section('page-header')
    @php
        $class = Request::is('/') ? '' : 'hasborad';
    @endphp
    <aside class="ad-carousel swiper-container" aria-label="威而鋼線上訂購推薦">
        <div class="swiper-wrapper">
            @foreach($categorys as $item)
            <article class="swiper-slide" itemscope itemtype="https://schema.org/Product">
                <img class="ad-pic" itemprop="image" src="{{ storage_url($setting->get('ad_img')) }}" alt="威而鋼VIAGRA® {{ $item->name }} 線上訂購產品圖片展示">
                <div class="ad-text">
                    <h2 class="p1" itemprop="name"><span>威而鋼 VIAGRA<sup>®</sup> {{ $item->name }}</span>{{ $item->describe }}</h2>
                    <p class="p2" itemprop="description">{{ $item->describe2 }}</p>
                </div>
                <a href="{{ URL::to($item->uri) }}" itemprop="url" class="ad-btn" title="立即訂購威而鋼 {{ $item->name }}">
                    <span>立即訂購</span>
                    <i class="iconfont">&#xe684;</i>
                </a>
            </article>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <a class="close-btn" href="javascript:;" onclick="closeAside()">
            <i class="iconfont">&#xeca0;</i>
        </a>
    </aside>
    <header class="page-head {{ $class }}">
        <div class="page-header-content">
            <h1>{!! isset($page)?$page->title:"" !!}</h1>
            <p class="sub">@yield('billboard-desc')</p>
        </div>
        @if($banner)
            <div class="banner">
                <img src="{{ storage_url($banner->img) }}" alt="Banner">
            </div>
            @yield('embed-banner')
        @endif
    </header>
@show

@section('breadcrumb')
@show

<main>
@yield('content')
</main>

@section('footer')
<footer>
    <div class="logo-sec">
        <a href="{{ URL::to('/') }}" class="logo">
            @if($setting->get('logo_type')->value() == 1)
                {!! $setting->get('logo_svg') !!}
            @else
                <img class="g-logo" src="{{ storage_url($setting->get('logo')) }}" alt="logo">
            @endif
        </a>
        <a href="https://twitter.com/intent/tweet?url=https://0nlineviagra.com&text=威而鋼線上訂購官網" target="_blank" rel="noopener noreferrer nofollow">
            <svg class="social-icons" xmlns="http://www.w3.org/2000/svg" text-rendering="geometricPrecision" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 452"><path fill-rule="nonzero" d="M403.229 0h78.506L310.219 196.04 512 462.799H354.002L230.261 301.007 88.669 462.799h-78.56l183.455-209.683L0 0h161.999l111.856 147.88L403.229 0zm-27.556 415.805h43.505L138.363 44.527h-46.68l283.99 371.278z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
            <svg class="social-icons" viewBox="0 0 9 16" xmlns="http://www.w3.org/2000/svg">
                <path d="m8.67416189.00332907-2.15869076-.00332907c-2.42521503 0-3.99249553 1.5455198-3.99249553 3.93762159v1.81550721h-2.170467c-.18755412 0-.33943313.14614609-.33943313.32641512v2.63046305c0 .18026903.15205219.32624866.33943313.32624866h2.170467v6.63749567c0 .1802691.15187901.3262487.33943313.3262487h2.83184206c.18755412 0 .33943312-.1461461.33943312-.3262487v-6.63749567h2.53778214c.18755412 0 .33943312-.14597963.33943312-.32624866l.00103909-2.63046305c0-.08655577-.0358483-.16944956-.09940542-.23070441s-.1501472-.09571071-.24020089-.09571071h-2.53864804v-1.53902812c0-.7397189.1833978-1.11523776 1.18593777-1.11523776l1.45419385-.00049936c.18738094 0 .33925994-.14614609.33925994-.32624867v-2.44253716c0-.17993612-.15170582-.32591576-.33891358-.32624866z"></path>
            </svg>
        </a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
            <svg class="social-icons" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="m16 9.82727973v6.18916327h-3.4306819v-5.7775259c0-1.45258443-.4946577-2.43981378-1.7360032-2.43981378-.94932925 0-1.50933678.66838985-1.7593258 1.31163672-.09001077.23164451-.11734861.55605189-.11734861.87629211v6.02867545h-3.42730229s.04600922-9.78152668 0-10.79456435h3.42800498v1.53000939c-.00465112.01257149-.01465603.02300687-.01934061.03697908h.01934061v-.03697908c.45798417-.73534439 1.26931912-1.78329507 3.09131782-1.78329507 2.261345.00003502 3.951339 1.5426159 3.951339 4.85942216zm-14.05934771-9.81083678c-1.17264961 0-1.94065229.8051354-1.94065229 1.86702327 0 1.03327811.74534941 1.86562254 1.89665074 1.86562254h.02067905c1.198649 0 1.94132151-.83234443 1.94132151-1.86562254-.02332249-1.06188787-.74263904-1.86702327-1.91799901-1.86702327zm-1.73596981 15.99996495h3.42867421v-10.79592999h-3.42867421z"></path>
            </svg>
        </a>
        <a href="https://social-plugins.line.me/lineit/share?url=https://0nlineviagra.com" target="_blank" rel="noopener noreferrer nofollow">
            <svg t="1695262777179" class="social-icons" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="36545" width="200" height="200"><path d="M826.24 420.821333a26.922667 26.922667 0 0 1 0 53.802667H751.36v48h74.88a26.88 26.88 0 1 1 0 53.717333h-101.802667a26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88h101.802667a26.88 26.88 0 0 1-0.128 53.76H751.36v48h74.88z m-164.48 128.682667a26.88 26.88 0 0 1-26.922667 26.752 26.368 26.368 0 0 1-21.76-10.666667l-104.234666-141.525333v125.44a26.88 26.88 0 0 1-53.632 0V345.941333a26.752 26.752 0 0 1 26.624-26.794666c8.32 0 16 4.437333 21.12 10.837333l105.045333 142.08V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.72 0 26.88 12.16 26.88 26.88v203.562667z m-244.949333 0a26.965333 26.965333 0 0 1-26.922667 26.837333 26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.762667 0 26.794667 12.16 26.794667 26.88v203.562667z m-105.216 26.837333H209.792a27.050667 27.050667 0 0 1-26.88-26.837333V345.941333c0-14.72 12.16-26.88 26.88-26.88 14.848 0 26.88 12.16 26.88 26.88v176.682667h74.922667a26.88 26.88 0 0 1 0 53.717333M1024 440.064C1024 210.901333 794.24 24.405333 512 24.405333S0 210.901333 0 440.064c0 205.269333 182.186667 377.258667 428.16 409.941333 16.682667 3.498667 39.381333 11.008 45.141333 25.173334 5.12 12.842667 3.370667 32.682667 1.621334 46.08l-6.997334 43.52c-1.92 12.842667-10.24 50.602667 44.757334 27.52 55.082667-22.997333 295.082667-173.994667 402.602666-297.6C988.842667 614.101333 1024 531.541333 1024 440.064"  p-id="36546"></path></svg>
        </a>
        
    </div>
    <nav class="main-links" aria-label="威而鋼線上訂購連結">
        <p class="links-title">輝瑞威而鋼 VIAGRA<sup>®</sup>&nbsp;線上訂購：</p>
        <div class="links-list">
            @foreach($categorys as $item)
                <p class="links-item"><a href="{{ $item->uri?url($item->uri):"javascript:;" }}">威而鋼 VIAGRA<sup>®</sup>&nbsp;{{ $item->name }}</a></p>
            @endforeach
        </div>
    </nav>
    <p class="foot-text">{!! str_replace(PHP_EOL,'<br>',$setting->get('foot_text')) !!}</p>

</footer>
@show

</body>

@section('script')
<script src="{{ assetv('static/swiper4/swiper.min.js') }}"></script>
<script src="{{ assetv('static/js/jquery.cookie.js') }}"></script>
<script src="{{ assetv('static/js/xie.js') }}"></script>


<script>
    function showMobileMenu(){
        $('.main-head').addClass('show_mobile_menu');
        $('body').css('overflow', 'hidden')
    }
    function closeMobileMenu(){
        $('.main-head').removeClass('show_mobile_menu');
        $('body').css('overflow', 'auto')
    }
</script>
@php
    $trackingPath = trim(request()->path(), '/');
    $trackingPageType = 'cms';
    if ($trackingPath === '') {
        $trackingPageType = 'home';
    } elseif (request()->is('checkout/*') || request()->is('shopping/*')) {
        $trackingPageType = 'checkout';
    } elseif (request()->is('order/success/*')) {
        $trackingPageType = 'order_success';
    } elseif (request()->is('order/*')) {
        $trackingPageType = 'order_status';
    } elseif (request()->is('check')) {
        $trackingPageType = 'order_check';
    } elseif (request()->is('contact')) {
        $trackingPageType = 'message';
    } elseif (request()->is('faq')) {
        $trackingPageType = 'faq';
    } elseif (isset($news)) {
        $trackingPageType = 'news_detail';
    } elseif (request()->is('news') || request()->is('blog')) {
        $trackingPageType = 'news_list';
    } elseif (isset($category)) {
        $trackingPageType = 'product_list';
    } elseif (request()->is('product/*')) {
        $trackingPageType = 'product_detail';
    }
    $trackingGoodsId = $trackingPageType === 'checkout' && isset($goods) ? ($goods->id ?? null) : null;
    $trackingSiteName = (string) $setting->get('site_name');
@endphp
<script>
    window.__TRACKING_CONFIG__ = {
        endpoint: '/observer/store',
        webHost: location.hostname,
        site: @json($trackingSiteName),
        enabled: true
    };
    window.__TRACKING_PAGE__ = {
        page_type: @json($trackingPageType),
        goods_id: @json($trackingGoodsId),
        article_id: @json(isset($news) ? ($news->id ?? null) : null),
        category_id: @json(isset($category) ? ($category->id ?? null) : null),
        cms_uri: @json(isset($page) ? ($page->uri ?? null) : null)
    };
</script>
<script src="{{ assetv('static/js/tracker.js') }}" defer></script>
<script src="{{ assetv('static/js/observer.js') }}" defer></script>
@show

</html>
