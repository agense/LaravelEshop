<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Page;
use App\Models\Feature;
use App\Models\DiscountCode;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\Order;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Sets shared data for views
     * @return void
     */
    public function boot()
    {
        //Settings
        if(Schema::hasTable('settings')){
            View::share('settings', Setting::settings());
        }

        //Categories
        if(Schema::hasTable('categories')){
            view()->composer(
                ['partials.forms.fields.categories-checkboxes', 
                'partials.forms.filter_forms.products-filter-form' 
            ],
            function($view){
                $view->with('categories', Category::all(['id', 'name', 'slug']));
            });

            view()->composer(
                ['partials.navigations.navbar', 
                'shop.shop'
            ],
            function($view){
                $view->with('categories', Category::whereHas('products')->select(['id', 'name', 'slug'])->get());
            });
        }

        //Brands
        if(Schema::hasTable('brands')){
            view()->composer([
                'partials.forms.fields.brand-select', 
                'shop.shop', 
                'partials.forms.filter_forms.products-filter-form'
            ], function($view){
                $view->with('brands', Brand::all(['id', 'name', 'slug']));
            });

            view()->composer(['shop.shop'], function($view){
                $view->with('brands', Brand::whereHas('products')->select(['id', 'name', 'slug'])->get());
            });
        }

        //Products
        if(Schema::hasTable('features')){
            view()->composer(['partials.forms.product-form', 'shop.shop'], function($view){
                $view->with('features', Feature::all());
            });
        }
        

        //Pages
        if(Schema::hasTable('pages')){
            view()->composer(['partials.footer'], function($view){
                $view->with('pages', Page::all(['id','slug','title', 'type']));
            });
        }
        view()->composer(['partials.forms.fields.page-type-select'], function($view){
            $view->with('pageTypes', Page::getTypes());
        });
        
        //Discount Codes
        view()->composer(['partials.forms.discountcode-form'], function($view){
            $view->with('discountCodeTypes', DiscountCode::getTypes());
        });

        //Administrators
        view()->composer(['partials.forms.admin-form'], function($view){
            $view->with('adminRoles', Admin::adminRoles());
        });

        //Payments
        view()->composer(['partials.forms.checkout-form'], function($view){
            $view->with('paymentOptions', optionList(Payment::paymentOptions()))
            ->with('deliveryOptions', optionList(Delivery::deliveryOptions()));
        });

        view()->composer(['partials.forms.order-payment-processing-form'], function($view){
            $view->with('paymentMethods', optionList(Payment::paymentMethodsForUnpaidOrders()));
        });

        //Orders
        view()->composer(['partials.forms.order-status-processing-form'], function($view){
            $view->with('orderStatusOptions', optionList(Order::orderStatuses()));
        });
        view()->composer(['partials.forms.order-delivery-processing-form'], function($view){
            $view->with('deliveryStatusOptions', optionList(Delivery::deliveryStatuses()));
        });
        view()->composer(['partials.forms.filter_forms.orders-active-filter-form'], function($view){
            $filters = [];
            $filters['order_status'] = optionList(Order::activeStatuses());
            $filters['payment_status'] = optionList(Payment::paymentStatuses());
            $view->with('filterOptions', $filters);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
