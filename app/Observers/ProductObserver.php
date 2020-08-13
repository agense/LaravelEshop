<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Listen to the Product deleted event.
     * Disable associated reviews when product gets deleted
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        if(!$product->isForceDeleting()){
            $product->reviews()->update([
                'deleted_by' => 'System',
                'delete_reason' => 'product_delete',
                'deleted_at' => now()
            ]);
        }
    }

    /**
     * Listen to the Product restored event.
     *  Restore product reviews when product they belong to gets restored 
     * Only restores reviews set as deleted by 'System', i.e. ones that were deleted because the product was deleted. 
     * Does not affect product reviews that were deleted for any other reason
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        $product->reviews()->onlyTrashed()->where('deleted_by', 'System')->where('delete_reason', 'product_delete')->update([
            'deleted_by' => NULL,
            'deleted_at' => NULL
        ]);
    }

}