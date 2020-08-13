<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'city', 'region', 'postalcode',
    ];

    /**
     * Set the attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // RELATIONS

    /**
     * Relationship with Order model
     */
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Relationship with Review model
     */
    public function reviews(){
        return $this->hasMany('App\Models\Review');
    }

    /**
     * Relationship with Product model (pivot table for user whishlist)
     */
    public function wishlist(){
        return $this->belongsToMany('App\Models\Product', 'user_wishlist', 'user_id', 'product_id')->withPivot('added_on')->orderBy('added_on', 'DESC');
    }

    /**
     * Relationship with Product model via OrdersProduct Pivot Table
    */
    public function orderedProducts(){
        return $this->hasManyThrough('App\Models\Product', 'App\Models\OrderProduct', 'user_id', 'id', 'id', 'product_id');
    }


}
