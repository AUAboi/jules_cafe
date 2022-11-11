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
            'name' => 'Desserts'
        ]);
        Category::create([
            'name' => 'Fast Food'
        ]);
        Category::create([
            'name' => 'Drinks'
        ]);
    }
}
