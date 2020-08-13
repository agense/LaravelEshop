<?php

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => config('app.name'),
                'subtitle' =>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo perferendis obcaecati architecto.',
                'link_text' => 'Shop Now',
                'link' => url('/shop'),
                'image' => 'default-slide-1.jpg',
            ],
            [
                'title' => config('app.name'),
                'subtitle' =>'Totam quis reprehenderit debitis modi, voluptatem fugit molestias. Debitis non assumenda magni consequatur repudiandae ab',
                'link_text' => 'Shop Now',
                'link' => url('/shop'),
                'image' => 'default-slide-2.png',
            ]
        ];
        foreach($data as $slide){
            Slider::create($slide);
        }
    }
}
