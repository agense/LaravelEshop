<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'site_name' => 'Laravel Ecom',
            'email_primary' => 'assistance@test.com',
            'email_secondary' => 'manager@test.com',
            'phone_primary' => '+300 000 000 00',
            'phone_secondary' => '+300 000 000 00',
            'address' => 'Any Str. 99, Any City',
            'currency' => 'EUR',
            'first_slide_title' => 'Laravel Ecommerce',
            'first_slide_subtitle' =>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo perferendis obcaecati architecto.',
            'first_slide_btn_text' => 'Shop Now',
            'first_slide_btn_link' => 'http://lrecom.local/shop',
            'second_slide_title' => 'Laravel Ecommerce',
            'second_slide_subtitle' =>'Totam quis reprehenderit debitis modi, voluptatem fugit molestias. Debitis non assumenda magni consequatur repudiandae ab',
            'second_slide_btn_text' => 'Shop Now',
            'second_slide_btn_link' => 'http://lrecom.local/shop',
        ]);
    }
}
