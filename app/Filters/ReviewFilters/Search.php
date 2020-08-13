<?php
namespace App\Filters\ReviewFilters;
use Illuminate\Support\Str;
use Closure;

class Search {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(! request()->has($filter)){
            return $next($query);
        }
        $query = $query->whereHas('product', function($q) use($filter){
            $q->where('name', 'like', '%'.request()->$filter.'%' );
        })
        ->orWhereHas('user', function($q) use($filter){
            $q->where('name', 'like', '%'.request()->$filter.'%' );
        });
        return $next($query);
    }
}