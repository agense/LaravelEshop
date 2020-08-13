<?php
namespace App\Services\Filters;

use App\Services\Filters\Filter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class SortService extends Filter
{
   protected $allowedFilterTypes = ['product', 'order', 'review'];

   public function __construct($type = null){
      parent::__construct($type);
   }

   /**
    * Main method, executes filtering
    * If an instance of query builder is passed as argument, it is set as base for furher queries
    * @param Illuminate\Database\Eloquent\Builder (optional) 
    * @return  Illuminate\Database\Eloquent\Builder
    */
   public function apply($q = null){
    if($q){ 
        $this->setQuery($q);
    }   
    if($this->isSortable()){
        $this->setSort();
        $this->execute();
      }else{
          $this->query->DefaultSort();
      };
      return $this->query;
   }

    /**
    * Sets the name of each pipe class
    * @param String $key - filter name
    * @return String
    */
    protected function setPipeName($key)
    {
        return $this->filterNamespace."SortFilters\\".ucfirst($this->filterType);
    }
   
    /**
    * Get applied sort Filters
    * @return Array
    */
   public function getApplied(){
    return $this->sort;
    }

    
  /**
   * Checks if any sort filters were applied
   * @return Bool
   */
    public function hasApplied(){
        return collect($this->sort)->isNotEmpty();
    }
}