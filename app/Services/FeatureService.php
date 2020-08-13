<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use Illuminate\Support\Arr;
use App\Models\Feature;

class FeatureService {

    private $pagination = 10;

    /**
     * Return a paginated listing of all features
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Feature::orderBy('name', 'ASC')->get();
    }

    /**
     * Creates new feature 
     * @return App\Models\Feature
     */
    public function create(){
        $feature = Feature::create(request()->only('name'));
        return $feature;
    }

    /**
     * Update a feature 
     * @param App\Models\Feature
     * @return App\Models\Feature
     */
    public function update(Feature $feature){
        $feature = $feature->update(request()->only('name'));
        return $feature;
    }

    /**
     * Delete feature from database
     * @param App\Models\Feature $feature
     * @return Void
     */
    public function delete(Feature $feature){
        try{
            $feature->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Add an option to specific features options array
     * @param \App\Models\Feature $feature
     * @return \App\Models\Feature
     */
    public function addOption(Feature $feature)
    {
        $option = snake_case(request()->option);
        $feature->options = Arr::prepend($feature->options,  $option);
        $feature->save();
        return $feature;
    }

    /**
     * Delete an option from specific features options array
     * @param \App\Models\Feature $feature
     * @return \App\Models\Feature
     */
    public function deleteOption(Feature $feature)
    {
        if(!in_array(request()->option, $feature->options)){
            abort(422, "This option does not exist");
        }
        $options = array_filter($feature->options, function($v){
            return $v !== request()->option;
          });
        $feature->options = array_values($options);
        $feature->save();
        // Remove deleted options association with any products
        $feature->products()->wherePivot('feature_value', request()->option)->detach();
        return $feature;
    }

}