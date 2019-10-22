<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Settings Table Seeder
        $this->call(SettingsTableSeeder::class);

        //Users Table Seeder
        $this->call(UsersTableSeeder::class);
        
        //Asministators Table Seeder
        $this->call(AdminTableSeeder::class);
        
        //Categories Table Seeder
        $this->call(CategoriesTableSeeder::class);

        //Brands Table Seeder
        $this->call(BrandsTableSeeder::class);

        //Products Table Seeder
        $this->call(ProductsTableSeeder::class);

        //Product Images Table Seeder
        $this->call(ProductImagesTableSeeder::class);

        //Coupons Table Seeder
        $this->call(CouponsTableSeeder::class);

        //Pages Table Seeder
        $this->call(PagesTableSeeder::class);
        
        //Test Orders Table Seeder
        $this->call(OrdersTableSeeder::class);

        //Reviews Table Seeder
        $this->call(ReviewsTableSeeder::class);

        //Whishlist Table Seeder
        $this->call(UserWishlistTableSeeder::class);


    }
}
