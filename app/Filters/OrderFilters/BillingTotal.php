<?php
namespace App\Filters\OrderFilters;
use Illuminate\Support\Str;
use Closure;

class BillingTotal {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        $maxKey = $filter."_max";
        $minKey = $filter."_min";

        if(request()->has($maxKey) || request()->has($minKey)){
            //If a range key exists, find records with range
            if(request()->has($maxKey)){
                $query = $query->where('billing_total', '<=', formatMoneyToInt(request()->$maxKey));
            }
            if(request()->has($minKey)){
                $query = $query->where('billing_total', '>=', formatMoneyToInt(request()->$minKey));
            }
            return $next($query);
        }else{
            return $next($query);
        }  
    }
}