<?php
namespace App\Filters\OrderFilters;
use Illuminate\Support\Str;
use Closure;

class OrderStatus {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));

        if(!request()->has($filter)){
            return $next($query);
        }

        $query = $query->where('status', request()->$filter);
        return $next($query);
    }
}
