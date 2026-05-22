<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Парк', 'slug' => 'park', 'badge_color' => 'blue'],
            ['name' => 'Асфальт', 'slug' => 'asfalt', 'badge_color' => 'gray'],
            ['name' => 'Здание', 'slug' => 'building', 'badge_color' => 'orange'],
            ['name' => 'Сквер', 'slug' => 'square', 'badge_color' => 'orange'],
            ['name' => 'Дороги', 'slug' => 'roads', 'badge_color' => 'gray'],
        ]);
    }
}