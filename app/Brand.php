<?php

namespace App;

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
     *  Relationship with Product model
    */
    public function products(){
        return $this->hasMany('App\Product');
    }
}
