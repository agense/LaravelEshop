<?php

use Illuminate\Database\Seeder;
use App\Product; 
use App\ProductImages; 

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Laptops
        ProductImages::create([
            'product_id' => 3,
            'path' => "laptop-1-image-5d1e21016d9c5.jpg",
        ]);
        ProductImages::create([
            'product_id' => 3,
            'path' => "laptop-1-image-5d1e287bccb3d.jpg",
        ]);
        ProductImages::create([
            'product_id' => 4,
            'path' => "laptop-2-image-5d1e2c36eb213.jpg",
        ]);
        ProductImages::create([
            'product_id' => 4,
            'path' => "laptop-2-image-5d1e22bcc2a8b.jpg",
        ]);
        ProductImages::create([
            'product_id' => 4,
            'path' => "laptop-2-image-5d1e289d03047.jpg",
        ]);
        ProductImages::create([
            'product_id' => 5,
            'path' => "laptop-2-image-5d1e289d03047.jpg",
        ]);
        ProductImages::create([
            'product_id' => 5,
            'path' => "laptop-3-image-5d1e2787b7f5d.jpg",
        ]);
        ProductImages::create([
            'product_id' => 6,
            'path' => "laptop-2-image-5d1e289d03047.jpg",
        ]);
        ProductImages::create([
            'product_id' => 6,
            'path' => "laptop-1-image-5d1e21016d9c5.jpg",
        ]);

        //Desktops
        ProductImages::create([
            'product_id' => 12,
            'path' => "desktop-1-image-5d1e28e8a8de7.png",
        ]);
        ProductImages::create([
            'product_id' => 13,
            'path' => "desktop-2-image-5d1e228fe9956.png",
        ]);
        ProductImages::create([
            'product_id' => 14,
            'path' => "desktop-1-image-5d1e28e8a8de7.png",
        ]);
        //Tablets
        ProductImages::create([
            'product_id' => 16,
            'path' => "tablet-1-image-5d1a43b17d0fb.png",
        ]);
        ProductImages::create([
            'product_id' => 16,
            'path' => "tablet-1-image-5d1e21ede1b4a.jpg",
        ]);
        ProductImages::create([
            'product_id' => 16,
            'path' => "tablet-1-image-5d1e21fa83e34.png",
        ]);
        ProductImages::create([
            'product_id' => 18,
            'path' => "tablet-3-image-5d1e29174eb33.png",
        ]);
        ProductImages::create([
            'product_id' => 18,
            'path' => "tablet-3-image-5d1e2917992ac.png",
        ]);
        ProductImages::create([
            'product_id' => 20,
            'path' => "tablet-1-image-5d1e21fa83e34.png",
        ]);
        //Phones
        ProductImages::create([
            'product_id' => 27,
            'path' => "phone-4-image-5d1e299a51fe8.jpg",
        ]);
        ProductImages::create([
            'product_id' => 27,
            'path' => "phone-4-image-5d1e299a73330.jpg",
        ]);
        ProductImages::create([
            'product_id' => 28,
            'path' => "phone-5.png",
        ]);
        ProductImages::create([
            'product_id' => 28,
            'path' => "phone-5-image-5d1e2d9e46b6c.jpeg",
        ]);
        ProductImages::create([
            'product_id' => 28,
            'path' => "phone-5-image-5d1e2d9e7076d.jpeg",
        ]);
        ProductImages::create([
            'product_id' => 29,
            'path' => "phone-6-image-5d1e2deff3f95.jpg",
        ]);      
    }
}
