@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/goods.css') }}?ver={{ app('cache.config')->get('asset_version') }}"/>


@stop

@section('script')
    @parent
    <script>
        $('.accordion-header .a-title').click(function(){

            if($(this).parents('.accordion').hasClass('open')){

                $(this).parents('.accordion').removeClass('open')

            }else{
                $(this).parents('.accordion').addClass('open')
            }



        })

        $('.accordion').each(function(){
            var height = $(this).find('.accordion-content').outerHeight();
            $(this).css('--height',height+"px")
            $(this).removeClass('open')
        })

        $('.view-all').click(function(){
            if(!$(this).attr('data-close')){
                $('.accordion').removeClass('open');
                $(this).attr('data-close',1)
                $(this).text('查看所有部分');
            }else{
                $('.accordion').addClass('open');
                $(this).removeAttr('data-close')
                $(this).text('隱藏所有部分');
            }
        });

        $('a').click(function(){
            var anchor = $(this).attr('href');

            if(anchor){

                anchorShowSection(anchor);
                return false;

            }

        });

        function anchorShowSection(anchor){
            anchor = anchor.replace('#','')
            var anchor_elem = $("a[name='"+anchor+"']");
            var parent_elem = $("a[name='"+anchor+"']").parents('.accordion');

            if(parent_elem){
                parent_elem.addClass('open');
                var current = anchor_elem.offset().top;
                $("html,body").stop().animate({
                    scrollTop: current
                }, 300);
            }


        }

        function GetRequest() {
            var str = location.href
            var num = str.indexOf("#");
            str = str.substr(num + 1);
            return str;
        }

        anchorShowSection(GetRequest());
    </script>
@stop
@section('banners')@stop
@section('footer')@stop
@section('header')@stop
@section('breadcrumb')
    <ul class="breadcrumb" style="display: none">
        <li><a href="{{ URL::to('/') }}">首頁</a></li>
        <li><a href="{{ URL::to('product') }}">訂購威而鋼</a></li>
        <li class="active">處方訊息</li>
    </ul>
@stop

@section('content')

@endsection
