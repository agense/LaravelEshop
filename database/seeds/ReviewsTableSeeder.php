<?php

use Illuminate\Database\Seeder;
use App\Review;
use App\User;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('id', 1)->with('orders.products')->first();
        foreach($user->orders as $order){
            foreach($order->products as $product){
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'review' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur fugiat iste animi voluptate excepturi officiis quas eveniet porro, dolor incidunt quibusdam. ',
                    'rating' => rand(1, 5),
                ]);
            }
        }
    }
}
