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

        //Asministators Table Seeder
        $this->call(AdminTableSeeder::class);

        //Users Table Seeder
        $this->call(UsersTableSeeder::class);

        //Slider Table Seeder
        $this->call(SliderTableSeeder::class);

        //Pages Table Seeder
        $this->call(PagesTableSeeder::class);
        
        //Categories Table Seeder
        $this->call(CategoriesTableSeeder::class);

        //Brands Table Seeder
        $this->call(BrandsTableSeeder::class);
            
        //Features Table Seeder
        $this->call(FeaturesTableSeeder::class);

        //Products Table Seeder
        $this->call(ProductsTableSeeder::class);

        //Whishlist Table Seeder
        $this->call(UserWishlistTableSeeder::class);

        //Test Discount Codes Table Seeder
        $this->call(DiscountCodesTableSeeder::class);

        //Test Orders Table Seeder
        $this->call(OrdersTableSeeder::class);

        //Reviews Table Seeder
        $this->call(ReviewsTableSeeder::class);
        
    }

}
