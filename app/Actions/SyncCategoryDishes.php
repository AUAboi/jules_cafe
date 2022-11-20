<?php

namespace App\Actions;

use App\Models\Dish;
use Illuminate\Support\Facades\DB;

class SyncCategoryDishes
{
  public function handle(Dish $dish, array $categories)
  {
    DB::transaction(function () use ($dish, $categories) {
      $selected_categories = array_column(array_filter($categories, function ($category) {
        return $category['belongs_to_program'] == true;
      }), 'id');

      $dish->categories()->detach();

      $dish->categories()->attach($selected_categories);
    });
  }
}
