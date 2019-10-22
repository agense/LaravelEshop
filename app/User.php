<?php

namespace App;

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

    /**
     * Relationship with Order model
     */
    public function orders(){
        return $this->hasMany('App\Order');
    }

    /**
     * Relationship with Review model
     */
    public function reviews(){
        return $this->hasMany('App\Review');
    }

    /**
     * Relationship with Product model (pivot table for user whishlist)
     */
    public function wishlist(){
        return $this->belongsToMany('App\Product', 'user_wishlist', 'user_id', 'product_id')->withPivot('added_on')->orderBy('added_on', 'DESC');
    }


}
