@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/message.css') }}"/>

@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('static/js/api.js') }}"></script>



@stop


@section('billboard-title','聯絡我們')
@section('billboard-desc',$setting->get('manufactor').'致力於為我們的客戶提供資訊。若您有疑問，請聯絡我們。')

@section('content')
<section class="message-container">
    <p class="desc">{!! $setting->get('page_lianluo_desc') !!}</p>
    <form action="" method="post" onsubmit="return messageStore()" id="message-form">
        {{ csrf_field() }}
        <div class="form-main">
            <div class="form-group">
                <label>姓名：</label>
                <input class="form-control" type="text" name="name" placeholder="請輸入你的稱呼">
            </div>
            <div class="form-group">
                <label>性別：</label>
                <div class="option">
                    <div class="checkbox">
                        <input type="radio" class="form-radio" id="sex-0" name="sex" value="0" checked>
                        <label class="checked-label" for="sex-0">
                            <span class="dress"></span>
                            <span class="text">不透露</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <input type="radio" class="form-radio" id="sex-1" name="sex" value="1" >
                        <label class="checked-label" for="sex-1">
                            <span class="dress"></span>
                            <span class="text">先生</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <input type="radio" class="form-radio" id="sex-2" name="sex" value="2" >
                        <label class="checked-label" for="sex-2">
                            <span class="dress"></span>
                            <span class="text">女士</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>聯絡電話：</label>
                <input class="form-control" type="text" name="phone" placeholder="請輸入聯絡你的電話號碼">
            </div>
            <div class="form-group">
                <label>E-mail：</label>
                <input class="form-control" type="text" name="email" placeholder="請輸入聯絡你的電子郵箱">
            </div>
            <div class="form-group">
                <label>留言類型：</label>
                <select class="form-control" name="type">
                    <option value="1">售前咨詢</option>
                    <option value="2">劑量咨詢</option>
                    <option value="3">修改訂單資訊</option>
                    <option value="5">意見或建議</option>
                    <option value="6">退換貨</option>
                    <option value="0" selected>其它</option>
                </select>
            </div>

            <div class="form-group">
                <label>留言內容：</label>
                <textarea class="form-control form-textarea" name="content" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <button class="form-btn">確認送出</button>

            </div>

        </div>
        <p class="protect">此頁面受到reCAPTCHA 保護,並適用<a href="https://policies.google.com/privacy" target="_blank">Google 隱私政策</a>及<a href="https://policies.google.com/terms" target="_blank">服務條款</a></p>
    </form>
</section>
@endsection
