<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use DB;

use App\User;
class LandingPageController extends Controller
{
    /**
     * Display landing page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET ALL CATEGORIES WHICH HAVE PRODUCTS WITH TOTAL PRODUCT COUNT AND WITH THEIR FEATURED PRODUCTS
        $categories = Category::whereHas('products')
        ->withCount('products')
        ->with(['products' => function($query){
            $query->where('featured', 1);
          }])
        ->get();
       
        //get the product with lowest price in specific product category: used to display the lowest price per category
        $cats= Category::whereHas('products')->with('products')->get();
        $minPrices = [];
        foreach($cats as $category){
            $cat = new \stdClass();
            $cat->slug= $category->slug;
            $cat->min_price = $category->products->min('price');
            $minPrices[] = $cat;
        }
        $minPrices = collect($minPrices);

        foreach($categories as $category){
            foreach($minPrices as $price){
                if($category->slug == $price->slug){
                    $category->min_price = $price->min_price; 
                }
            }
        }    
        return view('landing-page')->with('categories', $categories);
    }

    
}
