<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['availability'];

     /**
     * Set the attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Relationship with Category model - Many To Many
     */
    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    /**
     * Relationship with ProductImages model
     */
    public function images(){
       return $this->hasMany('App\ProductImages');
    }

    /**
     * Relationship with Brand model
     */
    public function brand(){
        return $this->belongsTo('App\Brand');
    }
    /**
     * Relationship with Review model
     */
    public function reviews(){
        return $this->hasMany('App\Review')->orderBy('created_at', 'DESC');
    }

    /**
     * Relationship with Order model
    */
    public function orders(){
        return $this->belongsToMany('App\Order');
    }

    /**
     * Return formatted price for display
    */
    public function displayPrice(){
         $currency = Setting::displayCurrency();
         return $currency.' '.number_format($this->price/100, 2);
    }

    /**
     * Return featured images path for display
    */
    public function featuredImage(){
        if($this->featured_image !== null){
            return '/img/products/'.$this->featured_image;
        }else{
            return '/img/products/no-image.png';
        }
    }
    /**
     * Calculate and return product rating from reviews (integer)
    */
    public function getRating(){
        $reviewCount = count($this->reviews);
        $reviewTotal = 0;
        foreach($this->reviews as $review){
            $reviewTotal += $review->rating;
        }
        $rating = $reviewTotal/$reviewCount;
        return round($rating);
    }
}
