<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ImageUploader;
use Purifier;

class Product extends Model
{
    use SoftDeletes;
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'price', 'availability', 'featured', 'featured_image', 'brand_id'];

    /**
     * Set the hidden attributes
     */
    protected $hidden = ['created_at', 'updated_at'];

     /**
     * DATES 
     * Set the attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Default Eager Loads
     */
    protected $with = ['brand:id,name,slug'];

    /**
     *  Image upload path in filesystem
    */
    private static $imageUploadPath = '/img/products/';

    /**
     * Default ordering for the model
     */
    private static $defaultOrder = 'created_at:DESC';

    //APPENDINGS
    protected $appends = ['featured_image_link'];

    //ACCESSORS
    /**
     * Get the full path to the image
     * @param  string  $value
     * @return string
     */
    public function getFeaturedImageLinkAttribute()
    {
        if($this->featured_image !== null){
            return self::$imageUploadPath.$this->featured_image;
        }else{
            return self::$imageUploadPath.'no-image.png';
        }
    }

    /**
     * Extract the price attribute from cents
     * @param  string  $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return $this->price = round($value/100, 2);
    }

    //MUTATORS
     /**
     * Set the product slug from name.
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ($value);
        $this->attributes['slug'] = str_slug($value);
    }
    /**
     * Set the product price attribute to cents
     * @param  string  $value
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = htmlentities(Purifier::clean($value), ENT_QUOTES, 'UTF-8');
    }

    //GETTERS
    public static function getImageUploadPath()
    {
        return self::$imageUploadPath;
    }

    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    //RELATIONSHIPS
    /**
     * Relationship with Category model - Many To Many
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    /**
     * Relationship with ProductImages model
     */
    public function images()
    {
       return $this->hasMany('App\Models\ProductImages');
    }

    /**
     * Relationship with Brand model
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    /**
     * Relationship with Review model
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review')->orderBy('created_at', 'DESC');
    }

    /**
     * Relationship with Feature model
     */
    public function features()
    {
      return $this->belongsToMany('App\Models\Feature')->withPivot('feature_value');
    }

    /**
     * Relationship with Order model
    */
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    //QUERY SCOPES
    public function scopeRelatedByCategory($query, $product)
    {
        return $query->where('slug', '!=', $product->slug)
        ->whereHas('categories', function($query){
            $query->whereIn('categories.id', Product::where('slug', request()->route()->product)->first()->categories);
        });
    }

    public function scopeWithCurrentUsersReviews($query){
        return $query->with(['reviews' => function($q){
            $q->where('user_id', auth()->user()->id);
        }]);
    }

    public function scopeFeatured($query){
        return $query->where('featured', 1);
    }

    public function scopeDefaultSort($query){
        $sorter = explode(':', self::$defaultOrder);
        return $query->orderBy($sorter[0], isset($sorter[1]) ? $sorter[1] : 'asc');
    }
    

    // MODEL METHODS
    /**
     * Return formatted price for display
     * @return String
    */
    public function displayPrice()
    {
         $currency = Setting::displayCurrency();
         return $currency.' '.number_format($this->price, 2);
    }

    /**
     * Calculate and return product rating from reviews (integer)
     * @return int $rating
    */
    public function getRating()
    {
        $reviewCount = count($this->reviews);
        $reviewTotal = 0;
        foreach($this->reviews as $review){
            $reviewTotal += $review->rating;
        }
        $rating = $reviewTotal/$reviewCount;
        return round($rating);
    }

}
