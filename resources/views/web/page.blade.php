@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('static/less/page.css') }}"/>

@stop

@section('script')
    @parent



@stop
@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">首頁</a></li>
        <li class="active">{{ $page->title }}</li>
    </ul>
@stop
@section('title',$page->title)
@section('billboard-title',$page->title)
@section('billboard-desc',$page->desc)
@section('content')
    <div class="page-container">{!! $page->content !!}</div>
@endsection
