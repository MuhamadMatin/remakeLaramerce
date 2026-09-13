<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Category::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $name = ucwords(fake()->words(rand(1, 3), true));

    return [
      'id_category' => strtotime(now()) . uniqid(),
      'name'        => $name,
      'slug'        => Str::slug($name) . '-' . uniqid(),
      'description' => fake()->paragraph(),
      'created_by'  => 'factory',
      'updated_by'  => 'factory',
    ];
  }
}


