@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('static/less/news.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ assetv('static/less/pagination.css') }}"/>
@stop

@section('script')
    @parent

@stop
@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">首頁</a></li>
        <li class="active">{{ $cate->name }}</li>
    </ul>
@stop

@section('title-before',$cate->name)

@section('billboard-title',$cate->name)

@section('billboard-desc',$cate->desc)

@section('content')
    <div class="news">
        @foreach($news as $item)
            <div class="news-item">
                <a href="{{ $item->uri }}" title="閱讀 {{ $item->title }}全部內容">
                    <img class="news-image" src="{{ storage_url($item->img) }}" loading="lazy" alt="{{ $item->title }}">
                    <p class="news-title">{{ $item->title }}</p>
                    <p class="news-desc">{{ $item->brief }}</p>
                    <span class="more text-underline">閱讀全文</span>
                </a>
            </div>
        @endforeach
        {{--<div class="pagination">
            {!! $news->links() !!}
        </div>--}}
    </div>
@endsection
