<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\Productimages;

class ShopController extends Controller
{
    /**
     * Display a listing of products using pagination and data filters
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 9;
        $categories = Category::all();
        $brands = Brand::all();
        $brandName = "";

        //if category exists in query string, display only products from specified category, otherwise display all products
        if(request()->category){
            $products = Product::with('categories')->whereHas('categories', function($query){
                $query->where('slug', request()->category);
            }); 
            $brandName = optional($brands->firstWhere('id', request()->brand))->name;
            $categoryName = optional($categories->firstWhere('slug', request()->category))->name;
        }else{
            $products = Product::where('id', '!=', 0);
            $categoryName = 'All Products';
        }
        //if brand exists in string, only display products of specific brand
        if(request()->brand){
            $products = $products->where('brand_id', request()->brand);
            $brandName = optional($brands->firstWhere('id', request()->brand))->name;
        }
  
        //sort by price
        if(request()->sort == 'low_high'){
            $products = $products->orderBy('price')->paginate($pagination);

        }elseif(request()->sort == 'high_low'){
            $products = $products->orderBy('price', 'desc')->paginate($pagination);
        }else{
            //get products based on all criteria
           $products = $products->paginate($pagination);
        }
        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
            'brandName' => $brandName,
            'brands' => $brands,
            'productCount' => $products->total()
            ]);
    }

    /**
     * Display single product page with similar products slider
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //get single product by slug
        $product = Product::where('slug', $slug)->with('reviews.user', 'brand')->firstOrFail();

        $productImages = Productimages::where('product_id', $product->id)->get();
        //add featured image to product images array for slider
        if(count($productImages) > 0){
            $featured = new Productimages();
            $featured->path = $product->featured_image;
            $productImages->prepend($featured);
        }

        //product availability display
        $productAvailability = displayAvailability($product->availability);

        $suggestedProducts = Product::where('slug', '!=', $slug)
           ->whereHas('categories', function($query){
            $query->whereIn('categories.id', Product::where('slug', request()->route()->product)->first()->categories);
        })->inRandomOrder()->take(12)->get();

        // check if product exists in users wishlists, used for correct wishlist button display
        $inCart = false;
        if(auth()->user() && auth()->user()->wishlist()->where('product_id', $product->id)->exists()){
         $inCart = true;
        }
        
        return view('product')->with([
            'product' => $product,
            'suggestedProducts' => $suggestedProducts,
            'productImages' => $productImages,
            'productAvailability' => $productAvailability,
            'inCart' => $inCart,
            ]);
    }

   
}
