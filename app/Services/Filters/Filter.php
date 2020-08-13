<?php
namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

abstract class Filter
{
    private $modelNamespace = "\\App\\Models\\";
    protected $filterNamespace = "\\App\\Filters\\";

    private $filterQuery;
    private $pipes;
    private $filterClass;    
    private $filterOptions = [];
    private $postfixes = ['_min', '_max'];

    protected $filterType;
    protected $query;
    protected $appliedFilters = [];
    protected $sort = [];
    protected $allowedFilterTypes = [];

 
  /**
   * Sets current class properties:
   * filter type - the type of the filer applied, which defines filters applied
   * filter class - model class on which the query is performed, 
   * filter options - filter keys available per finter type
   * filter query - request query except pagination
   * @param String $type - filter type
   * @return void
   */
    public function __construct(String $type = null){  
      $this->setFilterType($type);

      if(!$this->isValidFilterType()){
        abort(400, "Filtering is not allowed for {$type} records");
      }
      $this->filterClass = $this->modelNamespace.ucfirst($this->filterType);
      $this->filterOptions = $this->filterType."Filters";
      $this->filterQuery = request()->query(); 
      $this->setQuery();
    }

  // ABSTACT METHODS  
  /**
   * Main class method applies filters
   * @return Builder
   */
   protected abstract function apply($q);

   /**
    * Should return an array of applied filters
    *@return Array
    */
   public abstract function getApplied();

   /**
    * Should return if class has applied filters
    * @return Bool
    */
   public abstract function hasApplied();
  
    /**
    * Sets the name of each pipe class
    * @param String $key - filter name
    * @return String - Pipe class name
    */
    protected abstract function setPipeName($key);


  // IMPLEMENTED METHODS
  /**
   * Sets a filter type, which must correspond to the name of model class on which the query will be performed
   * If type is not passed (when service is injected), retrieve type from current route
   * Automatic type setting only works when models and controllers are named using Laravel convention
   * Otherwise, the type must be manually passed via constructor
   * @param String $type
   * @return void
   */
  private function setFilterType($type){
    if(!$type){
        $type = str_replace_first('sController', '', class_basename(\Route::current()->controller));
    }
    $this->filterType = strtolower($type);
  }
  /**
   * Sets the basis for query development
   * If an instance of query builder is passed as argument, it is set as base for furher queries
   * If there are no arguments, a query is instantated to an empty query based on model class name
   * @param Illuminate\Database\Eloquent\Builder $q (optional) 
   * @return void
   */
  protected function setQuery($q = null){
    if($q && $q instanceof Builder){
      $this->query = $q;
    }else{
      $this->query = $this->filterClass::query();  
    }  
  }

  /**
    * Sets filters 
    * @return void
  */
   protected function setFilters(){
      foreach($this->filterQuery as $key => $val){
        $k = $this->removePostfixes($key);
        
        //Check if filter exists and set filters
        if($this->filterExists($k)){
            $this->pipes[] = $this->setPipeName($k);
            $this->addApplied($key, $val);
        }
        elseif($this->isArrayFilter($key)){
            $this->setArrayFilter($key,$val);
        }
        else{
            abort(400, 'Filter '.strtoupper($key).' does not exist');
        }
      }
      $this->pipes = collect($this->pipes)->unique()->toArray();
   }
 
  /**
    * Sets sort 
    * @return void
  */
  protected function setSort(){
      $this->pipes[] = $this->setPipeName('sort');
      $this->addSort();
  }

  /**
   * Performs query filtering using Pipeline
   * @return \Illuminate\Database\Query\Builder;
   */
   protected function execute(){
    if($this->pipesExist()){
      return app(Pipeline::class)
      ->send($this->query)
      ->through($this->pipes)
      ->then(function ($query){
          $this->query = $query;
      });
    }
   }

  /**
   * Adds array filters to query
   * @return void
   */
    private function setArrayFilter($key,$val){
        $arrKey = $this->arrayFilters[$this->filterType]['name'];
        $prefix = $this->arrayFilters[$this->filterType]['prefix'];
        $this->pipes[] = $this->setPipeName($arrKey);
        $this->addApplied($this->removePrefix($key, $prefix), $val);
    }

  /**
   * Adds a filter to applied filters array
   * @param String $key
   * @param String $val
   * @return void
   */
  private function addApplied($key, $val){
      $this->appliedFilters[$key] = formatArraylikeString($val);
  }

/**
 * Adds a filter to applied sort filters
 * @return void
 */
private function addSort(){
  $sort = request()->query()['sort'];
  $this->sort = [
    'column' => str_before($sort, ':'),
    'order'=> sortOrder(str_after($sort, ':'))
  ];
}
  //CLASS VALIDATIONS
  /**
     * Check if request query has any search params except for pagination and sorting
     * @return Bool
  */
  public function isFilterable(){
      $this->removeSortAndPagination();
      return !empty($this->filterQuery);
  }

  /**
     * Check if request query has any sort params except 
     * @return Bool
  */
  public function isSortable(){
      return array_key_exists('sort', request()->query());
  }

  /**
   * Validates filter type passed as argument against the available filter types
   * @return Bool
   */
  private function isValidFilterType()
  {
      if(!class_exists($this->modelNamespace.ucfirst($this->filterType))){
        return false;
      }elseif(!in_array(strtolower($this->filterType), $this->allowedFilterTypes)){
        return false;
      }else{
        return true;
      }
  }

  /**
     * Check if current request key bolongs to an array filter
     * @param String $key
     * @return Bool
  */
  private function isArrayFilter($key){
      if(!property_exists($this, 'arrayFilters')){
        return false;
      }elseif(!array_key_exists($this->filterType, $this->arrayFilters)){
        return false;
      }else{
        return starts_with($key, $this->arrayFilters[$this->filterType]['prefix']);
      }
  }

  /**
   * Checks if a single request query argument is a valid filter option. 
   * Checks validity against the $filterOptions property available for each filter type.
   * @param String $option
   * @return Bool
   */
  private function filterExists(String $option)
  {
      if(in_array(Str::snake($option), $this->{"$this->filterOptions"})) return true;
      return false;
  }

  /**
   * Checks if pipes array is npt empty
   * @param Array $pipes
   * @return Bool
   */
  private function pipesExist(){
      return count($this->pipes) > 0;
  }

  // CLASS HELPER METHODS
    /**
     * If a key has range specifics, removes them from the key
     * @param String $key
     * @return String $key
     */
    private function removePostfixes($key){
      foreach($this->postfixes as $postfix){
        if(ends_with($key, $postfix)){
          $key = str_replace_last($postfix,'',$key);
        }
      }
      return $key;
    }

    /**
     * Removes specified prefix from key
     * @param String $key
     * @param String $prefix
     * @return String $key
     */
    private function removePrefix($key, $prefix){
      return str_replace_first($prefix,'',$key);
    }

    /**
   * Sets the query for filtering removing pagination
   * @return void
   */
    private function removeSortAndPagination()
    {   
        if(array_key_exists('page', $this->filterQuery)){
          unset($this->filterQuery['page']);
        }
        if(array_key_exists('sort', $this->filterQuery)){
          unset($this->filterQuery['sort']);
        }
    }

}