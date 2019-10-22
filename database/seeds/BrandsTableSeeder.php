<?php

use Illuminate\Database\Seeder;
use App\Brand; 

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Brand One',
            'slug' => 'brand-one',
        ]);
        Brand::create([
            'name' => 'Brand Two',
            'slug' => 'brand-two',
        ]);
        Brand::create([
            'name' => 'Brand Three',
            'slug' => 'brand-three',
        ]);
        Brand::create([
            'name' => 'Brand Four',
            'slug' => 'brand-four',
        ]);
        Brand::create([
            'name' => 'Brand Five',
            'slug' => 'brand-five',
        ]);
        Brand::create([
            'name' => 'Brand Six',
            'slug' => 'brand-six',
        ]);
        Brand::create([
            'name' => 'Brand Seven',
            'slug' => 'brand-seven',
        ]);
    }
}
