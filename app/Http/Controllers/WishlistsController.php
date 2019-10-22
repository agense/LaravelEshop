<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WishlistsController extends Controller
{
     /**
     * Create a new controller instance 
     * Set Middleware.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show users wishlist page
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $wishlist = auth()->user()->wishlist()->paginate(5);
        $itemCount = DB::table('user_wishlist')->where('user_id', auth()->user()->id)->count();
        return view('users.wishlist')->with('wishlist', $wishlist)->with('itemCount', $itemCount);
    }

    /**
     * Add a product to users wishlist
     *  @param  int  $product - product id
     * @return \Illuminate\Http\Response
     */
    public function add($product){
        $exists = auth()->user()->wishlist()->where('product_id', $product)->exists();
        if($exists){
            return back()->with('success_message','This product is already in your wishlist!');
        }
        auth()->user()->wishlist()->attach($product);
        return back()->with('success_message','Product has been added to your wishlist!');
    }

    /**
     * Remove a product from users wishlist
     *  @param  int  $product - product id
     * @return \Illuminate\Http\Response
     */
    public function remove($product)
    {
        auth()->user()->wishlist()->detach($product);
        return back()->with('success_message','Item has been removed from your wishlist.');
    }

    /**
     * Remove all products from users wishlist
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        auth()->user()->wishlist()->detach();
        return back()->with('success_message','All items successfully removed.');
    }

}
