<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Feature;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    private $features;
    private $categories;
    private $brandCount;

    public function __construct(){
        $this->features = Feature::all();
        $this->categories = Category::all();
        $this->brandCount =  DB::table('brands')->count();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //Laptops
        $this->createProducts(10, 'Laptop', 2);

        //Desktops
        $this->createProducts(5, 'Desktop', 1);

        //Tablets
        $this->createProducts(9, 'Tablet', 2);

        //Mobile Phones
        $this->createProducts(10, 'Phone', 1, 'Mobile Phones');
    }
    /**
     * @param Int $count - a number of products to be created
     * @param String $name - a name prefix for the product
     * @param Int $addImgCount (optional)-  a number of featured images to be created
     * @param String $catName (optional)- the name of the category to be attached to the product
     * @return Void
     */
    private function createProducts(Int $count, String $name, Int $addImgCount = 0, String $catName = "")
    {
        for($i = 1; $i < $count; $i++){

            $product = Product::create($this->formatProduct($name, $i));

            //Attach category
            $categoryName = $catName !== "" ? $catName : str_plural(ucfirst($name));
            $catId = $this->categories->firstWhere('name', $categoryName);
            if($catId instanceof Category){
                $product->categories()->attach($catId->id);
            }

            //Attach product features
            $product->features()->attach($this->setFeatures());

            //Attach featured images
            if(intval($addImgCount) > 0 && $i <= $addImgCount){
                $product->images()->createMany($this->setImages(strtolower($name), $i, $addImgCount));
            }
        }
    }

    //Helper functions
    private function formatProduct(String $name, Int $i){
        return [
            'name' => ucfirst($name).' '.$i,
            'price' => rand(949, 2499),
            'availability' => rand(1, 5),
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam.",
            'featured' => rand(0, 1),
            'featured_image' => strtolower($name).'-'.$i.'-img-1.png',
            'brand_id' => rand(1, $this->brandCount),
        ];
    }

    private function setFeatures(){
        $featureArr = [];
        foreach($this->features as $item){
            $featureArr[$item->id] = [
                'feature_value' => $item->options[array_rand($item->options, 1)]
            ];
        }
        return $featureArr;
    }

    private function setImages($prefix, $i, $imageCount){
        $arr = [];
        for($j = 1; $j <= $imageCount; $j++ ){
            $arr[] = ['path' => $prefix."-".$i."-img-".($j+1).".png"];
        }
        return $arr;
    }
}
