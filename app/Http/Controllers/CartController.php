<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartQuantityUpdateRequest;

use App\Models\Product;
use App\Services\CartService;
use App\Services\CartTotalsService;
use Session;

class CartController extends Controller
{
    private $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display shopping cart page.
     * Check if all products are available in quantities requested before sale.
     * Updates cart and issues a notification if unavailable products or quantities exist
     * @return \Illuminate\Http\Response
     */
    public function index(CartTotalsService $cartTotals)
    { 
        $this->cart->confirmQuantities();
        $totals = $cartTotals->getTotals();
        return view('shop.cart')->with([
            'cart' => $this->cart->getCart(),
            'totals' => $cartTotals->getTotals()
        ]);
    }

    /**
     * Add item to the cart
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $product = Product::findOrFail($request->id);
        $this->cart->addItem($product);
        return back()->with('success_message', 'Item was added to your cart.');
    }

    /**
     * Update item quantity in cart
     * @param  \App\Http\Requests\CartQuantityUpdateRequest $request
     * Session flash is used because the calling js function refreshes the window on success
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CartQuantityUpdateRequest $request, $id)
    {   
        $this->cart->updateQuantity($id, $request->quantity);
        session()->flash('success_message', 'Quantity was updated successfully.');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the item from the cart
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cart->removeItem($id);
        return back()->with('success_message', 'Item has been removed');
    }

    /**
     * Clear the cart - remove all items
     * @return \Illuminate\Http\Response
     */
    public function clearCart()
    {
        $this->cart->emptyCart();
        return back()->with('success_message', 'All items have been removed from your cart');
    }

     /**
     * Move product from the cart to the users wishlist
     * @param  int  $rowId - row id in Gloudemans shopping cart plugin
     * @return \Illuminate\Http\Response
     */
    public function moveToWishlist($rowId){
        $this->cart->moveToWishlist($rowId);
        return back()->with('success_message', 'The product has been moved to your wishlist.');
    }

    /**
     * Move product from the users wishlist to the cart
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveToCart($id){
        $product = Product::findOrFail($id);
        $this->cart->addFromWishlist($product);
        return back()->with('success_message', 'The product has been added to your cart.');
    }
}
