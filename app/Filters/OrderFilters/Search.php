<?php
namespace App\Filters\OrderFilters;
use Illuminate\Support\Str;
use Closure;

class Search {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(!request()->has($filter)){
            return $next($query);
        }

        $query = $query
            ->where('billing_name', 'like', '%'.request()->$filter.'%' )
            ->orWhere('order_nr', 'like', '%'.request()->$filter.'%');
        return $next($query);
    }
}
