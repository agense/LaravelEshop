<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\User;

class UserWishlistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::inRandomOrder()->take(5)->get();
        $user = User::find(1);

        foreach($products as $product){
            DB::table('user_wishlist')->insert([
               'user_id' => $user->id,
               'product_id' => $product->id,
            ]);
        }
    }
}
