<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Кирпич красный М150', 'quantity' => 500],
            ['name' => 'Цемент М500', 'quantity' => 120],
            ['name' => 'Песок строительный', 'quantity' => 1000],
            ['name' => 'Арматура А500С 12мм', 'quantity' => 300],
            ['name' => 'Пеноблок 600x300x200', 'quantity' => 450],
            ['name' => 'Штукатурка гипсовая 30кг', 'quantity' => 80],
            ['name' => 'Краска фасадная белая 10л', 'quantity' => 25],
            ['name' => 'Лист ОСБ 1220x2440x9', 'quantity' => 150],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}