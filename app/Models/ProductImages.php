<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    /**
     * Set Table Name
     */
    protected $table = 'product_images';

    /**
     * Set the hidden attributes
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];

    /**
     * Set image upload path (inside public/img dir)
     * @var array
     */
    private static $imageUploadPath = '/img/products/';
    /**
     * Get the full path to the image
     *
     * @param  string  $value
     * @return string
     */
    
     // APPENDINGS
    protected $appends = ['image_link'];

    // ACCESSORS
    public function getImageLinkAttribute()
    {
        return url(self::$imageUploadPath.$this->path);
    }
    
    //GETTERS
    public static function getImageUploadPath()
    {
        return self::$imageUploadPath;
    }

    //RELATIONS
    /**
     * Relationship with Product model
     */
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
