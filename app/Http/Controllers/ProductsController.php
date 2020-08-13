<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ProductManagementService;

class ProductsController extends Controller
{
    private $productService;

    /**
     * Create a new controller instance.
     * Instantiate product management service.
     * @return void
     */
    public function __construct()
    {   
        $this->productService = new ProductManagementService(9);
    }

    /**
     * Display a listing of products using pagination and data filters
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchTitle = request()->has('category') ? slugToText(request()->category) : "All Products";
        $data = $this->productService->getFiltered();
        
        return view('shop.shop')->with([
                'products'=> $data['products'],
                'filters' => $data['filters'], 
                'sort' => $data['sort'],
                'searchTitle' => $searchTitle
            ]);
    }

    /**
     * Display single product page with similar products slider
     * @param  String $slug
     * @return \Illuminate\Http\Response
     */
    public function show(String $slug)
    {
        $product = $this->productService->getOneBySlug($slug);
        $suggestedProducts = $this->productService->getRelatedProducts($product);
        return view('shop.product', compact('product', 'suggestedProducts')); 
    }

   
}
