<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create an admin with full administrating capabilities and superadmin role
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);
    }
}
