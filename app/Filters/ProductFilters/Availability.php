<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;

class Availability {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        $maxKey = $filter."_max";
        $minKey = $filter."_min";
        
        //If exact key exist, find exact value, else find range value
        if(request()->has($filter)){
            $query = $query->where('availability', intval(request()->$filter));
            return $next($query);
        }
        elseif(request()->has($maxKey) || request()->has($minKey)){
            //If a range key exists, find records with range
            if(request()->has($maxKey)){
                $query = $query->where('availability', '<=', intval(request()->$maxKey));
            }
            if(request()->has($minKey)){
                $query = $query->where('availability', '>=', intval(request()->$minKey));
            }
            return $next($query);
        }
        else{
            return $next($query);
        }  
    }
}
