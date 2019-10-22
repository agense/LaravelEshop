<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Product;

class CartController extends Controller
{
    /**
     * Display shopping cart page.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart');
    }

    /**
     * Add item to the cart
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        //prevent duplicates
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use($request){
            //if this is true, request is for duplicate item
            return $cartItem->id === $request->id;
        });
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your cart. You can update the quantity here below.');
        }
        //add products to cart
        Cart::instance('default')->add($request->id, $request->name, 1, $request->price)->associate('App\Product');
        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart');
    }

    /**
     * Update item quantity in cart
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $productId = $request->product;
        $product = Product::find($productId);
        $available = $product->availability;
       
        //validate item quantity
        $validator = Validator::make($request->all(), [
           'quantity' => 'required|numeric|between:1,'.$available
        ]);
        if($validator->fails()){
            session()->flash('errors', collect(["Sorry, there are only $available items available."]));
            return response()->json(['success' => false], 400);
        }
        //update cart
        Cart::instance('default')->update($id, $request->quantity);
        //set session message
        session()->flash('success_message', 'Quantity was updated successfully.');
        //return json response
        return response()->json(['success' => true]);
    }

    /**
     * Remove the item from the cart
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete an item from the cart
        Cart::instance('default')->remove($id);
        return back()->with('success_message', 'Item has been removed');
    }

    /**
     * Clear the cart - remove all items
     * @return \Illuminate\Http\Response
     */
    public function clearCart()
    {
        Cart::instance('default')->destroy();
        return back()->with('success_message', 'All items have been removed from your cart');
    }

     /**
     * Move product from the cart to the users wishlist
     * @param  int  $rowId - row id in Gloudemans shopping cart plugin
     * @return \Illuminate\Http\Response
     */
    public function moveToWishlist($rowId){
        //get product details from the cart instance by rowId
        $product = Cart::instance('default')->get($rowId);

        //if product does not exist in users wishlist, add the product to the wishlist and remove it from the cart
        if(auth()->user()->wishlist()->where('product_id', $product->id)->exists()){
            return back()->with('success_message', 'This product is already in your wishlist.');
        }else{
            auth()->user()->wishlist()->attach($product->id);
            Cart::instance('default')->remove($rowId);
            return back()->with('success_message', 'The product has been moved to your wishlist.');
        }
    }

    /**
     * Move product from the users wishlist to the cart
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveToCart($id){

        $product = Product::where('id', $id)->first();
        if(!$product){
            return back()->withErrors('Sorry, there was an error.');
        }
        //check availability
        if($product->availability < 1){
           return back()->withErrors('Sorry, the product is sold out.');
        }else{
            //prevent duplicates
            $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use($product){
                return intval($cartItem->id) === intval($product->id);
            });
            if($duplicates->isNotEmpty()){
                return back()->with('success_message', 'This product is already in your cart.');
            }
            //add products to cart
            Cart::instance('default')->add($product->id, $product->name, 1, $product->price)->associate('App\Product');
            //remove product from the wishlist
            auth()->user()->wishlist()->detach($product);
            return back()->with('success_message', 'The product has been moved to your cart');
        }
    }
}
