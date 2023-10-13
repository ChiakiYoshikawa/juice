<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->insert([
            [
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => null,
              'company_name' => 'Coca-Cola',
              'street_address' => '滋賀県守山市',
              'representative_name' => 'ホルヘ',
            ],
            [
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => null,
              'company_name' => 'サントリーフーズ',
              'street_address' => '大阪市北区',
              'representative_name' => '佐治信忠',
            ],
            [
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => null,
              'company_name' => '大塚製薬',
              'street_address' => '東京都千代田区',
              'representative_name' => '井上眞',
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'company_name' => 'アサヒ飲料',
                'street_address' => '墨田区吾妻橋',
                'representative_name' => '関信彦',
              ],
              [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'company_name' => '伊藤園',
                'street_address' => '東京都渋谷区本町',
                'representative_name' => '本庄大介',
              ],
              [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'company_name' => 'キリン',
                'street_address' => '東京都中野区中野',
                'representative_name' => '磯崎功典',
              ],

          ]);
    }
}
