<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProcessOrderStatusRequest;
use App\Http\Requests\ProcessOrderDeliveryRequest;
use App\Http\Requests\ProcessPaymentViaAdminRequest;
use App\Models\Order;
use App\Services\OrderProcessingService;

class OrderProcessingController extends Controller
{
    private $processor;
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     * @return void
     */
    public function __construct(OrderProcessingService $processor)
    {   
        $this->processor = $processor;
    }

    /**
     * Show the forms for processing the specified order
     * @param App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order->load('payment');
        $order->load('delivery');
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update order status in DB 
     * @param App\Http\Requests\ProcessOrderStatusRequest $request
     * @param  App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function processStatus(ProcessOrderStatusRequest $request, Order $order)
    {
            $this->processor->handleStatus($order);
            session()->flash('success_message', 'Order Status Changed Successfuly.');
            return response()->json([
                'message' => 'Order Status Updated',
                'new_status' => $order->status
                ]
            );
    }

    /**
     * Update the order delivery status in DB
     * @param App\Http\Requests\ProcessOrderDeliveryRequest $request
     * @param  App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function processDelivery(ProcessOrderDeliveryRequest $request, Order $order)
    {
        $this->processor->handleDelivery($order);
        session()->flash('success_message', 'Delivery Status Changed Successfuly.');
        return response()->json([
            'message' => 'Delivery Status Updated', 
            'new_status' => $order->delivery->delivery_status]
        );
    }

    /**
     * Process on_delivery payment as administrator
     * @param App\Http\Requests\ProcessPaymentViaAdminRequest $request
     * @param  App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function processPayment(ProcessPaymentViaAdminRequest $request, Order $order){
        $this->processor->handlePayment($order);
        session()->flash('success_message', 'Payment Processes Successfuly.');
        return response()->json(['message' => 'Payment Successful']);
    }

}
