<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Models\Order;

class OrdersController extends Controller
{
    private $orderService;
    /**
     * Create a new controller instance.
     * Instantiate service class passing pagination
     * @return void
     */
    public function __construct()
    {   
       $this->orderService = new OrderService(5);
    }

    /**
     * Show all autheniticated user's orders divided into active and complete
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentOrders = $this->orderService->getUsersOrders('active');
        $previousOrders = $this->orderService->getUsersOrders('complete');
        return view('users.orders', compact('currentOrders','previousOrders'));
    }

    /**
     * Show orders details (order must belong to autheniticated user)
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {   
        if(!$order->isOwner()){
            abort(403, 'Unauthorized Access');
        }
        $order = $this->orderService->formatOne($order);
        return view('users.order', compact('order'));
    }

}
