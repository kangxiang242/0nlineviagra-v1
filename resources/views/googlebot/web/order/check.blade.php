@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/check.css') }}"/>
@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script src="{{ assetv('gb-static/js/api.js') }}"></script>


@stop
@section('title-before','訂單追蹤')
@section('billboard-title','訂單追蹤')


@section('content')
    <section class="check-container">
        <form action="" id="check-form" method="post" onsubmit="return orderCheck()">
            {{ csrf_field() }}
            <div class="form-group">
                <label>訂購人姓名：</label>
                <input class="form-control" type="text" name="name" placeholder="">
            </div>
            <div class="form-group">
                <label>訂購電話：</label>
                <input class="form-control" type="tel" name="phone" placeholder="">
            </div>
            <div class="form-group">
                <label>訂單編號：</label>
                <input class="form-control" type="text" name="no" placeholder="">
            </div>

            <div class="form-group">
                <button type="submit" class="form-btn">送出</button>
            </div>
        </form>
        <p class="protect">此頁面受到reCAPTCHA 保護,並適用<a href="https://policies.google.com/privacy" target="_blank">Google 隱私政策</a>及<a href="https://policies.google.com/terms" target="_blank">服務條款</a></p>
    </section>
@endsection
