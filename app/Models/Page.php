<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * Set the attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'slug', 'type', 'content'];
    
    /**
     * Page types
    */
    private static $types = [
      'standard', 
      'terms'
    ];

    /**
     * Image Upload Path
     */
    private static $imageUploadPath = 'img/pages/';

    /** Return page types */
    public static function getTypes(){
      return self::$types;
    }

    // ACCESSORS
    public function getContentAttribute($value){
      return $this->content = $this->prefixImageUrs($value);
    }

    // MUTATORS
     /**
     * Set page slug from title
     * @param  string  $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
        $this->attributes['slug'] = str_slug($value);
    }

    // GETTERS
    public static function getImageUploadPath(){
      return self::$imageUploadPath;
    }

    // METHODS
    /**
     * Prefixes editor content images with apps domain name
     * @param String $content
     * @return String content with prefixed images
     */
    public function prefixImageUrs(String $content){
      $baseUrl = config('app.url');
      return str_replace('src=&quot;', 'src=&quot;'.$baseUrl.'/', $content);
    }
  }   