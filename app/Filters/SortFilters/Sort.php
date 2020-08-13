<?php
namespace App\Filters\SortFilters;
use Illuminate\Support\Str;
use Closure;

abstract class Sort {
    protected $sorts = [];
    protected $sort;
    protected $order;

    public function handle($query, Closure $next)
    {   
        $filter = 'sort';
        
        if(! request()->has($filter)){
            return $next($query);
        }
        // Define sorting value and append to the query
        // If requests sort value is valid, apply that sorting, otherwise use models defaultOrder query scope to set order value 
        $this->setProperties($filter);
        if(!array_key_exists($this->sort, $this->sorts)){
            abort(400, 'Sort type '.strtoupper($this->sort).' does not exist');
        }
        $query = $query->orderBy($this->sorts[$this->sort], $this->order);
        return $next($query);
    }

    /**
     * Setc class properties: sorting column and sorting order
     */
    private function setProperties($filter){
        if(!str_contains(request()->$filter, ':')){
            $this->sort = request()->$filter;
            $this->order = 'ASC';
        }else{
            $sorter = explode(':', request()->$filter);
            $this->sort = $sorter[0];
            $this->order = strtoupper($sorter[1]) == 'DESC' ? 'DESC' : 'ASC';
        }
    }
}