<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Models\Category;

class CategoryService {

    private $pagination = 10;

    /**
     * Display a paginated listing of all categories
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Category::withCount('products')->paginate($this->pagination);
    }

    /**
     * Create a new category
     * @return App\Models\Category
     */
    public function create()
    {
        $category = Category::create(request()->only('name'));
        return $category;
    }

    /**
     * Update an existing category
     * @param App\Models\Category
     * @return App\Models\Category
     */
    public function update(Category $category)
    {
        $category = $category->update(request()->only('name'));
        return $category;
    }

    /**
     * Delete a category 
     * @param  App\Models\Category
     * @return Void
     */
    public function delete(Category $category)
    {
        try{
            $category->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

}