<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'PAKET A',
                'price' => 10000
            ],
            [
                'name' => 'PAKET B',
                'price' => 20000
            ],
            [
                'name' => 'PAKET C',
                'price' => 30000
            ]
        ];

        Price::insert($data);
    }
}
