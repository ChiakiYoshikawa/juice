<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            // ランダムな商品IDを選択して売上情報を挿入
            Sale::create([
                'product_id' => rand(1, 10), // 1から10までの商品IDを選択
            ]);
        }
    }
}
