<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;

class Category {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(!request()->has($filter)){
            return $next($query);
        }

        $query = $query->with('categories')->whereHas('categories', function($q) use($filter){
            $q->where('slug', request()->$filter);
        });
        return $next($query);
    }
}
