<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * Unset guarded properties
     */
    protected $guarded = [];
    /**
     * Set Table Name
     */
    protected $table = "slider"; 
    /**
     * Disable Timestamps
     */
    public $timestamps = false;

    /**
     * Set images path in filesystem
     */
    private static $imageUploadPath = 'img/slider/';
    /**
     * Set Default Slide Images (Prevents from deleting these images from filesystem)
     */
    private static $defaultImages = [
      'default-slide-1.jpg',
      'default-slide-2.png'
    ];

    /**
     * Returns default image array
     */
    public static function getDefaultImages(){
        return self::$defaultImages;
    }
    /**
     * Append images link
     */
    protected $appends = ['image_link'];

    //ACCESSORS
    public function getImageLinkAttribute()
    {
        if($this->image){
            return self::$imageUploadPath.$this->image;
        }
        return null;
    }

    //MODEL METHODS
    /**
     * Checks if slide image exists
     */
    public function imageExists(){
        if(($this->image !== null) && file_exists(public_path($this->image_link))){
            return true;
        }
        return false;
    }
    /**
     * Return a default image
     */
    public function getDefaultImageLink(){
        return self::$imageUploadPath.self::$defaultImages[0];
    }
}
