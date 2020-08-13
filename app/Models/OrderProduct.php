<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * Pivot Table for relationship with Product model: Set Table Name 
     */
    protected $table = 'order_product';

    /**
     * Set the attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['order_id', 'product_id', 'item_price', 'quantity', 'user_id'];

    /**
     * Disable Timestamps
     */
    public $timestamps = false;

}
