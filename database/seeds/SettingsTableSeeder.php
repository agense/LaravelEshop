<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

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
            'logo' => 'logo-default.png',
            'currency' => 'EUR',
            'tax_rate' => 0,
            'tax_included' => 0,
            'email_primary' => 'assistance@test.com',
            'email_secondary' => 'manager@test.com',
            'phone_primary' => '+300 000 000 00',
            'phone_secondary' => '+300 000 000 00',
            'address' => 'Any Str. 99, Any City',
        ]);
    }
}
