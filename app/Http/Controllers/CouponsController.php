<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;

class CouponsController extends Controller
{
    /**
     * Apply users discount cart for price reduction on checkout
     * If the coupon/dicount card is found in db, its data is stored in a session to be retrieved in checout controller.
     * Redirects back to the checkout page with message of success or failure.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get a coupon from db by code
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if(!$coupon){
            if(auth()->user()){
                return redirect()->route('checkout.index')->withErrors('Invalid coupon code. Please try again.');
            }else{
                return redirect()->route('guestCheckout.index')->withErrors('Invalid coupon code. Please try again.');
            }
        }
        //if coupon is found, store it in a session
        session()->put('coupon', [
            'name'=> $coupon->code,
            //apply coupon discount on cart subtotal
            'discount' => $coupon->discount(Cart::instance('default')->subtotal()), 
            'display_value' =>$coupon->displayDiscount($coupon->code),
        ]);
        if(auth()->user()){
           return redirect()->route('checkout.index')->with('success_message','Coupon has been applied.');
        }else{
            return redirect()->route('guestCheckout.index')->with('success_message','Coupon has been applied.');
        }
    }

    /**
     * Remove the specified coupon data from the session
     * Redirects back to the checkout page with message of success or failure.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        if(auth()->user()){
           return redirect()->route('checkout.index')->with('success_message','Coupon has been removed.');
        }else{
            return redirect()->route('guestCheckout.index')->with('success_message','Coupon has been removed.');
        }   
    }
}
