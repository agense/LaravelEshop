<?php
namespace App\Services;

use App\Exceptions\FilteringException;
use App\Exceptions\ModelModificationException;
use App\Services\Filters\FilterService;
use App\Services\Filters\SortService;
use App\Services\ProductImageManager;
use App\Models\Product;
use App\Models\Productimages;
use App\Models\Feature;
use App\Models\Category;
use DB;

class ProductManagementService
{
    private $pagination;
    private $filter;
    private $sorter;

    public function __construct(Int $pagination = 10){
        $this->pagination = $pagination;
        $this->filter = new FilterService('product');
        $this->sorter = new SortService('product');
    }

    /**
     * Return a paginated listing of all products 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Product::DefaultSort()->paginate($this->pagination);
    }


    /**
     * Return a paginated listing of deleted products 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getDeleted()
    {
        return Product::onlyTrashed()->withCount('orders')->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of products based on request query and calling params along with applied filter and sorting names 
     * @param String $specific (optional) - defines additional filter types except request query
     * @return Array
     */
    public function getFiltered($specific = false)
    {
        $filters = [];
        $sort = [];
        $products = [];

        try{
            if(!request()->isFilterable()){
                if($specific && $specific == 'deleted'){
                    $products = $this->getDeleted();
                }
                else{
                    $products = $this->getAll();
                }
            }else{
                //Apply query filters
                $products = $this->filter->apply();
    
                //Apply additional filters if exist
                if($specific && $specific == 'deleted'){
                    $products = $products->onlyTrashed()->withCount('orders');
                }
    
                //Apply Sorting
                if(request()->isSortable()){
                    $products = $this->sorter->apply($products);
                    $sort = $this->sorter->getApplied();
                }
                $filters = $this->filter->getApplied();
                $products = $products->paginate($this->pagination);
            }
            $products->productCount = $products->total();
            return [
                'products' => $products,
                'filters' => $filters,
                'sort' => $sort
            ];
        }catch(\Exception $e){
            throw new FilteringException($e->getMessage());
        }
    }

    /**
     * Creates new product or updates existing one
     * @param App\Models\Product $product (optional)
     * @return App\Models\Product
     */
    public function saveProduct($product = null)
    {
        $imageManager = new ProductImageManager();
        $product = ($product instanceof Product) ? $product : new Product;
        //Save current featured image if exists
        $currentFeaturedImage = $product->featured_image;
        
        try{
            //Add properties to product
            $product->fill(request()->except(['featured_image']));

            //Upload featured image if exists in request
            if(request()->hasFile('featured_image')){ 
                $imageManager->uploadFeaturedImage(request()->file('featured_image'), $product);
                $product->featured_image = $imageManager->getFileName();
            }

            //Save data in DB
            $this->dbSaveProduct($product);

            //If product was saved, delete previous featured image (if exists)
            if(request()->hasFile('featured_image') && $currentFeaturedImage !== null){
                $imageManager->delete($currentFeaturedImage);
            }

            //Upload multiple images if exist
            if(request()->hasFile('images')){
                $imageManager->addImages(request()->file('images'), $product);
            }
            return $product;

        }catch(\Exception $e){
            //If feaured image was uploaded and product was not saved, remove featured image from storage
            if(request()->hasFile('featured_image')){ 
                $imageManager->deleteFeaturedImage($product);
            }
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Saves product data in DB
     * @param App\Models\Product
     * @return Void
     */
    private function dbSaveProduct(Product $product){
         try{
            DB::transaction(function() use ($product){
                $product->save();
    
                //Attach categories to the product
                $product->categories()->sync(request()->categories);
                
                //Attach product features
                $features = $this->formatFeatures(request()->all());
                $product->features()->sync($features);
            }, 1);
         }catch(\Exception $e){
            abort(500, 'Database Error');
         }
    }

    /**
     * Deactivates a product and associated reviews
     * @param App\Models\Product
     * @return Void
     */
    public function deactivate(Product $product){
        try{
            $product->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Restore product and associated reviews
     * @param int $id - product id
     * @return Void
     */
    public function restore($id)
    {
        try{
            $product = Product::onlyTrashed()->where('id', $id)->first();
            $product->restore();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Delete product from db
     * @param int $id - product id
     * @return Void
     */
    public function delete($id) 
    {
        try{
            $product = Product::onlyTrashed()->where('id', $id)->with('images')->withCount('orders')->first();
            if($product->orders_count > 0){
                abort(400, 'Products that have associated sales cannot be deleted.');
            }
            (new ProductImageManager())->removeAllImages($product);
            $product->categories()->detach();
            $product->features()->detach();
            $product->forceDelete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Toggles featured product property
     * @param int $id - product id
     * @return int product featured property
     */
    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        if($product->featured == 0){
            $product->featured = 1;
        }else{
            $product->featured = 0;
        }
        $product->save();
        return $product->featured;
    }

    /**
     *  Updates product quantity
     * @param int $id - product id
     * @return Void
     */
    public function updateQuantity($id)
    {
        $product = Product::findOrFail($id);
        $product->availability = request()->newquantity;
        $product->save();
    }

    /**
     * Deletes single product image
     * @param int $imageId
     * @return Void
     */
    public function deleteImage($imageId)
    {  
        $image = ProductImages::findOrFail($imageId);
        (new ProductImageManager())->removeImage($image);
    }

    /**
     * Delete product from db
     * @param int $id - product id
     * @return Array all product images
     */
    public function updateImages($id)
    {  
        if(!request()->hasFile('images')){
            abort(400, 'No images were submitted');
        }
        $product = Product::findOrFail(intval($id));
        (new ProductImageManager())->addImages(request()->file('images'), $product);
        return $product->images->toArray(); 
    }

    /**
     * Formats product features for attachment
     * @param Array $data
     * @return Array
     */
    private function formatFeatures($data)
    {
        $options = [];
        $features = Feature::getList(); 
        foreach($features as $feature){
            $value = $data[$feature->slug];
            if(array_key_exists($feature->slug, $data) && $value != null){
                $options[$feature->id] = ['feature_value' => $value];
            }
        }
        return $options;
    }

    /**
     * Retrieves single product by slug, attaching images and reviews with their author
     * @param String $slug
     * @return App\Model\Product
     */
    public function getOneBySlug(String $slug){
        $product = Product::where('slug', $slug)->with('images')->with('reviews.user')->firstOrFail();
        $this->appendFeaturedToImages($product);   
        $this->attachFeatures($product,false);
        $product->review_count = count($product->reviews);
        return $product;
    }

    /**
     * Retrives a collection of random products related to the current by category
     * @param App\Model\Product
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProducts(Product $product){
        return Product::relatedByCategory($product)->inRandomOrder()->take(12)->get();
    }

    /**
     * Get categories with featured products in category, product count and lowest price per category
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function featuredProductsByCategory(){
        $categories = Category::whereHas('products')->with('products')->withCount('products')->get();
        foreach($categories as $key => $category){
            $category->min_price = $category->products->min('price');
            $category->products = $category->products->filter(function ($product) {
                return $product->featured == '1';
            });
            //If a category does not have featured products, remove the category
            if($category->products->isEmpty()){
               $categories->forget($key);
            }
        }
        return $categories;
    }

    /**
     * Helper function - adds featured image to product images array for slider
     * @param App\Model\Product
     * @return App\Model\Product
     */
    private function appendFeaturedToImages(Product $product)
    {
        if(count($product->images) > 0){
            $image = new Productimages();
            $image->path = $product->featured_image;
            $product->images->prepend($image);
        } 
        return $product;
    }

    /**
     * Attaches product features to the product as array
     * @param App\Models\Product
     * @param Bool $asSlug - if true, feature slug is used as array key, otherwise feature name is used
     * @return App\Models\Product
     */
    public function attachFeatures(Product $product, Bool $asSlug = false){
        $product->load(['features']);
        $featureList = [];
        foreach($product->features as $feature){
            if($asSlug){
                $featureList[$feature->slug] = $feature->pivot->feature_value;
            }else{
                $featureList[$feature->name] = formatToText($feature->pivot->feature_value);
            }
        }
        $product->feature_list = $featureList;
        return $product;
    }

    /**
     * Attach to product a list of id's of categories to which the product belongs
     * @param App\Models\Product
     * @return App\Models\Product
     */
    public function attachCategoryIds(Product $product){
        $product->category_ids = $product->categories->pluck('id')->toArray();
        return $product;
    }

}
