@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('gb-static/less/index.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/wow/animate.min.css') }}"/>
    <style>

    </style>
@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('static/ChartJS/chart.min.js') }}"></script>
    <script src="{{ asset('static/wow/wow.min.js') }}"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart;

        $('#chart').waypoint(function() {
            @php
                $home_chart_data = $setting->get('home_chart_data')->toArray();
            @endphp
            if(!myChart){
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($home_chart_data as $item)
                            "{{ data_get($item,'label') }}",
                            @endforeach
                        ],

                        datasets: [{
                            label: '#佔比',
                            data: [
                                @foreach($home_chart_data as $item)
                                    "{{ data_get($item,'value') }}",
                                @endforeach
                            ],
                            backgroundColor: [
                                @foreach($home_chart_data as $item)
                                    "{{ data_get($item,'color') }}",
                                @endforeach
                            ]/*,
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1*/
                        }]
                    },

                    options: {

                        plugins: {
                            title: {
                                display: true,
                                text: "{{ $setting->get('home_chart_title') }}"
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';

                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += context.parsed.y;
                                        }
                                        return label;
                                    }
                                }
                            },
                            legend: {
                                display:false,
                                position: 'top',
                            },

                        },
                        scales: {
                            y: {
                                min: 0,
                                max: 4,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }

                    },
                });
            }

        }, { offset: '50%' });
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
                    

                    const wasOpen = item.hasAttribute('open');
                    if (!wasOpen) {
                        /* item.classList.add('faq-measuring'); */
                        item.setAttribute('open', '');
                        
                        void item.offsetHeight;
                    }
                    

                    const questionHeight = question.offsetHeight;
                    const fullHeight = item.offsetHeight;
                    
            
                    item.style.setProperty('--collapsed-height', `${questionHeight}px`);
                    item.style.setProperty('--expanded-height', `${fullHeight}px`);
                    
                    
                    if (!wasOpen) {
                        item.removeAttribute('open');
                        /* item.classList.remove('faq-measuring'); */
                    }
                });
            }
            
            
            calculateHeights();
            
            
            if (faqItems.length > 0) {
                faqItems[0].setAttribute('open', '');
            }
            
            
            faqItems.forEach(item => {
                item.addEventListener('toggle', function() {
                    if (this.hasAttribute('open')) {
                        
                        faqItems.forEach(otherItem => {
                            if (otherItem !== this && otherItem.hasAttribute('open')) {
                                otherItem.removeAttribute('open');
                            }
                        });
                    }
                });
            });
            
            window.addEventListener('resize', debounce(calculateHeights, 250));
        });
    </script>

@stop


@section('content')
    <section>
        <header class="sec-header">
            <h2 class="title">{{ $setting->get('home_lilly_about_title_gb') }}</h2>
                <p class="text">{{ $setting->get('home_lilly_about_desc_gb') }}</p>
            <a class="more" href="{{ URL::to('about') }}" title="點擊了解更多 關於威而鋼壯陽藥">了解更多 關於威而鋼壯陽藥</a>
        </header>
        <img class="float-image" src="{{ storage_url($setting->get('home_pill_img')) }}" alt="壯陽藥威而鋼藥丸展示圖片" loading="lazy">
        <picture class="image wow animate__animated animate__fadeInUp"><img class="scale-img" src="{{ storage_url($setting->get('home_about_img')) }}" width="500" loading="lazy" alt="{{ $setting->get('home_lilly_about_title') }}"></picture>
    </section>
    <section id="chart" class="reverse">
        <figure class="chart-container">
            <canvas class="wow animate__animated animate__fadeInUp" id="myChart" width="300" height="300"></canvas>
            <figcaption class="chart-title">{{ $setting->get('home_chart_title_gb') }}</figcaption>
        </figure>
        <header class="sec-header health">
            <h2 class="title">{{ $setting->get('home_health_about_title_gb') }}</h2>
            <p class="text">{{ $setting->get('home_health_about_desc_gb') }}</p>
            <a class="more" href="{{ URL::to('about') }}" title="點擊了解更多 關於陰莖勃起障礙（陽痿）">了解更多 關於陰莖勃起障礙（陽痿）</a>
        </header>
    </section>
    <section class="channel">
        <header>
            <h2 class="title">{!! $setting->get('advs_title_gb') !!}</h2>
        </header>
        <div class="picture">
            @foreach($setting->get('cialis_advs')->toArray() as $key=>$item)
                @if($key>=2)
                    @break
                @endif
                <figure class="image wow animate__animated animate__fadeInDown" data-wow-delay="{{ $key>0?$key-0.5:$key }}s">
                    <img class="scale-img" loading="lazy" src="{{ storage_url($item['img']) }}" alt="{{ data_get($item,'title') }}">
                    <figcaption class="content">
                        <h3>{{ data_get($item,'title') }}</h3>
                        <ul>
                            @php
                                $texts = explode(PHP_EOL,data_get($item,'text'))
                            @endphp
                            @foreach($texts as $text)
                                @if($text)
                                    <li>
                                        <i class="iconfont">&#xe615;</i>
                                        <span>{{ trim($text) }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </figcaption>
                </figure>
                
            @endforeach
        </div>
        <section class="dosage-list">
            <h3 class="subtitle">線上訂購威而鋼劑量選擇</h3>
            @foreach($categorys as $item)
                <article class="dosage" itemscope itemtype="https://schema.org/Product">
                    <img class="ad-pic" itemprop="image" loading="lazy" src="{{ storage_url($setting->get('ad_img')) }}" alt="威而鋼VIAGRA® {{ $item->name }} 線上訂購圖片展示 {{ $item->describe }}">
                    <div class="ad-text">
                        <h4 class="p1" itemprop="name"><span class="highlight">{{ $item->describe_gb }}</span><span>威而鋼 VIAGRA<sup>®</sup> {{ $item->name }}</span></h4>
                        <p class="p2" itemprop="description">{{ $item->describe2_gb }}</p>
                    </div>
                    <a href="{{ URL::to($item->uri) }}" itemprop="url" class="ad-btn" title="查看 威而鋼{{ $item->name }} 線上訂購優惠組合">
                        <span>查看 威而鋼{{ $item->name }} 優惠組合</span>
                        <i class="iconfont">&#xe684;</i>
                    </a>
                </article>
            @endforeach
        </section>

    </section>
    <section class="experience">
        <header class="sec-header">
            <h2 class="title">{!! $setting->get('home_diversified_about_title_gb') !!}</h2>
        </header>
        <div class="content">
            <div class="present">
                <p class="text">{{ $setting->get('home_diversified_about_desc_gb') }}</p>
                <a class="more text-underline" href="{{ URL::to('diversity-inclusion') }}" title="了解更多 包容性與多元化">了解更多 包容性與多元化</a>
            </div>
            <div class="accordion">
                @foreach($setting->get('home_diversified_images')->toArray() as $key=>$image)
                    @if($key>=4)
                        @break
                    @endif
                    <img class="back wow animate__animated {{ $key%2==0?"animate__fadeInUp":"animate__fadeInDown" }} " loading="lazy" src="{{storage_url(data_get($image,'img'))}}" alt="{{ data_get($image,'alt') }}">
                @endforeach
            </div>
        </div>
        <section class="news-list" aria-label="做愛知識分享">
            <h3 class="subtitle">做愛知識分享</h3>
            @foreach($news->where('article_cate_id',4)->take(3) as $item)
                <article class="news-item">
                    <a href="{{ $item->uri }}" title="閱讀 {{ $item->title }}全部內容">
                        <img class="news-image" src="{{ storage_url($item->img) }}" loading="lazy" alt="{{ $item->title }}">
                        <h4 class="news-title">{{ $item->title }}</h4>
                        <p class="news-desc">{{ $item->brief }}</p>
                        <span class="more text-underline">閱讀全文</span>
                    </a>
                </article>
            @endforeach
        </section>
    </section>
    <section class="faq-section">
        <header class="sec-header">
            <h2 class="title">威而鋼壯陽藥顧客常見疑問</h2>
        </header>
        @foreach($faqs as $faq)
            @if($faq->category_id == 0)
            <details class="faq-item">
                <summary class="faq-question">
                    <span class="question-text">{{ $faq->questions }}</span>
                    <i class="iconfont faq-icon">&#xeca2;</i>
                </summary>
                <p class="faq-answer">{{ $faq->answers }}</p>
            </details>
            @endif
        @endforeach
        <a class="more text-underline" href="{{ URL::to('faq') }}" title="了解更多 威而鋼壯陽藥顧客常見疑問">了解更多 威而鋼壯陽藥顧客常見疑問</a>
    </section>
    <section class="news">
        <header class="sec-header">
            <h2 class="title">{{ $setting->get('home_news_about_title_gb') }}</h2>
            <p class="text">{{ $setting->get('home_news_about_desc_gb') }}</p>
            <a class="more" href="{{ URL::to('blog') }}" title="點擊了解更多 威而鋼壯陽藥新聞">了解更多 威而鋼壯陽藥新聞</a>
        </header>
        @foreach($news->where('article_cate_id',3)->take(3) as $item)
            <article class="news-item">
                <a href="{{ $item->uri }}" title="閱讀 {{ $item->title }}全部內容">
                    <img class="news-image" src="{{ storage_url($item->img) }}" loading="lazy" alt="{{ $item->title }}">
                    <h4 class="news-title">{{ $item->title }}</h4>
                    <p class="news-desc">{{ $item->brief }}</p>
                    <span class="more text-underline">閱讀全文</span>
                </a>
            </article>
        @endforeach
    </section>
@endsection
