<?php

use Illuminate\Database\Seeder;
use App\Models\Brand; 

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
        foreach($data as $count){
            Brand::create([
                'name' => 'Brand '.$count
            ]);
        }
    }
}
