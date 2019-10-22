<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Relationship with Product model - Many To Many
    */
    public function products(){
        return $this->belongsToMany('App\Product');
    }

}
