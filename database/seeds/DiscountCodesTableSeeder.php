<?php

use Illuminate\Database\Seeder;
use App\Models\DiscountCode;

class DiscountCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiscountCode::create($this->generateCode('TESTFIXEDCODE','fixed', 20, 7));
        DiscountCode::create($this->generateCode('TESTPERCENTCODE','percent', 10, 14));
    }

    public function generateCode(String $codeName, String $type, Int $value = 10, Int $validityDays = 7){
        return [
            'code' => $codeName,
            'type' => $type == 'fixed' ? 'fixed' : 'percent',
            'value' => $value,
            'activation_date' => now(),
            'expiration_date' => now()->addDays($validityDays),
            'public' => 1,
        ];
    }
}
