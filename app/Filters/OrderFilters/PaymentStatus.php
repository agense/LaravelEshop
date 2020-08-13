<?php
namespace App\Filters\OrderFilters;
use Illuminate\Support\Str;
use Closure;

class PaymentStatus {
    public function handle($query, Closure $next)
    {
        $filter = Str::snake(class_basename($this));
        if(!request()->has($filter)){
            return $next($query);
        }
        if(request()->$filter == "paid"){
            $query = $query->whereHas('payment')->with('payment');
        }elseIf(request()->$filter == "unpaid"){
            $query = $query->whereDoesntHave('payment');
        }
        
        return $next($query);
    }
}