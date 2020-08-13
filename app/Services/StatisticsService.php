<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\Page;
use App\Models\Admin;
use App\Models\User;
use App\Models\Feature;
use App\Models\DiscountCode;

class StatisticsService
{
    /**
     * Returns an array of combined app statistics
     * @return Array
     */
    public function getDashboardStatistics(){
        $data = [];
        $data['app_info'] = $this->getGeneralAppStatistics();
        $data['order_totals'] = $this->getOrderStatistics();
        $data['promotions'] = $this->getPromotionStatistics();
        $data['reviews'] = $this->getReviewStatistics();
        return $data;
    }

    /**
     * Returns an object of general app statistics
     * @return Object (standard class object)
     */
    public function getGeneralAppStatistics(){
        $info = new \stdClass();
        $info->pages = Page::count();
        $info->categories = Category::count();
        $info->brands = Brand::count();
        $info->product_features = Feature::count();
        $info->products = Product::count();
        $info->featured_products = Product::Featured()->count();
        $info->users = User::count();
        $info->admins = Admin::count();
        return $info;
    }

    /**
     * Returns an object of order statistics
     * @return Object (standard class object)
     */
    public function getOrderStatistics(){
        $orderTotals = new \stdClass();
        $orderTotals->total_orders = Order::count();
        $orderTotals->orders_complete = Order::completeOrders()->count();
        $orderTotals->orders_in_process = Order::activeOrders()->count();
        $orderTotals->total_sales = monetaryDisplay(Order::sum('billing_total'));
        $orderTotals->total_sales_paid = monetaryDisplay(Order::paidOrders()->sum('billing_total'));
        $orderTotals->total_sales_unpaid = monetaryDisplay(Order::unpaidOrders()->sum('billing_total'));
        $orderTotals->average_order_amount = monetaryDisplay(Order::avg('billing_total'));
        return $orderTotals;
    }

    /**
     * Returns an object of promotions statistics
     * @return Object (standard class object)
     */
    public function getPromotionStatistics(){
        $promotions = new \stdClass();
        $promotions->active_discount_codes = DiscountCode::Active()->count();
        $promotions->future_discount_codes = DiscountCode::Future()->count();
        $promotions->expired_discount_codes = DiscountCode::Expired()->count();
        return $promotions;
    }

    /**
     * Returns an object of review statistics
     * @return Object (standard class object)
     */
    public function getReviewStatistics(){
        $reviews = new \stdClass();
        $reviews->total_active = Review::count();
        $reviews->deleted_reviews = Review::onlyTrashed()->count();
        $reviews->ratings = [
                1 => Review::Rating(1)->count(),
                2 => Review::Rating(2)->count(),
                3 => Review::Rating(3)->count(),
                4 => Review::Rating(4)->count(),
                5 => Review::Rating(5)->count(),
        ];
        return $reviews;
    }

}