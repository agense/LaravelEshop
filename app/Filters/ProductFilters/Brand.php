<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;

class Brand {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(!request()->has($filter)){
            return $next($query);
        }

        $query = $query->whereHas('brand', function($q) use($filter){
            
            $value = request()->$filter;
            if(!str_contains($value, ':')){
                $q->where('slug', $value);
            }else{
                $values = explode(':',$value);
                $q->where('slug', $values[0]);
                unset($values[0]);
                foreach($values as $val){
                    $q->orWhere('slug', $val);
                }
            }
        });

        return $next($query);
    }
}