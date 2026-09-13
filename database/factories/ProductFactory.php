<?php
namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Product::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $name = ucwords(fake()->words(rand(2, 4), true));

    return [
      'id_product'  => strtotime(now()) . uniqid(),
      'name'        => $name,
      'slug'        => Str::slug($name) . '-' . uniqid(),
      'is_active'   => fake()->boolean(95),
      'is_featured' => fake()->boolean(25),
      'description' => fake()->paragraphs(rand(2, 4), true),
      'brand_id'    => Brand::inRandomOrder()->first()?->id_brand ?? Brand::factory(),
      'category_id' => Category::inRandomOrder()->first()?->id_category ?? Category::factory(),
      'store_id'    => Store::inRandomOrder()->first()?->id_store ?? Store::factory(),
      'created_by'  => 'factory',
      'updated_by'  => 'factory',
    ];
  }
}


