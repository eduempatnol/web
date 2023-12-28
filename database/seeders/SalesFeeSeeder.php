<?php

namespace Database\Seeders;

use App\Models\SalesFee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = new SalesFee();
        $sales->type = "percentage";
        $sales->value = 30;
        $sales->save();
    }
}
