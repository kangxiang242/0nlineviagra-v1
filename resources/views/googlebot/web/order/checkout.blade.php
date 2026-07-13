@extends('web::layout')
@php
    $freight_where = $setting->get('freight_where',0)->value();
    $freight_price = $setting->get('freight',0)->value();

    $delivery_type_all = $setting->get('delivery_type')->toArray();

@endphp
@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/checkout.css') }}"/>
    <style>
        footer{
            display: none;
        }
    </style>
@stop

@section('header')
@stop
@section('customer-service')
@stop
@section('banners')
@stop
@section('page-header')
@stop
@section('title','快速結賬-'.$setting->get('page_product_title').$goods->category->name.' / '.$goods->name)

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script src="{{ assetv('gb-static/js/relx.js') }}"></script>
    <script src="{{ assetv('gb-static/js/api.js') }}"></script>
    <script src="{{ assetv('gb-static/js/xarea.js') }}"></script>
    <script>
        $(".form-input").focus(function(){
            if(!$(this).hasClass(focus)){
                $(this).addClass('focus');
            }

        })
        $(".form-input").blur(function(){
            if(!$(this).val()){
                $(this).removeClass('focus');
            }
        });
        $('.label').click(function(){
            $(this).prev().focus();
        })

        $('input[name="order_type"]').click(function(){
            if($(this).val()>0){
                $('#rel-order-type').text("取貨付款");
            }else{
                $('#rel-order-type').text("貨到付款");
            }

        })


    </script>

@stop


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
        <div class="list">
            <div class="num">STEP 2</div>
            <div class="line"><span class="centre"></span></div>
            <p class="text">安全建立訂單</p>
        </div>
    </div>
    <div class="form-container">
        <div class="wrap">
            <form onsubmit="return orderStore();" method="POST" action="{{ URL::to('order') }}" id="order-form">
                {{ csrf_field() }}
                <input type="hidden" value="{{ request()->keyt }}" name="keyt">
                <input type="hidden" value="{{ $form_token }}" name="form_token">
                <input type="hidden" value="{{ $goods->id }}" name="goods_id">

                <div class="flex-row">
                    <div class="left-side">
                        <div class="card">
                            <div class="head">
                                <p class="title">訂購人與收件人</p>
                            </div>
                            <div class="main">
                                <div class="form-wrap">
                                    <div class="form-group">
                                        <label for="name" class="form-label">訂購人姓名：</label>
                                        <input type="text" class="form-content" name="name" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">聯絡電話：</label>
                                        <input type="text" class="form-content" name="phone" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="form-label">E-mail：</label>
                                        <input type="text" class="form-content" name="email" placeholder="">
                                    </div>
                                    <div class="identical-group">
                                        <div class="dress">
                                            <input type="checkbox" name="identical"  checked>
                                            <label>收件人與訂購人資料相同</label>
                                        </div>
                                        <div class="bef"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="head">
                                <p class="title">配送方式與地址</p>
                            </div>
                            <div class="main">
                                <div class="form-wrap">

                                    <div class="cot">
                                        <div class="form-radio">
                                            <input class="hide" type="radio" id="order-type-1" value="1" name="order_type" checked>
                                            <label for="order-type-1" class="radio-label">
                                                <span class="dress"></span>
                                                <div class="article">
                                                    <p class="text"><span class="s1">超商7-11取貨</span></p>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input class="hide" type="radio" id="order-type-0" value="0" name="order_type">
                                            <label for="order-type-0" class="radio-label">
                                                <span class="dress"></span>
                                                <div class="article">
                                                    <p class="text"><span class="s1">宅配到府</span></p>

                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="area">
                                        <label class="label-title">配送地區：</label>
                                        <div class="choice">
                                            <div class="relate" id="load-1" >
                                                <select name="city" id="city">
                                                    <option value="city">選擇縣市</option>
                                                </select>
                                            </div>

                                            <div class="relate" id="load-2">
                                                <select name="county" id="county">
                                                    <option value="county">選擇地區</option>
                                                </select>
                                            </div>

                                            <div class="relate" id="load-3" >
                                                <select name="street" id="street">
                                                    <option value="street">選擇路段</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="address" id="form-address-row">
                                        <label class="form-label"></label>
                                        <input type="text" class="form-control" name="address">
                                    </div>

                                    <div class="form-store" id="form-store-row">
                                        <div class="store-shop" id="show-store-shop">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="head">
                                <p class="title">付款方式</p>
                            </div>
                            <div class="main">
                                <div class="form-wrap">
                                    <div class="form-radio">
                                        <input class="hide" type="radio" id="pay-1" name="pay_type" value="1" disabled>
                                        <label for="pay-1" class="radio-label">
                                            <span class="dress"></span>
                                            <div class="article">
                                                <p class="text"><span class="s1">信用卡付款（系統升級暫停服務）</span></p>

                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <input class="hide" type="radio" id="pay-2" name="pay_type" value="2" disabled>
                                        <label for="pay-2" class="radio-label">
                                            <span class="dress"></span>
                                            <div class="article">
                                                <p class="text"><span class="s1">ATM付款（系統升級暫停服務）</span></p>

                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <input class="hide" type="radio" id="pay-3" name="pay_type" value="3"  checked>
                                        <label for="pay-3" class="radio-label">
                                            <span class="dress"></span>
                                            <div class="article">
                                                <p class="text"><span class="s1" id="rel-order-type">取貨付款</span></p>

                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="head">
                                <p class="title">包裝</p>
                            </div>
                            <div class="main">
                                <div class="form-wrap">
                                    <div class="form-radio">
                                        <input class="hide" type="radio" id="pack-1" name="pack_type" checked>
                                        <label for="pack-1" class="radio-label grow">
                                            <span class="dress"></span>
                                            <div class="article">
                                                <p class="text"><span class="s1">禮品包裝：</span><span class="s2">隱密包裝&資訊保護</span></p>
                                                <p class="price">+NT$ 0</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="right-side">

                        <div class="card">
                            <div class="head">
                                <p class="title">訂購明細</p>
                            </div>
                            <div class="main">
                                <div class="amount">
                                    <div class="goods">

                                        <p class="name">{{ $setting->get('page_product_title') }}<br>{{ $goods->category->name }} / {{ $goods->name }}</p>
                                        <p class="price">NT$ {{ number_format(round($goods->price)) }}(含稅)</p>
                                    </div>
                                    <div class="count">
                                        <dl>
                                            <dt>訂購金額：</dt>
                                            <dd><span class="red">NT$ {{ number_format(round($goods->price)) }}</span></dd>
                                        </dl>
                                        <dl>
                                            <dt>配送費：</dt>
                                            <dd><span class="red">NT$ {{ number_format($goods->price>=$freight_where?0:$freight_price) }}</span></dd>
                                        </dl>
                                        <dl>
                                            <dt>包裝費用：</dt>
                                            <dd><span class="red">NT$ 0</span></dd>
                                        </dl>
                                        <dl>
                                            <dt>稅項：</dt>
                                            <dd><span class="red">NT$ 0</span></dd>
                                        </dl>
                                    </div>
                                    <div class="total">
                                        結帳金額：<span class="red">NT$ {{ number_format(round($goods->price>=$freight_where?$goods->price:$goods->price+$freight_price)) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-main">
                            <div class="law">
                                <div class="group">
                                    <input type="checkbox" name="clause1" value="1" id="clause1" checked>
                                    <label for="clause1">我同意遵守{{ $setting->get('manufactor') }}《個人購買{{ $setting->get('site_name') }}說明》條款</label>
                                </div>
                                <div class="group">
                                    <input type="checkbox" name="clause2" value="1" id="clause2" checked>
                                    <label for="clause2">我同意接受{{ $setting->get('manufactor') }}《服務條款》及《客戶隱私保護》條款</label>
                                </div>
                                <div class="group">
                                    <input type="checkbox" name="clause3" value="1" id="clause3" width="50" height="50" checked>
                                    <label for="clause3">為保障彼此之權益，{{ $setting->get('manufactor') }}收到您的訂單後仍保有決定是否接受訂單及出貨與否之權利</label>
                                </div>
                            </div>
                            <button class="btn form-btn"><span>安全送出</span><i class="iconfont">&#xe625;</i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection




