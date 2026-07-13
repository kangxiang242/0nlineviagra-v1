@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/message.css') }}?ver={{ app('cache.config')->get('asset_version') }}"/>

@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('static/js/api.js') }}"></script>
    <script>
        $('.pictures').change(function(){
            var files = event.target.files, file;
            if (files && files.length > 0) {
                // 获取目前上传的文件
                file = files[0];// 文件大小校验的动作
                if(file.size > 1024 * 1024 * 5) {
                    alert('图片大小不能超过 5MB!');
                    return false;
                }
                // 获取 window 的 URL 工具
                var URL = window.URL || window.webkitURL;
                // 通过 file 生成目标 url  获取真实的路径
                var imgURL = URL.createObjectURL(file);
                //用attr将img的src属性改成获得的url
                $(this).next().find('.show-how').attr('src',imgURL);
                $(this).next().addClass('have')
            }
        });

        $('.remove-pic').click(function(){
            $(this).siblings('.show-how').removeAttr('src');
            $(this).parent().removeClass('have')
            $(this).parent().siblings('input').val('')
        })

    </script>
@stop

@section('title-before','商品退換服務')

@section('billboard-title','商品退換服務')


@section('content')

<section class="message-container">

    <div class="side">

        <div class="left-side">
{{--            <div class="head">
                <p class="desc">
                    {!! app('cache.config')->get('page_lianluo_desc') !!}
                </p>
            </div>--}}
            <div class="body">
                <form action="" method="post" onsubmit="return refundStore()" id="refund-form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-main">
                        <div class="form-group">
                            <label>姓名：</label>
                            <input class="form-control" type="text" name="name" placeholder="請輸入訂購人姓名">
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
                            <input class="form-control" type="text" name="phone" placeholder="請輸入訂購人電話">
                        </div>

                        <div class="form-group">
                            <label>服務類型：</label>
                            <select class="form-control" name="type">
                                <option value="1">換貨/補寄</option>
                                <option value="2">退貨及退款</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>理由說明：</label>
                            <textarea class="form-control form-textarea" name="content" id="" cols="30" rows="10" placeholder="如：運輸或宅配過程中造成商品包裝損壞"></textarea>
                        </div>

                        <div class="appendix">
                            <label>附加相片：</label>

                            <div class="atlas">
                                <div class="seat">
                                    <input type="file" class="pictures file_hide" name="pictures[]" id="pictures-1" >
                                    <label class="seize"  for="pictures-1">
                                        <a class="remove-pic" href="javascript:;"><i class="iconfont">&#xeca0;</i></a>
                                        <i class="add-pic iconfont">&#xe620;</i>
                                        <img class="show-how" src="" alt="商品退換服務">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="form-btn">確認送出</button>

                        </div>

                    </div>
                    <p class="protect">此頁面受到reCAPTCHA 保護,並適用<a href="https://policies.google.com/privacy" target="_blank">Google 隱私政策</a>及<a href="https://policies.google.com/terms" target="_blank">服務條款</a></p>
                </form>

            </div>
        </div>

        <div class="right-side">
            <div class="contact">
                <div class="group">
                    <p class="p1">Cambridge, MA</p>
                    <div class="specific">
                        <p class="p2">
                            Eli Lilly and Company
                        </p>
                        <p class="p3">
                            450 Kendall Street<br>
                            Cambridge, MA 02142
                        </p>
                    </div>
                </div>

                <div class="group">
                    <p class="p1">Indianapolis, IN</p>
                    <div class="specific">
                        <p class="p2">
                            Lilly Global Headquarters

                        </p>
                        <p class="p3">
                            Eli Lilly and Company<br>
                            Lilly Corporate Center<br>
                            Indianapolis, IN 46285<br>
                            +1-317-276-2000<br>
                        </p>
                    </div>
                    <div class="specific">
                        <p class="p2">
                            Lilly USA
                        </p>
                        <p class="p3">
                            1500 South Harding Street<br>
                            Indianapolis, IN 46221<br>
                            +1-317-433-1625
                        </p>
                    </div>
                    <div class="specific">
                        <p class="p2">
                            Lilly Technology Center
                        </p>
                        <p class="p3">
                            1200 W. Morris Street<br>
                            Indianapolis, IN 46221<br>
                            +1-317-651-7973
                        </p>
                    </div>
                </div>

                <div class="group">
                    <p class="p1">New Jersey and New York</p>
                    <div class="specific">
                        <p class="p2">
                            Lilly NJ-NY Branchburg Manufacturing Site
                        </p>
                        <p class="p3">
                            33 ImClone Drive<br>
                            Branchburg, NJ 08876
                        </p>
                    </div>

                    <div class="specific">
                        <p class="p2">
                            Lilly NJ-NY Research Center
                        </p>
                        <p class="p3">
                            Alexandria Center for Life Science<br>
                            450 East 29th Street<br>
                            12th Floor<br>
                            New York, NY 10016
                        </p>
                    </div>
                </div>

                <div class="group">
                    <p class="p1">Puerto Rico</p>
                    <div class="specific">
                        <p class="p2">
                            Lilly Puerto Rico
                        </p>
                        <p class="p3">
                            235 Federico Costa Street<br>
                            Parque Las Américas I, Suite 401<br>
                            San Juan, Puerto Rico 00918<br>
                            +1-787-753-7070
                        </p>
                    </div>

                    <div class="specific">
                        <p class="p2">
                            Lilly del Caribe, Inc.
                        </p>
                        <p class="p3">
                            400 Calle Fabril<br>
                            Carolina, Puerto Rico 00987<br>
                            +1-787-257-5555
                        </p>
                    </div>
                </div>

                <div class="group">
                    <p class="p1">San Diego, CA</p>
                    <div class="specific">
                        <p class="p2">
                            Lilly Biotechnology Center San Diego
                        </p>
                        <p class="p3">
                            10290 Campus Point Drive<br>
                            San Diego, CA 92121<br>
                            +1-858-597-4990
                        </p>
                    </div>
                </div>

                <div class="group">
                    <p class="p1">Washington, DC</p>
                    <div class="specific">
                        <p class="p2">
                            Eli Lilly and Company
                        </p>
                        <p class="p3">
                            555 Twelfth Street NW<br>
                            Suite 650 South<br>
                            Washington, DC 20004<br>
                            +1-202-434-1015
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
