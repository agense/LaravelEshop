<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Models\Brand;

class BrandsService {

    private $pagination = 10;

    /**
     * Display a paginated listing of all brands
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Brand::withCount('products')->orderBy('name')->paginate($this->pagination);
    }

    /**
     * Create a new brand
     * @return App\Models\Brand
     */
    public function create()
    {
        $brand = Brand::create(request()->only('name'));
        return $brand;
    }

    /**
     * Update an existing brand
     * @param App\Models\Brand
     * @return App\Models\Brand
     */
    public function update(Brand $brand)
    {
        $brand = $brand->update(request()->only('name'));
        return $brand;
    }

    /**
     * Delete a brand and all associated products
     * Prevents deleting brands with products that have sales
     * @param  App\Models\Brand
     * @return Void
     */
    public function delete(Brand $brand)
    {
        $brand->load(['products' => function($query){
            $query->whereHas('orders');
        }]);
        if($brand->products->count() > 0){
            abort(400, 'Brands that have products with associated sales cannot be deleted.');
        }
        try{
            $brand->products()->get(['id'])->each->forceDelete();
            $brand->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

}