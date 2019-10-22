<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;

use Session;
use App\Order;
use App\Product;
use App\OrderProduct;
use App\Coupon;
use App\Mail\OrderReceived;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{    
    /**
     * Display the checkout page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // if there are no products in cart, redirect to shopping page
        if(Cart::instance('default')->count() == 0){
            return redirect()->route('shop.index');
        }

        // if a user is logged in and is going to guestCheckout, redirect to logged in users checkout
        if(auth()->user() && request()->is('guestCheckout')){
            return redirect()->route('checkout.index');
        }

        // display the checkout page
        return view('checkout')->with([
            'discount' => $this->getTotals()->get('discount'),
            'newSubtotal' => $this->getTotals()->get('newSubtotal'),
            'newTax' => $this->getTotals()->get('newTax'),
            'newTotal' => $this->getTotals()->get('newTotal'),
        ]);
    }

    /**
     * Process the checout request, save order in DB
     * @param App\Http\Requests\CheckoutRequest $request (request with validation rules);
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {   
        //check product availability before sale
        if($this->notAvailable()){
            return back()->withErrors('Sorry, one of the products in your cart is sold out.');
        } 
        //save order in db
        try{
            $order = $this->saveNewOrder($request, false, null);
            
            //send customer an email with order confirmation
            Mail::queue(new OrderReceived($order));
            
            //adjust sold products availability in DB
            $this->adjustProductAvailability();

            //clear cart and coupon sessions
            Cart::instance('default')->destroy();
            session()->forget('coupon');
    
            //Redirect to order confirmation page with success message
            return redirect()->route('confirmation.index')->with('success_message','Thank you. Your order has been successful.');
        }catch(Exception $e){
            return back()->withErrors('Order Failed! Error: '.$e->getMessage());
        }
    }

    /**
     * Protected Checkout Helper method: Save an order in database
     * @param  \Illuminate\Http\Request  $request
     * @param bool paid - specified if order was paid for or not(boolean), defaults to false
     * @param bool error - order placement errors if any, defaults to false
     * @return object Order class 
     */
    protected function saveNewOrder($request, $paid = false, $error = false){
        // Get Payment Gateway
        $paymentGateway = Order::paymentGateway();
        //Insert order into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'order_nr' => uniqid(),
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_region' => $request->region,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'coupon_discount_amount' => $this->getTotals()->get('discount'),
            'coupon_discount_code' => $this->getTotals()->get('code'),
            'billing_subtotal' => $this->getTotals()->get('newSubtotal'),
            'billing_tax' => $this->getTotals()->get('newTax'),
            'billing_total' => $this->getTotals()->get('newTotal'),
            'paid' => $paid,
            'payment_type' => ($paid === true) ? 'card' : 'cash',
            'payment_gateway' => ($paid === true) ? $paymentGateway : null,
            'payment_date' => ($paid === true) ? formatDateForDB(time()) : null,
            'error' => $error,
        ]);
        //Insert into order_products table
        foreach(Cart::instance('default')->content() as $item){
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'item_price' => $item->model->price,
                'quantity' => $item->qty,
            ]);
        }
        return $order;
    }

    /**
     * Private Checkout Helper method  - counts cart totals with tax and discounts if applicable
     * @return collection of cart totals
     */
    private function getTotals()
    {
        $code = session()->get('coupon')['name'] ?? null;

        //define total calculations
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        if(Cart::instance('default')->subtotal() > $discount){
            $newSubtotal = (Cart::instance('default')->subtotal() - $discount);
        }else{
            $newSubtotal = 0;
        }
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);
        return collect([
            'code' => $code,
            'tax' => $tax,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' =>  $newTotal,
        ]);
    }

    /**
    * Protected Checkout Helper Method: Check product availability before checkout
    * @return bool true if any product in the cart has no availability, false otherwise
    */
    protected function notAvailable(){
         foreach(Cart::instance('default')->content() as $item){
            $product = Product::find($item->model->id);
            if($product->availability < $item->qty){
                return true;
            }
         }
         return false;
    }

     /**
     * Protected Checkout Helper Method: Adjust sold products availability in db after checkout
     * @return void
     */
    protected function adjustProductAvailability(){
        foreach(Cart::instance('default')->content() as $item){
            $product = Product::find($item->model->id);
            $newAvailability = $product->availability - $item->qty;
            $product->update(['availability' => $newAvailability]);
        }
    }
}
