<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'user_id', 'review', 'rating', 'deleted_by'
    ];
    
     /**
     * Set the attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Relationship with Product model
     */
    public function product(){
        return $this->belongsTo('App\Product');
    }

    /**
     * Relationship with User model
     */
     public function user(){
         return $this->belongsTo('App\User');
     }
}
