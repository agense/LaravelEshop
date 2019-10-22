<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

//Pagination
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

//Shared Views
use View;
use App\Setting;
use App\Category;
use App\Brand;
use App\Page;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //define default string length for varchar fields
        Schema::defaultStringLength(191);

        /**
         * Pagination for a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        //Shared Views
        View::share('settings', Setting::settings());
        View::share('categoryList', Category::whereHas('products')->get()->pluck('slug', 'name'));
        View::share('brandList', Brand::whereHas('products')->get()->pluck('slug', 'name'));
        View::share('standardPageList', Page::where('type', 'standard')->get()->pluck('slug', 'title'));
        View::share('termPageList', Page::where('type', 'terms')->get()->pluck('slug', 'title'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
