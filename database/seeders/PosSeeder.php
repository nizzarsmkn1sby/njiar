<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee'],
            ['name' => 'Tea'],
            ['name' => 'Bakery'],
            ['name' => 'Dessert'],
        ];

        foreach ($categories as $cat) {
            $category = \App\Models\Category::create($cat);

            if ($cat['name'] == 'Coffee') {
                $items = [
                    ['name' => 'Coffee Latte', 'price' => 24000, 'stock' => 50],
                    ['name' => 'Americano', 'price' => 20000, 'stock' => 50],
                    ['name' => 'Cappuccino', 'price' => 26000, 'stock' => 40],
                    ['name' => 'Espresso', 'price' => 15000, 'stock' => 100],
                    ['name' => 'Caramel Macchiato', 'price' => 32000, 'stock' => 30],
                ];
                foreach($items as $item) \App\Models\Product::create(array_merge($item, ['category_id' => $category->id]));
            }

            if ($cat['name'] == 'Tea') {
                $items = [
                    ['name' => 'Matcha Latte', 'price' => 28000, 'stock' => 45],
                    ['name' => 'Earl Grey', 'price' => 22000, 'stock' => 60],
                    ['name' => 'Lemon Tea', 'price' => 18000, 'stock' => 80],
                ];
                foreach($items as $item) \App\Models\Product::create(array_merge($item, ['category_id' => $category->id]));
            }

            if ($cat['name'] == 'Bakery') {
                $items = [
                    ['name' => 'Butter Croissant', 'price' => 18000, 'stock' => 20],
                    ['name' => 'Chocolate Pain', 'price' => 22000, 'stock' => 15],
                    ['name' => 'Cheese Danish', 'price' => 24000, 'stock' => 12],
                ];
                foreach($items as $item) \App\Models\Product::create(array_merge($item, ['category_id' => $category->id]));
            }

            if ($cat['name'] == 'Dessert') {
                $items = [
                    ['name' => 'Tiramisu', 'price' => 35000, 'stock' => 10],
                    ['name' => 'Cheesecake', 'price' => 38000, 'stock' => 8],
                    ['name' => 'Brownies', 'price' => 20000, 'stock' => 25],
                ];
                foreach($items as $item) \App\Models\Product::create(array_merge($item, ['category_id' => $category->id]));
            }
        }
    }
}
