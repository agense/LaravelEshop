<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Product;
use App\User;
use App\OrderProduct;

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
                'order_status' => '0',
                'billing_email' => $user->email,
                'billing_name' => $user->name,
                'billing_address' => $user->address,
                'billing_city' => $user->city,
                'billing_region' => $user->region,
                'billing_postalcode' => $user->postalcode,
                'billing_phone' => $user->phone,
                'billing_subtotal'=> $product->price,
                'billing_tax' =>  $product->price * (config('cart.tax') / 100),
                'billing_total' => $product->price * (config('cart.tax') / 100) + $product->price,
                'paid' => 0,
                'payment_type' => 'cash',
                'delivered' => 0,
            ]);
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'item_price' => $product->price,
                'quantity' => 1,
            ]);

        }
    }
}
