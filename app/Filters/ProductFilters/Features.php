<?php
namespace App\Filters\ProductFilters;
use Illuminate\Support\Str;
use Closure;
use App\Models\Feature;

class Features {
    private $prefix = 'ft_';
    private $validFilters;

    public function __construct(){
        $this->validFilters = Feature::all('slug')->pluck('slug')->toArray();
    }
    public function handle($query, Closure $next)
    {
        foreach(request()->query() as $key => $value){
            if(starts_with($key, $this->prefix)){
                //Set the filtering column name and check its validity 
                $property = str_replace_first($this->prefix,'', $key);
                if(!in_array($property, $this->validFilters)){
                    abort(400,'Invalid Filter '.$property);
                }
                //Set the value
                $value = request()->query()[$key];
                //Format query
                $query = $query->whereHas('features',function ($query) use ($property, $value){
                    $query->where('slug', $property);
                    if(!str_contains($value, ':')){
                        $query->where('feature_value', $value);
                    }else{
                        $values = explode(':',$value);
                        $query->where('feature_value', $values[0]);
                        unset($values[0]);
                        foreach($values as $val){
                            $query->orWhere('feature_value', $val);
                        }
                    }
                });
            }
        }
        return $next($query);
    }
}