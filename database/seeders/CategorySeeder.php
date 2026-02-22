<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Тарілки та миски', 'description' => 'Столові тарілки, десертні тарілки, миски, салатники'],
            ['name' => 'Скло та келихи', 'description' => 'Склянки, келихи для вина, кухли, графини'],
            ['name' => 'Чашки та чайники', 'description' => 'Чашки, склянки, чайники, кавники'],
            ['name' => 'Столові прибори', 'description' => 'Виделки, ложки, ножі, столова крица'],
            ['name' => 'Сервіз та набори', 'description' => 'Повні сервізи, набори для столу'],
            ['name' => 'Аксесуари', 'description' => 'Підставки, тримачі, серветки, підсірники'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
