<?php
namespace App\Services;

use App\Models\Product;
use Auth;

class WishlistService
{
    /**
     * Get authenticated user wishlist items
     * @return Illuminate\Support\Collection 
     */
    public function getItems()
    {
        return auth()->user()->wishlist();
    }

    /**
     * Get authenticated user wishlist item count
     * @return Int
     */
    public function itemCount()
    {
        return auth()->user()->wishlist()->count();
    }

    /**
     * Check if specified item exists in authenticated user wishlist items
     * @param Int $productId
     * @return Bool
     */
    public function itemExists($productId)
    {
        return (auth()->user()->wishlist()->where('product_id', $productId)->exists());
    }

    /**
     * Add an item to authenticated users wishlist
     * @param Int $product - product id
     * @return Void
     */
    public function addItem($product)
    {
        auth()->user()->wishlist()->attach($product);
    }

    /**
     * Remove an item from authenticated users wishlist
     * @param Int $product - product id
     * @return Void
     */
    public function removeItem($product)
    {
        auth()->user()->wishlist()->detach($product);
    }

    /**
     * Remove all items from authenticated users wishlist
     * @return Void
     */
    public function empty()
    {
        auth()->user()->wishlist()->detach();
    }

}