<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Feature extends Model
{
    protected $table = 'features';

    /**
     * Unset guarded properties
     */
    protected $fillable = ['name', 'slug', 'options'];
    /**
     * Disable Timestamps
     */
    public $timestamps = false;

    //CASTS
    protected $casts = [
        'options' => 'array',
    ];

    //Accessors And Mutators
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
     /**
     * Set options value to empty array if its null
     */
    public function getOptionsAttribute(){
        if($this->attributes['options'] !== null){
            return json_decode($this->attributes['options']);
        }
        return [];
    }

    //RELATIONS
    /**
     * Relationship with Product model
     */
    public function products()
    {
       return $this->belongsToMany('App\Models\Product')->withPivot('feature_value');
    }

    //MODEL METHODS
    /**
     * Returns a list of slugs of all features
     *  @return Array
     */
    public static function getSlugList(){
        return Arr::flatten(self::all('slug')->toArray());
    }

    /**
     * Returns a list of all features
     *  @return Illuminate\Database\Eloquent\Collection
     */
    public static function getList(){
        return self::all();
    }

}


