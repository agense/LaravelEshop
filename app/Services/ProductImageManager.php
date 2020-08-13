<?php
namespace App\Services;
use App\Services\ImageUploader;
use App\Models\Product;
use App\Models\ProductImages;

class ProductImageManager extends ImageUploader
{

    public function __construct()
    {
        parent::__construct(Product::getImageUploadPath(), 640, 480);
    }

     /**
     * Upload products featured image to file system
     * @param  $file
     * @param \App\Models\Product $product
     * @return Void
     */
    public function uploadFeaturedImage($file, Product $product)
    { 
        $this->upload($file, $product->slug.'_featured');
    }

    /**
     * Deletes products featured image from storage if exists
     * @return Void
     */
    public function deleteFeaturedImage(Product $product){
        if($product->featured_image !== null){
            $this->delete($product->featured_image);
        }
    }

    /**
     * Upload multiple images to file system and save filenames in DB
     * @param Array $images
     * @param \App\Models\Product $product
     * @return Void
     */
    public function addImages(Array $images, Product $product)
    {
        foreach($images as $img){
            $this->upload($img, $product->slug);
            $image = $this->getFilename();
            $product->images()->create([
                'path' => $image,
            ]);
        }
    }

    /**
     * Delete a product image from file system and DB
     * @param \App\Models\ProductImages $image
     * @return Bool
     */
    public function removeImage(ProductImages $image)
    {
           if($this->delete($image->path)){
               $image->delete();
                return true;
           }
           return false;       
    }

    /**
     * Delete all product images and product featured image from file system and DB
     * @param \App\Models\Product $product
     * @return Void
     */
    public function removeAllImages(Product $product)
    {
        //Delete all images from storage
        foreach($product->images as $image){   
            $this->delete($image->path);
        }
        //Delete featured image from storage if exists
        $this->deleteFeaturedImage($product);

        //Delete all images from db
        $product->images()->delete();
    }
}