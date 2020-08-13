<?php

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/product_features.json"; 
        $data = json_decode(file_get_contents($path), true);

        foreach($data as $feature){
            Feature::create([
                'name' => $feature['name'],
                'options' => $feature['options']
            ]);
        }  
    }
}
