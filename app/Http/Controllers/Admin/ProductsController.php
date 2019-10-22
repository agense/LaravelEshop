<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Validation exception
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

//Add the models
use App\Product;
use App\Category;
use App\Brand;
use App\Productimages;
use Image;
use File;

//Add requests
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     *
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin priviledges
        $this->middleware('adminUser')->except('index','show');
    }

    /**
     * Show all products/ filtered /searched products
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        //products with filters
        $filterName = "";
        $searchName = "";

         if(request()->name){
            //Search by name
            $products = Product::where('name', 'like', '%'.request()->name.'%' )->paginate(10);
            $searchName = 'name';

         }elseif(request()->category){
            //Filter by category
            $products = Product::with('categories')->whereHas('categories', function($query){
                $query->where('slug', request()->category);
            })->orderBy('brand_id')->paginate(10); 
            $filterName = 'category';
         }
         elseif(request()->brand){
           //Filter by brand  
           $products = Product::whereHas('brand', function($query){
               $query->where('slug', request()->brand);
           })->paginate(10);
           $filterName = 'brand';
         }
         elseif(request()->featured){
            //Filter by featured items
            $products = Product::with(['brand'])->where('featured', request()->featured)->paginate(10);
            $filterName = 'featured';
         }
         elseif(request()->price){
            //Filter by price
            $from = request()->from ? intval(request()->from)*100 : null;
            $to = request()->to ? intval(request()->to)*100 : null;

            $products = Product::with(['brand']);
            if($from == null){
                $products = $products->where('price', '<=', $to);
            }elseif($to == null){
                $products = $products->where('price', '>', $from);
            }else{
                $products = $products->whereBetween('price', [$from, $to]);
            }
            $products = $products->orderBy('price')->paginate(10); 
            $filterName = 'price';   
         }
         elseif(request()->availability){
            //Filter By Availability 
            $from = request()->from ? intval(request()->from): null;
            $to = request()->to ? intval(request()->to) : null;  
            
            $products = Product::with(['brand']);
            if($from == null && $to == 0){
                $products = $products->where('availability', '=', 0);
            }elseif($from == null){
                $products = $products->where('availability', '<=', $to);
            }elseif($to == null){
                $products = $products->where('availability', '>', $from);
            }else{
                $products = $products->whereBetween('availability', [$from, $to]);
            }
            $products = $products->orderBy('availability')->paginate(10);    
            $filterName = 'availability';
         }
         else{
            //Return all products 
            $products = Product::with(['images','brand'])->paginate(10);
            
         }
         return view('admin.products.index')
            ->with('products', $products)
            ->with('filterName', $filterName)
            ->with('searchName', $searchName);
    }

    /**
     * Show the form for creating a new product.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.add')->with('categories', $categories)->with('brands', $brands);
    }

    /**
     * Store a newly created product in the db.
     * @param App\Http\Requests\AddProductRequest $request (request with validation rules)
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->slug = str_slug($request->name);
        $product->price = $request->price * 100;
        $product->availability = $request->availability;
        $product->featured = $request->featured;
        $product->brand_id = $request->brand;
        if ($request->filled('details')){
            $product->details= $request->details;
        }
        if ($request->filled('description')){
            $product->description = $request->description;
        }
        //upload featured image if exists
        if($request->hasFile('featured_image')){
            $image = $request->file('featured_image');
            $ext = $image->getClientOriginalExtension();
            $filename = $product->slug.'_featured_image_'.time().'.'.$ext;
            $location = public_path('img/products/'.$filename);
            Image::make($image)->save($location);
            //save in db
            $product->featured_image = $filename;
        }
        $product->save();

        // Attach categories to the product
        $product->categories()->sync($request->categories, false);

        //upload multiple images if exist
            if($request->hasFile('images')){
                foreach($request->file('images') as $img){
                    $ext = $img->getClientOriginalExtension();
                    $imgname = $product->slug.'-image-'.uniqid().'.'.$ext;
                    $path = public_path('img/products/'.$imgname);
                    Image::make($img)->save($path);
        
                    //save in db
                    $productImg = new Productimages();
                    $productImg->product_id = $product->id;
                    $productImg->path = $imgname;
                    $productImg->save();
                }
            }
        return redirect()->route('products.index')->with('success_message', 'Product has been created');
    }

    /**
     * Display the specified product.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $productImages = Productimages::where('product_id', $product->id)->get();
        //add featured image to product images array for slider
        if(count($productImages) > 0){
            $featured = new Productimages();
            $featured->path = $product->featured_image;
            $productImages->prepend($featured);
        }
        return view('admin.products.show')->with('product', $product)->with('productImages', $productImages);
    }

    /**
     * Show the form for editing the specified product.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $selectedCategories = array();
        foreach($product->categories as $category){
            $selectedCategories[] = $category->id; 
        }
        $productImages = $product->images;

        return view('admin.products.edit')
        ->with('product', $product)
        ->with('categories', $categories)
        ->with('brands', $brands)
        ->with('selected', $selectedCategories)
        ->with('productImages', $productImages);
    }

    /**
     * Update the specified product in db.
     * @param App\Http\Requests\EditProductRequest $request (request with validation rules)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->slug = str_slug($request->name);
        $product->price = $request->price * 100;
        $product->availability = $request->availability;
        $product->featured = $request->featured;
        $product->brand_id = $request->brand;
        if ($request->filled('details')){
            $product->details= $request->details;
        }
        if ($request->filled('description')){
            $product->description = $request->description;
        }
         //change featured image if exists
         if($request->hasFile('featured_image')){
            $image = $request->file('featured_image');
            $ext = $image->getClientOriginalExtension();
            $filename = $product->slug.'_featured_image_'.time().'.'.$ext;
            $location = public_path('img/products/'.$filename);
            Image::make($image)->save($location);

            //delete previous image if exists
            if($product->featured_image !== null && file_exists(public_path('img/products/'.$product->featured_image))){
                File::delete(public_path('img/products/'.$product->featured_image));
            }
            //save new image in db
            $product->featured_image = $filename;

        }
         //update db
         $product->save(); 

        // Attach categories to the product
        $product->categories()->sync($request->categories, true);
        return redirect()->route('products.index')->with('success_message', 'Product has been updated');
    }

    /**
     * Soft delete products
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success_message', 'Product has been added to deleted products list and deactivated.');  
    }

    //MANAGE PRODUCT IMAGES/AJAX REQUESTS
    /**
     * Remove single specified image.
     * @param  int  $id - image id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
       $image = Productimages::find($id);
       if(!$image){return response()->json(['error', 'There was an error.Image cannot be deleted.']); }
       
        //delete from db and storage
        if($image->delete() &&  File::delete(public_path('img/products/'.$image->path))){
            return response()->json(['success', 'Image has been deleted.']);
        }else{
            return response()->json(['error', 'There was an error.Image cannot be deleted.']);
        }
    }

    /**
     * Upload images when editing the product
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     * response: json
     */
    public function updateImages(Request $request)
    {   
       if($request->hasFile('images')){
       
        //validate data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'images.*' => 'nullable|image|max:1999'
           ]);
           if ($validator->fails()) {
             $err = "";
             foreach ($validator->errors()->get('product_id') as $message) {
                $err .= implode(' ', $message);
             }
             foreach ($validator->errors()->get('images.*') as $message) {
                $err .= implode(' ', $message);
             }
             return response()->json(['error', $err]); 
           }
           //Find product to which the image is attaches
           $productId = intval($request->product_id);
           $product = Product::find($productId);
           $files = $request->file('images');

           if(!$product){
            return response()->json(['error', 'There was an error. Images cannot be uploaded.']);
           }else{
            $uploadedImages = array();
            //add to storage
            foreach($files as $img){
                $ext = $img->getClientOriginalExtension();
                $imgname = $product->slug.'-image-'.uniqid().'.'.$ext;
                $path = public_path('img/products/'.$imgname);
                Image::make($img)->save($path);
                
                //save in db
                $productImg = new Productimages();
                $productImg->product_id = $product->id;
                $productImg->path = $imgname;
                $productImg->save();
                //prepare response
                $displayPath = asset('img/products/'.$imgname); 
                $image = [];
                $image['path'] = $displayPath;
                $image['id'] = $productImg->id;
                $uploadedImages[] = $image;
                }  
                return response()->json(['success', 'All images were uploaded successfuly.', $uploadedImages]);
            }
       }
    }

    /**
     * Update product quantity
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateQuantity(Request $request, $id){
        if(!$request->wantsJson()) {
            return redirect()->route('admin.products');
        }
        $product = Product::findOrFail($id);
        try {
            $this->validate($request, [
                'newquantity' => 'required|integer|min:0',
            ]);
            //update quantity
            $product->availability = $request->newquantity;
            $product->save();

            return response()->json([
                'status' => 'success',
                'msg'    => 'Quantity Updated',
            ], 201);
        }
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ]);
        }
    }

    /**
     * Show all soft deleted products
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {    
       $deletedProducts = Product::onlyTrashed()->withCount('orders')->paginate(10);
       return view('admin.products.deleted')->with('products', $deletedProducts);
    }

    /**
     * Restore a deleted product
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {  
      $product = Product::onlyTrashed()->where('id', $id)->first();
      $product->restore();
      return redirect()->back()->with('success_message', 'Product has been restored');
    }

    /**
     * Remove the specified product from DB, but only if it is not associated with any orders.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finalDelete($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->withCount('orders')->first();
        if($product->orders_count > 0){
            return redirect()->back()->with('error_message', 'Products that have associated saled cannot be deleted.');
        }
        //delete all images if exist
        $productImages = Productimages::where('product_id', $product->id)->get();

        foreach($productImages as $image){
            if(file_exists(public_path('img/products/'.$image->path))){
                File::delete(public_path('img/products/'.$image->path));
            }
            //delete from db
            $image->delete();
        }
         //delete featured image if exists
         if($product->featured_image !== null && file_exists(public_path('img/products/'.$product->featured_image))){
           File::delete(public_path('img/products/'.$product->featured_image));
         }
         $product->forceDelete();
         return redirect()->back()->with('success_message', 'Product has been deleted');
         
    }

    /**
     * Toggle products featured property
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return  response: json
     */
    public function featured(Request $request, $id){
        if(!$request->wantsJson()) {
            return redirect()->route('admin.products');
        }
        $product = Product::findOrFail($id);
        if($product->featured == 0){
            $product->featured = 1;
        }else{
            $product->featured = 0;
        }
        $product->save();
        return response()->json([ 
        'status' => 'success',
        'featured'    => $product->featured,
        ]);
    }

}
