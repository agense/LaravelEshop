<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WishlistService;

class WishlistsController extends Controller
{
    private $wishlist;
     /**
     * Create a new controller instance 
     * Set Middleware.
     * @return void
     */
    public function __construct(WishlistService $wishlist)
    {
        $this->wishlist = $wishlist;
    }
    
    /**
     * Show users wishlist page
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('users.wishlist')->with([
            'wishlist' => $this->wishlist->getItems()->paginate(5),
            'itemCount' => $this->wishlist->itemCount(),
            ]);
    }

    /**
     * Add a product to users wishlist
     *  @param  Int  $product - product id
     * @return \Illuminate\Http\Response
     */
    public function add($product){
        if($this->wishlist->itemExists($product)){
            return back()->with('success_message','This product is already in your wishlist!');
        }
        $this->wishlist->addItem($product);
        return back()->with('success_message','Product has been added to your wishlist!');
    }

    /**
     * Remove a product from users wishlist
     *  @param  Int  $product - product id
     * @return \Illuminate\Http\Response
     */
    public function remove($product)
    {
        $this->wishlist->removeItem($product);
        return back()->with('success_message','Item has been removed from your wishlist.');
    }

    /**
     * Remove all products from users wishlist
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        $this->wishlist->empty();
        return back()->with('success_message','All items successfully removed.');
    }

}
