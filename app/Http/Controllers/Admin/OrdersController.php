<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Custom Validator
use App\Http\Requests\ProcessOrderRequest;

use App\Order;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of all orders/filtered orders
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //orders with filters
        $filterName = "";
        $searchName = "";

        if(isset($request->ordernr)){
            $orders = Order::where('order_nr', request()->ordernr)->paginate(10);
            $searchName = 'ordernr';

        }elseif(isset($request->name)){
            $orders = Order::where('billing_name', 'like', '%'.$request->name.'%' )->orderBy('created_at', 'DESC')->paginate(10);
            $searchName = 'name';

        }elseif(isset($request->orderstatus)){
            $orders = Order::where('order_status', $request->orderstatus)->orderBy('created_at', 'DESC')->paginate(10);
            $filterName = 'orderstatus';

        }elseif(isset($request->paymentstatus)){
            $orders = Order::where('paid', $request->paymentstatus)->orderBy('created_at', 'DESC')->paginate(10);
            $filterName = 'paymentstatus';

        }elseif(isset($request->deliverystatus)){
            $orders = Order::where('delivered', $request->deliverystatus)->orderBy('created_at', 'DESC')->paginate(10);
            $filterName = 'deliverystatus';
        }
        else{
            $orders = Order::orderBy('order_status', 'ASC')->paginate(10);
        }
        
        return view('admin.orders.index')
        ->with('orders', $orders)
        ->with('filterName', $filterName)
        ->with('searchName', $searchName);
    }
 
    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $order = Order::where('id', $id)->with(['products' => function($query){
            $query->withTrashed();
          }])->first();

        return view('admin.orders.show')->with('order', $order);
    }

    /**
     * Show the form for processing the specified order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $orderStatuses = $order->orderStatuses();
        return view('admin.orders.edit')->with('order', $order)->with('orderStatuses', $orderStatuses);
    }

    /**
     * Update the specified order in DB - order processing.
     *
     * @param App\Http\Requests\ProcessOrderRequest $request (request with validation rules)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessOrderRequest $request, $id)
    {
        $order = Order::find($id); 
        /*Complete Order Validation: in order for order status to be set as complete, 
        order payment status must be set to paid and order delivery status must be set to delivered
        */ 
        if($request->order_status == 2){
            if($order->paid == 0 && $request->paid != 1){
                return back()
                ->withErrors('Order status cannot be set to "Completed" while payment status in not "Paid".')
                ->withInput();
            }
            if($order->delivered == 0 && $request->delivered != 1){
                return back()
                ->withErrors('Order status cannot be set to "Completed" before the delivery status is "Delivered".')
                ->withInput();
            }
        }
        //order status can only be set to delivered if payment status is paid
        if($request->delivered == 1 && $order->paid == 0 && $request->paid != 1){
            return back()
            ->withErrors('Product delivery status cannot be set to "Delivered" if payment status is not "Paid".')
            ->withInput();
        }
       
        $order->order_status = $request->order_status;
        $order->delivered = $request->delivered;
        if($request->filled('paid')){
        $order->paid = $request->paid;
          if($request->paid == 1){
            $order->payment_type = $request->payment_type;
            $order->payment_date = formatDateForDB($request->payment_date);
          }
        }
        $order->save();
        return back()->with('success_message', 'Order Changes Saved.');
    }

    /**
     * Return order status data
     */
    public function orderSatuses(Request $request){
        if (!$request->wantsJson()) {
            return redirect()->route('admin.orders');
         }

        $order = new Order();
        $data = [];
        $data['orderStatuses'] = $order->orderStatuses();
        $data['paymentStatuses'] = $order->orderPaymentStatuses();
        $data['deliveryStatuses'] = $order->orderDeliveryStatuses();
        return response()->json($data);
    }

}
