@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/order.css') }}"/>

@stop
@section('title','訂單詳情')
@section('script')
    @parent
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script>
        if(flash_data){
            Swal.fire({
                title: flash_data.msg,
                text: flash_data.sub_msg,
                icon: 'success',
                confirmButtonText: '我知道了'
            })
        }

    </script>
@stop
@section('banners')@stop

@section('footer')@stop
@section('header')@stop

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
    <div class="container" style="padding-bottom: 100px">
        <div class="wrapper ">
            <div class="order">

                <div class="ordertable">
                    <div class="item">
                        <label><span>訂單號</span></label>
                        <div class="conta">{{ $order->no }}</div>
                    </div>

                    <div class="item">
                        <label><span>下單時間</span></label>
                        <div class="conta">{{ $order->created_at }}</div>
                    </div>

                    <div class="item">
                        <label><span>訂單狀態</span></label>
                        <div class="conta">{{ \Illuminate\Support\Arr::get(\App\Models\Order::STATUS_TXT,$order->status) }}</div>
                    </div>

                    <div class="item">
                        <label><span>訂購人</span></label>
                        <div class="conta">{{ $order->name }}</div>
                    </div>

                    <div class="item">
                        <label><span>訂購電話</span></label>
                        <div class="conta">{{ $order->phone }}</div>
                    </div>

                    <div class="item">
                        <label><span>訂購信箱</span></label>
                        <div class="conta">{{ $order->email }}</div>
                    </div>

                    <div class="item">
                        <label><span>購物商品</span></label>
                        <div class="conta">
                            @foreach($order->products as $item)
                                <div class="shopitem">

                                    <div class="shopMsg">
                                        <span class="name">{{ $setting->get('page_product_title') }} / {{ $item->product_name }}</span>
                                        <span>× {{ $item->number }}</span>
                                        <span>NT${{ number_format(round($item->total_price)) }}</span>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <div class="item">
                        <label><span>配送方式</span></label>
                        <div class="conta">{{ $order->delivery_type?"超商(7-11) 取貨付款":"快遞宅配 貨到付款" }}</div>
                    </div>

                    <div class="item">
                        <label><span>訂單總價</span></label>
                        <div class="conta">NT${{ number_format(round($order->total_price)) }}（{{ $order->freight>0?"含運費$".number_format(round($order->freight)):"免運費" }}）</div>
                    </div>

                    @if($order->delivery_type > 0)
                        <div class="item">
                            <label><span>門市</span></label>
                            <div class="conta">
                                {{ $order->shop_no }}{{ $order->shop_name }}
                            </div>
                        </div>
                    @endif
                    <div class="item">
                        <label><span>地址</span></label>
                        @if($order->delivery_type > 0)
                            <div class="conta">{{ $order->address }}</div>
                        @else
                            <div class="conta">{{ $order->city.$order->county.$order->street.$order->address }}</div>
                        @endif
                    </div>


                    <div class="item">
                        <label><span>訂單備註</span></label>
                        <div class="conta">{{ $order->remarks?:"無" }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
