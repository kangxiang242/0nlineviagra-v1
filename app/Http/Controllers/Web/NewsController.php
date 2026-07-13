<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Anchor;
use App\Models\ArticleCate;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function index(Request $request){

        $uri = $request->route()->uri;

        $cate = ArticleCate::whereUri($uri)->where('status',1)->first();

        if(!$cate){
            abort(404);
        }

        //$news = $this->newsRepository->model()->where('article_cate_id',$cate->id)->where('status',1)->orderBy('sort','desc')->get();

        $news = $this->newsRepository->all();



        return view('web::news.index')->with('news',$news)->with('cate',$cate);
    }


    public function show($id){

        $news = $this->newsRepository->find(intval($id));

        if(!$news){
            abort(404);
        }

        $next = $this->newsRepository->getNext($id);
        $prev = $this->newsRepository->getPrev($id);

        $news->release_at = \Carbon\Carbon::parse($news->release_at);

        $recommend = $this->newsRepository->all()->where('article_cate_id',$news->article_cate_id)->shuffle()->take(6);

        return view('web::news.show',compact('news','next','prev','recommend'));

    }
}
