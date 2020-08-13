<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Models\Order;


class OrdersController extends Controller
{
    private $orderService;
    /**
     * Create a new controller instance.
     * Inject service class
     * @return void
     */
    public function __construct(OrderService $service)
    {   
       $this->orderService = $service;
    }

    /**
     * Display a listing of all active orders/filtered active orders
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->orderService->getFiltered('active');
        return view('admin.orders.index')->with([
            'orders'=> $data['orders'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }
 
    /**
     * Display a listing of all completed orders/filtered completed orders
     * @return \Illuminate\Http\Response
     */
    public function completeOrders(){
        $data = $this->orderService->getFiltered('complete');
        return view('admin.orders.complete')->with([
            'orders'=> $data['orders'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }

    /**
     * Display the specified order.
     * @param  App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {   
        $order = $this->orderService->formatOne($order);
        return view('admin.orders.show')->with('order', $order);
    }
 
}
