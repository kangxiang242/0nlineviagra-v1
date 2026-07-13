@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('static/less/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('static/swiper4/swiper.min.css') }}">

@stop

@section('script')
    @parent
    <script src="{{ asset('static/swiper4/swiper.min.js') }}"></script>
    <script>
        (function($){
            $.fn.toPosition = function(){
                var top = this.offset().top;

                $('body,html').animate({scrollTop:top}, 200);
            }
        })(jQuery)
    </script>

    <script>
        $('a[data-toggle="dropdown"]').click(function(){
            var id = $(this).attr('id');
            var dropdown_elem = $('ul[aria-labelledby="'+id+'"]');
            if(dropdown_elem.hasClass('show')){
                dropdown_elem.removeClass('show');
            }else{
                dropdown_elem.addClass('show');
            }

        });


        $('.spec-item2').click(function(){
            var text = $(this).attr('data-text');
            $(this).parent().addClass('activate').siblings().removeClass('activate');
            $('#dropdownMenu1').find('.text').text(text);
            $('.dropdown').removeClass('show')

            var eq = $(this).parent().index();
            $('.spec-item').parent().eq(eq).addClass('activate').siblings().removeClass('activate');

            changeCover($(this).parent().index());
        });



        $('.go-checkout').click(function(){
            var id = $(this).attr('data-id');
            var spec = $('.spec-main li.activate').find('a').attr('data-spec');

            window.location.href = "{{ URL::to('checkout') }}/"+id;

        });

        $('.view-btn').click(function(){
            $('.scheme').toPosition();
        });

        $('.prescribe a').click(function(){
            $('.prescribe').toPosition();
        });
        var mySwiper;
        $(function(){
            mySwiper = new Swiper('#goods-swiper', {
                autoplay: false,
                allowTouchMove: false,
                initialSlide:0,
            })
            $('.spec-item').click(function(){
                var text = $(this).attr('data-text');
                $(this).parent().addClass('activate').siblings().removeClass('activate');
                $('#dropdownMenu1').find('.text').text(text);
                $('.dropdown').removeClass('show')

                changeCover($(this).parent().index());
            });

            $('.toggle-btn').click(function(){
                var $content = $('.prescribe');
                var $button = $(this);
                
                if($content.hasClass('expanded')) {
                    $content.removeClass('expanded').css('height', '500px');
                    $button.text('查看全部內容');
                } else {
                    $content.addClass('expanded').css('height', 'auto');
                    $button.text('收起內容');
                }
            });
        })


        function changeCover(to){
            mySwiper.slideTo(to, 500, true);

            changeGrain(to);
        }

        function changeGrain(to){
            $('[data-tab-id="'+to+'"]').addClass('show').siblings().removeClass('show')
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            const faqItems = document.querySelectorAll('.faq-item');

            function calculateHeights() {
                faqItems.forEach(item => {
                    const question = item.querySelector('.faq-question');
                    const answer = item.querySelector('.faq-answer');

                    const wasOpen = item.classList.contains('open');
                    if (!wasOpen) {
                        item.classList.add('open');
                        item.offsetHeight;
                    }

                    const questionHeight = question.offsetHeight;
                    const fullHeight = item.offsetHeight;

                    item.style.setProperty('--collapsed-height', `${questionHeight}px`);
                    item.style.setProperty('--expanded-height', `${fullHeight}px`);

                    if (!wasOpen) {
                        item.classList.remove('open');
                    }
                });
            }

            calculateHeights();

            if (faqItems.length > 0) {
                faqItems[0].classList.add('open');
            }

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = item.classList.contains('open');
                    
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('open')) {
                            otherItem.classList.remove('open');
                        }
                    });

                    if (isOpen) {
                        item.classList.remove('open');
                    } else {
                        item.classList.add('open');
                    }
                });
            });

            window.addEventListener('resize', debounce(calculateHeights, 250));
        });
    </script>
@stop
@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">首頁</a></li>
        <li class="active">線上訂購威而鋼{{ $category->name }}</li>
    </ul>
@stop
@section('title-before','訂購'.$category->name)
@section('banners')@stop
@section('page-header')@stop
@section('content')

    <div class="goods">
        <div class="info-wrap">
            <img src="{{ storage_url($category->img) }}" loading="lazy" oncontextmenu="return false" draggable="false" alt="{{ $setting->get('page_product_title') }} {{ $category->name }}包裝展示 - {{ $category->describe }}">
            <h1>{{ $setting->get('page_product_title') }} {{ $category->name }}</h1>
            <p class="sub">{{ $category->describe }}｜{{ $category->describe2 }}</p>
            <p class="en-name">{{ $setting->get('page_product_title_en') }}</p>
            <div class="indication">
                <p class="title">功效與適應症說明：</p>
                <div class="indication-list">
                    @foreach($setting->get('adapt')->toArray() as $item)
                    <p>{{ data_get($item,'text') }}</p>
                    @endforeach
                </div>
            </div>
            <div class="sku">
                <p class="title">劑量選擇：</p>
                <div class="spec-main">
                    @foreach($categorys as $key=>$item)
                        <p class="spec-item {{ $item->uri==request()->path()?"activate":"" }}"><a href="{{ URL::to($item->uri) }}">{{ $item->name }}</a ></p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <p class="hero-title">組合裝線上訂購</p>
            <div class="products">
                @foreach($category->products as $goods)
                    <div class="product-item">
                        <div class="quantity">
                            <p class="cate">威而鋼 {{ $category->name }}</p>
                            <p class="goods-name">{{ $goods->name }}</p>
                            <p class="price"><small>NT$</small>{{ number_format(round($goods->price)) }}</p>
                        </div>
                        <div class="button">
                            <a class="go-checkout" data-id="{{ $goods->id }}"><span>立即訂購</span><i class="iconfont">&#xe625;</i></a>
                            <span class="freight">免配送服務費</span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        
    </div>
    <div class="prescribe">
        <p class="hero-title">處方訊息</p>
        @php
            $prescribes = [];
            try {
                $prescribes = json_decode($setting->get('prescribes'),true);
            }catch (\Exception $exception){

            }
        @endphp
        @foreach($prescribes as $item)
            <div class="accordion-content">
                <p class="title">{{ data_get($item,'title') }}</p>
                {!! data_get($item,'content') !!}
            </div>
        @endforeach
        <p class="toggle-btn">查看全部內容</p>
    </div>
    <div class="faq-section">
        <p class="hero-title">常見問題</p>
        @foreach($faqs as $faq)
            @if($faq->category_id == $category->id)
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-text">{{ $faq->questions }}</span>
                    <i class="iconfont faq-icon">&#xeca2;</i>
                </div>
                <p class="faq-answer">{{ $faq->answers }}</p>
            </div>
            @endif
        @endforeach
    </div>
    <div class="news-section">
        <p class="hero-title">性健康知識</p>
        <div class="news-container">
            @foreach($news->where('article_cate_id',4)->take(3) as $item)
                <div class="news-item">
                    <a href="{{ $item->uri }}" title="閱讀 {{ $item->title }}全部內容">
                        <img class="news-image" src="{{ storage_url($item->img) }}" loading="lazy" alt="{{ $item->title }}">
                        <p class="news-title">{{ $item->title }}</p>
                        <p class="news-desc">{{ $item->brief }}</p>
                        <span class="more text-underline">閱讀全文</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


@endsection
