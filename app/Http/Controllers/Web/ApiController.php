<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Services\SitemapService;


class ApiController extends Controller
{

    public function robots(){
        $config = Config::where('name','robots')->first();
        if($config){
            return response($config->content)->header('Content-type','text/plain');
        }else{
            return response('')->header('Content-type','text/plain');
        }
    }

    public function sitemap(){
        $xml = app(SitemapService::class)->generate();
        return response($xml)->header('Content-type','text/xml');
    }
}
