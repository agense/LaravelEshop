<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;

class Search {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(! request()->has($filter)){
            return $next($query);
        }

        $query = $query->where('name', 'like', '%'.request()->$filter.'%' );
        return $next($query);
    }
}