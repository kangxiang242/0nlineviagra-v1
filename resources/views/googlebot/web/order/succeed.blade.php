@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/checkout.css') }}"/>
    <style>
        .success-ico{

        }
        .circle {
            stroke-dasharray: 1194;
            stroke-dashoffset: 1194;
            transform: rotate(-67deg)translate(-274px,10px);
        }
        .tick {
            stroke-dasharray: 350;
            stroke-dashoffset: 350;
            transform: translate(-30px,-100px);

        }
        svg .tick {
            animation: tick .8s ease-out;
            animation-fill-mode: forwards;
            animation-delay: .95s;
        }
        svg .circle {
            animation: circle 1s ease-in-out;
            animation-fill-mode: forwards;
        }
        @keyframes circle {
            from {
                stroke-dashoffset: 1194;
            }
            to {
                stroke-dashoffset: 2288;
            }
        }

        @keyframes tick {
            from {
                stroke-dashoffset: 350;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

    </style>
@stop

@section('script')
    @parent

@stop
@section('banners')@stop

@section('footer')
@stop

@section('header')
@stop

@section('title','訂單已安全建立')

@section('content')
    <div class="header">
        <div class="c-logo">
            <a href="{{ URL::to('/') }}" class="lds-logo-pfizer">
                @if($setting->get('logo_type')->value() == 1)
                    {!! $setting->get('logo_svg') !!}
                @else
                    <img class="g-logo" src="{{ storage_url($setting->get('logo')) }}" alt="logo">
                @endif
            </a>
        </div>
    </div>
    <div class="step">
        <div class="list active">
            <div class="num">STEP 1</div>
            <div class="line"><span class="centre"></span></div>
            <p class="text">確認訂購訊息</p>
        </div>
        <div class="list active">
            <div class="num">STEP 2</div>
            <div class="line"><span class="centre"></span></div>
            <p class="text">安全建立訂單</p>
        </div>
    </div>

    <div class="success">
        {{--<p class="ico"><i class="iconfont">&#xe651;</i></p>--}}
        <div class="success-ico">
            <svg width="300" height="300">
                <circle fill="none" stroke="#D42F1D" stroke-width="13" cx="200" cy="200" r="100" class="circle" stroke-linecap="round" />
                <polyline fill="none" stroke="#D42F1D" stroke-width="13" points="149,239 187,281 291,180" stroke-linecap="round" stroke-linejoin="round" class="tick"  />
            </svg>
        </div>
        <p class="text">訂單已安全建立，請耐心等候配送</p>
        <p><a class="home-btn" href="{{ URL::to('/') }}"><span>返回首頁</span><i class="iconfont">&#xe625;</i></a></p>
        <p><a class="order-btn" href="{{ URL::to('order/'.$order->no) }}">查看訂單詳情</a></p>
    </div>
@endsection
