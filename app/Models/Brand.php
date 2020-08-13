<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Set the hidden attributes
     */
    protected $hidden = ['created_at', 'updated_at'];

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
     *  Relationship with Product model
    */
    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
