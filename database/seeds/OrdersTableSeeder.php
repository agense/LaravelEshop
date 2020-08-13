<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderProduct;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $products = Product::take(3)->get();
        $user = User::find(1);
        
        //Create test orders
        foreach($products as $product){
            $order = Order::create([
                'user_id' => $user->id,
                'order_nr' => uniqid(),
                'billing_subtotal'=> $product->price,
                'billing_tax' =>  $product->price * (config('cart.tax') / 100),
                'billing_total' => $product->price * (config('cart.tax') / 100) + $product->price,
                'billing_name' => $user->name,
                'billing_details' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => $user->address,
                    'city' => $user->city,
                    'region' => $user->region,
                    'postalcode' => $user->postalcode,
                    'phone' => $user->phone,
                ]
            ]);
            $order->delivery()->create([
                'user_id' => $user->id,
                'delivery_type' => 'in_store_pickup',
            ]);
            $order->products()->attach([
                $product->id => [
                    'user_id' => $user->id,
                    'item_price' => $product->price,
                    'quantity' => 1,
                ]
            ]);

        }
    }
}
