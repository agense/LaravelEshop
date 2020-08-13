<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/categories.json"; 
        $data = json_decode(file_get_contents($path), true); 

        foreach($data as $category){
            Category::create([
                'name' => $category
            ]);
        }
    }
}
