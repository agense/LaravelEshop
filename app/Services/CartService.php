<?php
namespace App\Services;

use App\Exceptions\ProductAvailabilityException;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\WishlistService;
use App\Models\Product;

class CartService
{
    private $cart;
    private $stockErrors = [];

    public function __construct(){
        $this->cart = Cart::instance('default');
    }

    /**
     * Returns an instance of shopping cart
     * @return Gloudemans\Shoppingcart\Facades\Cart
     */
    public function getCart(){
        return $this->cart;
    }

    /**
     * Checks if shopping cart is empty
     * @return Bool
     */
    public function isEmpty()
    {
        return $this->cart->count() == 0;
    }

    /**
     * Checks if specific item exists in shopping cart 
     * @param Int $productId - the id of the product model instance
     * @return Bool
     */
    public function itemExists($productId)
    {   
        $exists = $this->cart->search(function($cartItem, $rowId) use($productId){
            return intval($cartItem->id) === intval($productId);
        });
        return $exists->isNotEmpty();
    }

    /**
     * Adds specific item to the shopping cart 
     * @param \App\Models\Product
     * @return Void
     */
    public function addItem(Product $product)
    {
        if($this->itemExists($product->id)){
            abort(422, 'This product already exists in your cart');
        }
        elseif($this->quantityUnavailable($product, 1)){
            abort(422, 'This product is sold out.');
        }
        else{
            $this->cart->add($product->id, $product->name, 1, $product->price)
            ->associate('App\Models\Product');
        }  
    }

     /**
     * Update cart quantity for specific item 
     * @param Int $rowId - item row id in cart
     * @param Int $quantity - request quantity 
     * @return Void
     */
    public function updateQuantity($rowId, $quantity)
    {
        $this->cart->update($rowId, $quantity);
    }

    /**
     * remove specific item from cart
     * @param Int $rowId - item row id in cart
     * @return void
     */
    public function removeItem($rowId)
    {
        $this->cart->remove($rowId);
    }

    /**
     * Destory the cart class instance
     * @return Void
     */
    public function emptyCart()
    {
        $this->cart->destroy();
    }

    /**
     * Remove specific item from cart and add it to users wishlist
     * @param Int $rowId - item row id in cart
     * @return Void
     */
    public function moveToWishlist($rowId)
    {
        $product = $this->cart->get($rowId);
        $wishlist = new WishlistService();
        if($wishlist->itemExists($product->id)){
            abort(422, 'This product already exists in your wishlist');
        }
        $wishlist->addItem($product->id);
        $this->removeItem($rowId);
    }

    /**
     * Add specific item to cart and remove it from users wishlist
     * @param \App\Models\Product $product
     * @return Void
     */
    public function addFromWishlist(Product $product)
    {
        $this->addItem($product);
        (new WishlistService())->removeItem($product->id);
    }

/*
|-----------------------------------------------------------------------------------------------------------
| Stock Control 
|-----------------------------------------------------------------------------------------------------------
*/
     /**
     * Check if all items in cart are available in quantities set
     * @return Void
     */
    public function confirmQuantities()
    {
        $this->checkStock();
        if($this->stockErrorsExist()){
            throw new ProductAvailabilityException($this->stringifyStockErrors());
        }
    }
    
    /**
     * Check if current class has any stock errors
     * @return Bool
     */
    public function stockErrorsExist()
    {
        return collect($this->stockErrors)->isNotEmpty();
    }

    /**
     * Return current class stock errors as string
     * @return String
     */
    private function stringifyStockErrors()
    {
        return implode ( '. ' , $this->stockErrors );
    }

    /**
     * Check if specified product quantity is available
     * @param \App\Models\Product $product
     * @param Int $qty - required quantity 
     * @return Bool
     */
    private function quantityUnavailable(Product $product, $qty)
    {
        if($product->availability < $qty) return true;
        return false;
    }

    /**
     * Check if all items in cart are available in quantities set
     * If any items are unavailable, cart is updated accordingly and stock errors are set
     * @return Void
     */
    private function checkStock()
    {
        foreach($this->cart->content() as $item){
            if($item->model == null){
                $this->removeItem($item->rowId);
                array_push ($this->stockErrors, "Product {$item->name} is no longer available. It has been removed from your cart.");
            }else{
                $product = Product::find($item->model->id);
                if($product->availability <= 0){
                    $this->removeItem($item->rowId);
                    array_push ($this->stockErrors, "Product {$item->model->name} is no longer available. It has been removed from your cart.");
                }elseif($this->quantityUnavailable($product, $item->qty)){
                    $this->updateQuantity($item->rowId, $item->model->availability);
                    array_push ($this->stockErrors, "The available quantity for {$item->model->name} is lower than your cart quantity. Your cart quantity has been updated to the highest available.");
                }
            }  
        }
    }
}