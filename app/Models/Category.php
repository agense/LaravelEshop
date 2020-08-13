<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Set the attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'slug'];
    
    /**
     * Set the hidden attributes
     */
    protected $hidden = ['created_at', 'updated_at', 'pivot'];
    
    //MUTATORS
    /**
     * Set the slug from name.
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
        $this->attributes['slug'] = str_slug($value);
    }

    //RELATIONS
    /**
     * Relationship with Product model - Many To Many
    */
    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }

    //QUERY SCOPES
    //GET CATEGORIES WITH THEIR PRODUCTS 
    public function scopeWithProducts($query){
        return $query->whereHas('products')->with('products');
    }

    //GET CATEGORIES WITH THEIR FEATURED PRODUCTS AND PRODUCT COUNT
    public function scopeWithFeaturedProducts($query){
        return $query->whereHas('products')
        ->withCount('products')
        ->with(['products' => function($query){
            $query->where('featured', 1);
          }]);
    }

}
