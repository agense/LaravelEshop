<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Review extends Model
{
    use SoftDeletes;
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'user_id', 'review', 'rating', 'deleted_by'];
    
     /**
     * DATES
     * Set the attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * EAGER LOADING RELATIONSHIPS
     */
    protected $with = ['user'];

    /**
     * Default ordering for the model
     */
    private static $defaultOrder = 'created_at:DESC';

    // ACCESSORS
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getDeletedAtAttribute($date)
    {
        if($date){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        return null;
    }

    public function getDeleteReasonAttribute($value)
    {
        if($value !== null){
            return formatToText($value);
        }
        return "";
    }

    // RELATIONSHIPS
    /**
     * Relationship with Product model
     */
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * Relationship with User model
     */
     public function user(){
         return $this->belongsTo('App\Models\User');
     }

     //QUERY SCOPES
     public function scopeRating($query, Int $rating){
        return $query->where('rating', $rating);
     }

     public function scopeWithRelatedProduct($query, $withBrand = false){
        return $query->with(['product' => function ($query) use($withBrand){
            $query->withTrashed();
            if($withBrand){
                $query->with('brand');
            }
        }]);
     }

     public function scopeDefaultSort($query){
        $sorter = explode(':', self::$defaultOrder);
        return $query->orderBy($sorter[0], isset($sorter[1]) ? $sorter[1] : 'asc');
    }

     // MODEL METHODS 
     /**
      * Sets Review as deleted (soft delete) and set the name of the person deleting the review(to distinguish between user and admin deletes).
      * @return Void
      */
     public function markAsDeleted($reason){
        $this->deleted_by = auth()->user()->name;
        $this->deleted_at = now();
        $this->delete_reason = $reason;
     }

     public function markAsRestored(){
        $this->deleted_by = null;
        $this->deleted_at = null;
        $this->delete_reason = null;
     }

     /**
      * Checks if a review can be restored.
      * Prevents Admin users from restoring reviews deleted by simple user
      * @return Bool
      */
     public function restoreAllowed(){
        if($this->deleted_by == $this->user->name) return false;
        return true;
     }

     /**
      * Checks if a user that accesses the review is its author
      * @return Bool
      */
     public function authorAccess(){
        return ($this->user_id == auth()->user()->id);
     }

}
