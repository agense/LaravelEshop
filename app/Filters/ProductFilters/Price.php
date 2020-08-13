<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;

class Price {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        $maxKey = $filter."_max";
        $minKey = $filter."_min";

        if(request()->has($maxKey) || request()->has($minKey)){
            //If a range key exists, find records with range
            if(request()->has($maxKey)){
                $query = $query->where('price', '<=', formatMoneyToInt(request()->$maxKey));
            }
            if(request()->has($minKey)){
                $query = $query->where('price', '>=', formatMoneyToInt(request()->$minKey));
            }
            return $next($query);
        }else{
            return $next($query);
        } 
    }
}
