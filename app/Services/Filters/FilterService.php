<?php
namespace App\Services\Filters;
use App\Services\Filters\Filter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;


class FilterService extends Filter
{
   protected $allowedFilterTypes = ['product', 'order', 'review'];

   protected $productFilters = ['search', 'brand', 'category', 'price', 'availability', 'featured'];
   protected $orderFilters = ['search', 'order_status', 'payment_status', 'delivery_status', 'billing_total', 'order_date', 'complete_date'];
   protected $reviewFilters = ['search'];
   
   protected $arrayFilters = ['product' => ['prefix' =>'ft_', 'name' => 'features']];

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
      if($this->isFilterable()){
          $this->setFilters();
          $this->execute();
       }
       return $this->query;
     }

   /**
    * Sets the name of each pipe class
    * @param String $key - filter name
    * @return String
    */
    protected function setPipeName($key)
    {
       return $this->filterNamespace.ucfirst($this->filterType)."Filters\\".ucfirst(Str::camel($key));
    }

   /**
    * Get applied Filters
    * @return Array
    */
   public function getApplied(){
      return $this->appliedFilters;
   }

  /**
   * Checks if any filters were applied
   * @return Bool
   */
   public function hasApplied(){
      return collect($this->appliedFilters)->isNotEmpty();
   }
}