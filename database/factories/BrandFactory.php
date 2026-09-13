<?php
namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Brand::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $brand_name = ucwords(fake()->unique()->words(rand(1, 2), true));
    $logos = [
      'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=300&q=80',
      'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=300&q=80',
      'https://images.unsplash.com/photo-1516876437184-593fda40c7ce?w=300&q=80',
      'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&q=80',
      'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&q=80',
    ];

    return [
      'id_brand'    => strtotime(now()) . uniqid(),
      'name'        => $brand_name,
      'slug'        => Str::slug($brand_name) . '-' . uniqid(),
      'image_path'  => fake()->randomElement($logos),
      'description' => fake()->paragraph(),
      'created_by'  => 'factory',
      'updated_by'  => 'factory',
    ];
  }
}
