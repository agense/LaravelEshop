<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create test users
        User::create([
            'name' => 'Test User',
            'email' => 'testuser@test.com',
            'password' => Hash::make('secret'),
            'phone' => '000000000',
            'address' => 'Any Str. 99',
            'city' => 'Any City',
            'region' => 'Any Region',
            'postalcode' => '000000',
        ]);
    }
}
