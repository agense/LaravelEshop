<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    /**
     * Set Table Name
     */
    protected $table = 'product_images';

    /**
     * Relationship with Product model
     */
    public function products(){
        return $this->belongsTo('App\Product');
    }
}
