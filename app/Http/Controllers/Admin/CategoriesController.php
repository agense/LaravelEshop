<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryValidationRequest;
use App\Services\CategoryService;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $categoryService;
    /**
     * Create a new controller instance.
     * Set Controllers Middleware: only allow users with superadmin or admin priviledges
     * Inject CategoryService
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {   
        $this->middleware('adminUser');
        $this->categoryService = $categoryService;
    }


    /**
     * Display a listing of all categories
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Store a newly created category in DB
     * @param  \App\Http\Requests\CategoryValidationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidationRequest $request)
    {
        $category = $this->categoryService->create();
        session()->flash('success_message', 'Category has been created.');
        return response()->json($category, 201);  
    }

    /**
     * Show the form for editing the specified category
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {   
        return response()->json($category);
    }

    /**
     * Update the specified category in DB.
     * @param  \App\Http\Requests\CategoryValidationRequest  $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValidationRequest $request, Category $category)
    {
        $category = $this->categoryService->update($category);
        session()->flash('success_message', 'Category has been updated.');
        return response()->json($category);
    }

    /**
     * Remove the specified category from DB.
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);
        return redirect()->route('admin.categories.index')->with('success_message', 'Category has been deleted');
    }

}
