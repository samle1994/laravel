<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
class ProductsSeeder extends Seeder
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
            'name' => 'Tên sản phẩm 1',
            'price' => '300000',
            'type' => 'product',
            'is_status' =>'1',
            'created_at' => time(),

        ],
        [
            'name' => 'Tên sản phẩm 2',
            'price' => '300000',
            'type' => 'product',
            'is_status' =>'1',
            'created_at' => time(),
        ],
        [
            'name' => 'Tên sản phẩm 3',
            'price' => '500000',
            'type' => 'product',
            'is_status' =>'1',
            'created_at' => time(),
        ]
        ];
        foreach($data as $v) {
            Products::create($v);
        }
    }
}