<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ImageArrayValidationRequest;
use App\Services\ProductManagementService;
use App\Models\Product;

class ProductsController extends Controller
{
    private $productService;
    /**
     * Create a new controller instance.
     * Instantiate product management service.
     * @return void
     */
    public function __construct(ProductManagementService $service)
    {   
        $this->productService = $service;
    }

    /**
     * Display a paginated listing of all products or filtered products baed on request query
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $data = $this->productService->getFiltered();
        return view('admin.products.index')->with([
            'products'=> $data['products'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }
    

    /**
     * Show the form for creating a new product.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.products.add')->with(['product' => new Product()]);
    }

    /**
     * Store a newly created product in the db.
     * @param App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->productService->saveProduct();
        return redirect()->route('admin.products.index')
        ->with('success_message', 'Product has been created');
    }

    
    /**
     * Redirect to the edit page
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product->id);
    }

    /**
     * Show the form for editing the specified product.
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->load(['images', 'categories']);
        //Attach additional properties
        $this->productService->attachFeatures($product, true);
        $this->productService->attachCategoryIds($product);
        return view('admin.products.edit')->with('product', $product);
    }

    /**
     * Update the specified product in db.
     * @param App\Http\Requests\ProductRequest $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->saveProduct($product);
        return redirect()->route('admin.products.index')
        ->with('success_message', 'Product has been updated');
    }

    /**
     * Soft delete products
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productService->deactivate($product);
        return redirect()->route('admin.products.index')
        ->with('success_message', 'Product has been added to deleted products list and deactivated.');  
    }

    // SOFT DELETE FUNCTIONALITY
    /**
     * Show all soft deleted products
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {    
        $data = $this->productService->getFiltered('deleted');
        return view('admin.products.deleted')->with([
            'products'=> $data['products'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }

    /**
     * Restore a deleted product
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {  
        $this->productService->restore($id);
        return redirect()->back()->with('success_message', 'Product has been restored');
    }

    /**
     * Remove the specified product from DB, but only if it is not associated with any orders.
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function finalDelete($id)
    {
        $this->authorize('isAdmin');
        $this->productService->delete($id);
        return redirect()->back()->with('success_message', 'Product has been deleted');
    }

     //MANAGE PRODUCTS PROPERTIES IMAGES/AJAX REQUESTS
    /**
     * Toggle products featured property
     * @param  \Illuminate\Http\Request $request
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function featured(Request $request, $id)
    {
        $updatedFeatured = $this->productService->toggleFeatured($id);
        $message = ($updatedFeatured == 1) ? 'Product has been set to featured!' : 'Product has been removed from featured!';
        return response()->json(['message' => $message, 'newvalue' => $updatedFeatured]); 
    }

    /**
     * Update product quantity
     * @param  \Illuminate\Http\Request  $request
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuantity(Request $request, $id)
    {
        $this->validate($request, [
            'newquantity' => 'required|integer|min:0',
        ]);
        $this->productService->updateQuantity($id);
        return response()->json(['message' => 'Product Quantity Updated'], 200);
    }

    //MANAGE PRODUCT IMAGES/AJAX REQUESTS
    /**
     * Remove a single image.
     * @param  Int $id 
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {  
        $this->productService->deleteImage($id);
        return response()->json(['message' => 'Image has been deleted.']);
    }

    /**
     * Upload images when editing the product
     * @param  \App\Http\Requests\ImageArrayValidationRequest $request
     * @return \Illuminate\Http\Response (json)
     */
    public function updateImages(ImageArrayValidationRequest $request)
    {   
        $updatedImgs = $this->productService->updateImages($request->product_id);
        return response()->json([
            'message'=> 'All images were uploaded successfuly.', 
            'images' => $updatedImgs
            ]);
    }

}
