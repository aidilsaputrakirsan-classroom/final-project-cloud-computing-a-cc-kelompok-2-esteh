<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Transfer Bank', 'code' => 'BANK'],
            ['name' => 'Dana', 'code' => 'DANA'],
            ['name' => 'OVO', 'code' => 'OVO'],
            ['name' => 'Cash on Delivery', 'code' => 'COD'],
        ];

        foreach ($methods as $m) {
            PaymentMethod::updateOrCreate(['code' => $m['code']], $m);
        }
    }
}
