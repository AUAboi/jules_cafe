<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dish::factory(10)->create();
        Category::create([
            'name' => 'Hot Coffee'
        ]);
        Category::create([
            'name' => 'Cold Coffee'
        ]);
        Category::create([
            'name' => 'Espresso'
        ]);
        Category::create([
            'name' => 'Quick Bites'
        ]);
    }
}
