<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

//Pagination
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;
use App\Observers\ProductObserver;

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

        /*
        // Request Query Helper - checks if request query is empty excluding the pagination 
        */
        Request::macro('isFilterable', function () {
            if(empty(request()->query()) || ((count(request()->query())) == 1 && array_keys(request()->query())[0] == 'page')){
                return false;
            }
            return true;
        });

        /*
        // Request Query Helper - checks if request query has 'sort' parameter
        */
        Request::macro('isSortable', function () {
            return array_key_exists('sort', request()->query());
        });

        // OBSERVERS
        Product::observe(ProductObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckoutService::class, function($app) {
            return new CheckoutService(); 
        });

    }
}
