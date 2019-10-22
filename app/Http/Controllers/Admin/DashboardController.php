<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Products;
use DB;

class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     * Set the middleware
     *
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
    }

    /**
     * Show the application admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageCount = DB::table('pages')->count();
        $catCount = DB::table('categories')->count();
        $brandCount = DB::table('brands')->count();

        $productCount =  DB::table('products')->count();
        $reviewCount = DB::table('reviews')->count();
        $userCount = DB::table('users')->count();
        $adminCount = DB::table('admins')->count();

        $orderCount = DB::table('orders')->count();
        $completedOrderCount = DB::table('orders')->where('order_status', 2)->count();
        $inProcessOrderCount = DB::table('orders')->where('order_status', '!=' ,2)->count();

        $totalSales = DB::table('orders')->sum('billing_total');
        $totalSalesPaid = DB::table('orders')->where('paid', 1)->sum('billing_total');
        $totalSalesUnpaid = DB::table('orders')->where('paid', 0)->sum('billing_total');

        $avgOrderAmount = DB::table('orders')->avg('billing_total');

        return view('admin.dashboard')->with([
            'pages' => $pageCount,
            'categories' => $catCount,
            'brands' => $brandCount,
            'products' => $productCount,
            'reviews' => $reviewCount,
            'users' => $userCount,
            'admins' => $adminCount,
            'orders' => $orderCount,
            'ordersComplete' => $completedOrderCount,
            'ordersInProcess' => $inProcessOrderCount,
            'totalSales' => $totalSales,
            'totalSalesPaid' => $totalSalesPaid,
            'totalSalesUnpaid' => $totalSalesUnpaid,
            'avgOrderAmount' => $avgOrderAmount,
        ]);
    }
}
