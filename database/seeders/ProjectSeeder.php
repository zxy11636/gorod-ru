<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'user_id' => 1,
                'category_id' => 1, // Парк
                'city' => 'Воронеж',
                'region' => 'Центральный район',
                'title' => 'Петровская набережная',
                // ... остальные поля
            ],
            [
                'user_id' => 1,
                'category_id' => 2, // Асфальт
                'city' => 'Воронеж',
                'region' => 'Северный район',
                'title' => 'Новый асфальт на ул. Независимости',
                // ... остальные поля
            ],
            // и так далее
        ];
    }
}