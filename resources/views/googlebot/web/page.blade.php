@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/page.css') }}"/>

@stop

@section('script')
    @parent



@stop
@section('breadcrumb')
    <nav aria-label="Breadcrumb">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('/') }}">首頁</a></li>
            <li class="active">{{ $page->title }}</li>
        </ul>
    </nav>
@stop
@section('title',$page->title)
@section('billboard-title',$page->title)
@section('billboard-desc',$page->desc)
@section('content')
    <div class="page-container">{!! $page->content !!}</div>
@endsection
