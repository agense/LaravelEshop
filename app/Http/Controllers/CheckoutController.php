<?php

namespace App\Http\Controllers;
use App\Exceptions\UnrecoverableOrderFailureException;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use App\Services\CartService;
use App\Services\CartTotalsService;
use App\Events\NewOrderCreatedEvent;
use App\Models\User;
use App\Models\Order;

class CheckoutController extends Controller
{    
    private $cart;
    private $cartTotals;

    public function __construct(CartService $cart, CartTotalsService $cartTotals)
    {
        $this->cart = $cart;
        $this->cartTotals = $cartTotals;
    }
    /**
     * Display the checkout page
     * Check if all products are available in quantities requested before sale.
     * Updates cart and issues a notification if unavailable products or quantities exist
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // if a user is logged in and is going to guest checkout, redirect to logged in users checkout
        if(auth()->user() && request()->is('checkout/guest')){
            return redirect()->route('checkout.index');
        }
        $this->cart->confirmQuantities();

        if($this->cart->isEmpty()){
            return redirect()->route('cart.index');
        }
        return view('shop.checkout')->with([
            'cart' => $this->cart->getCart(),
            'totals' => $this->cartTotals->getTotals(),
            'user' => auth()->user() ?? new User(),
        ]);

    }

    /**
     * Process the checout request, save order in DB
     * @param App\Http\Requests\CheckoutRequest $request (request with validation rules);
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request, CheckoutService $checkout)
    {   
        // Create order
        $order = $checkout->createNewOrder();

        event(new NewOrderCreatedEvent($order));

        return redirect()->route('checkout.confirmation',$order->order_nr)
        ->with('confirmation_msg', 'Order Successfull');
    }

    /**
     * Display a thank you page upon order confirmation
     * @param String $orderNr
     * @return \Illuminate\Http\Response
     */
    public function orderConfirmation(String $orderNr){
        //Only show the confirmation message once
        if(!session()->has('confirmation_msg')){
            return redirect()->route('pages.landing');
        }
        //Check if order exists in DB, if not, return failed order view
        if(Order::FindByOrderNumber($orderNr)->first()){
            return view('shop.confirmation', compact('orderNr'));
        }else{
            return redirect()->route('checkout.failure')->with('error_message', 'Order Failed.');
        }  
    }

    /**
     * Display an order failure message
     */
    public function orderFailure(){
        //Only show the failure message once
        if(!session()->has('error_message')){
            return redirect()->route('pages.landing');
        }
        return view('errors.failed-order')->withErrors(session()->get('error_message'));
    }
}
