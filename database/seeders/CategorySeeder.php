<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Парки и скверы', 'slug' => 'parks'],
            ['name' => 'Дороги и тротуары', 'slug' => 'roads'],
            ['name' => 'Здания и фасады', 'slug' => 'buildings'],
            ['name' => 'Спортивные объекты', 'slug' => 'sport'],
            ['name' => 'Культурные объекты', 'slug' => 'culture'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}