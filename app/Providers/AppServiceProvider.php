<?php
namespace App\Providers;

use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FaqRepository;
use App\Repositories\NavigationRepository;
use App\Repositories\PageRepository;
use App\Repositories\SeoRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('site.setting', function () {
            return new \App\Repositories\ConfigRepository();
        });
    }

    public function boot(): void
    {
        // 注册 web view 命名空间
        View::addNamespace('web', resource_path('views/web'));

        View::composer(['web::*'], function ($view) {
            $view->with('setting', $this->app['site.setting']);
            $view->with('mate', app(SeoRepository::class)->current());
            $view->with('navigations', app(NavigationRepository::class)->all());
            $view->with('banner', app(BannerRepository::class)->current());
            $view->with('categorys', app(CategoryRepository::class)->all());
            $view->with('page', app(PageRepository::class)->current());
            $view->with('faqs', app(FaqRepository::class)->all());
        });
    }
}
