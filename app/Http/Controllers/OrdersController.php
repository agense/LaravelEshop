<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance and assign middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all autheniticated user's orders
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Current Orders (not yet completed)
        $currentOrders = auth()->user()->orders()->Where('order_status','!=',2)->orderBy('created_at', 'DESC')
        ->with(['products' => function($query){
            $query->withTrashed();
          }])->paginate(5);

        //Previous Orders (compeleted orders)
        $prevOrders = auth()->user()->orders()->Where('order_status',2)->orderBy('created_at', 'DESC')
        ->with(['products' => function($query){
            $query->withTrashed();
          }])->paginate(3);

        return view('users.orders')->with('currentOrders', $currentOrders)->with('previousOrders', $prevOrders);
    }

    /**
     * Show orders details (order must belong to autheniticated user)
     * @param  Order Object
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {   
        if(auth()->id() != $order->user_id){
           return back()->withErrors('You do not have access to page requested.');
        }
        //get order products
        $products = $order->products()->withTrashed()->get();
        return view('users.order')->with('order', $order)->with('products', $products);
    }

}
