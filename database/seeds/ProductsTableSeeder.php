<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Laptops
        for($i = 1; $i < 10; $i++){
            Product::create([
                'name' => 'Laptop '.$i,
                'slug' => 'laptop-'.$i,
                'details' => [13,14,15][array_rand([13,14,15])].' inch ,'. [1,2,3][array_rand([1,2,3])] .' SSD, 32GB RAM',
                'price' => rand(94999, 249999),
                'availability' => rand(1, 5),
                'description' => 'Lorem '.$i.' ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam.',
                'featured' => rand(0, 1),
                'featured_image' => 'laptop-'.$i.'.png',
                'brand_id' => rand(1, 7),
            ])->categories()->attach(1);
        }
        //Desktops
        for($i = 1; $i < 5; $i++){
            Product::create([
                'name' => 'Desktop '.$i,
                'slug' => 'desktop-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].' inch ,'.[1,2,3][array_rand([1,2,3])].' SSD, 32GB RAM',
                'price' => rand(100999, 219999),
                'availability' => rand(1, 5),
                'description' => 'Lorem '.$i.' ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam.',
                'featured' => rand(0, 1),
                'featured_image' => 'desktop-'.$i.'.png',
                'brand_id' => rand(1, 7),
            ])->categories()->attach(2);
        }

        //Tablets
        for($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Tablet '.$i,
                'slug' => 'tablet-'.$i,
                'details' => [7,8,9,10][array_rand([7,8,9,10])].' inch ,'. [4,8,16][array_rand([4,8,16])] .' GB RAM',
                'price' => rand(90999, 219999),
                'availability' => rand(1, 5),
                'description' => 'Lorem '.$i.' ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam.',
                'featured' => rand(0, 1),
                'featured_image' => 'tablet-'.$i.'.png',
                'brand_id' => rand(1, 7),
            ])->categories()->attach(3);
        }

        //Mobile Phones
        for($i = 1; $i < 10; $i++){
            Product::create([
                'name' => 'Phone '.$i,
                'slug' => 'phone-'.$i,
                'details' => [5,6,7][array_rand([5,6,7])].' inch ,'. [2,3,4,8][array_rand([2,3,4,8])] .' GB RAM',
                'price' => rand(91999, 219999),
                'availability' => rand(1, 5),
                'description' => 'Lorem '.$i.' ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam.',
                'featured' => rand(0, 1),
                'featured_image' => 'phone-'.$i.'.png',
                'brand_id' => rand(1, 7),
            ])->categories()->attach(4);
        }
    }
}
