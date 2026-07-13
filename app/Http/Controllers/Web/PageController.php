<?php


namespace App\Http\Controllers\Web;


use App\Models\Page;
use App\Repositories\ArticleCategoryRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    private CategoryRepository $categoryRepository;

    private ArticleCategoryRepository $articleCategoryRepository;

    private NewsRepository $newsRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ArticleCategoryRepository $articleCategoryRepository,
        NewsRepository $newsRepository
    )
    {
        $this->categoryRepository = $categoryRepository;

        $this->articleCategoryRepository = $articleCategoryRepository;

        $this->newsRepository = $newsRepository;
    }

    public function any($uri){

    }

    public function index($uri,Request $request){


        $articleCate = $this->articleCategoryRepository->all()->where('uri',$uri)->first();
        if($articleCate){
            return $this->article($articleCate);
        }


        $category = $this->categoryRepository->all()->where('uri',$uri)->first();
        if($category){
            return $this->product($category);
        }

        $news = $this->newsRepository->model()->where('uri','/'.$uri)->where('status',1)->first();
        if($news){
            return $this->articleShow($news);
        }



        $page = Page::where('uri',trim($uri))->where('status',1)->first();
        if(!$page){
            abort(404);
        }

        return view('web::page',compact('page'));
    }

    public function show($uri,$id){

        $articleCate = $this->articleCategoryRepository->all()->where('uri',$uri)->first();
        if($articleCate){
            return $this->articleShow($articleCate,$id);
        }


    }

    protected function product($category){
        $news = $this->newsRepository->all();
        return view('web::product.index',compact('category','news'));

    }

    protected function article($articleCate){
        $news = $this->newsRepository->model()->where('article_cate_id',$articleCate->id)->where('status',1)->orderBy('sort','desc')->get();

        return view('web::news.index')->with('news',$news)->with('cate',$articleCate);
    }

    protected function articleShow($news){

        $next = $this->newsRepository->getNext($news->id);
        $prev = $this->newsRepository->getPrev($news->id);

        $news->release_at = \Carbon\Carbon::parse($news->release_at);

        $recommend = $this->newsRepository->all()->where('article_cate_id',$news->article_cate_id)->shuffle()->take(6);

        return view('web::news.show',compact('news','next','prev','recommend'));

    }


    public function faq(){
        return view('web::faq');
    }


}
