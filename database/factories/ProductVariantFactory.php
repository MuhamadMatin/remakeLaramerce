<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = ProductVariant::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $colors = ['Black', 'White', 'Navy Blue', 'Silver', 'Space Gray', 'Crimson Red', 'Emerald Green', 'Gold'];
    $sizes  = ['S', 'M', 'L', 'XL', '256GB', '512GB', '1TB', 'Standard', 'Plus', 'Pro'];

    $color = fake()->randomElement($colors);
    $size  = fake()->randomElement($sizes);
    $name  = "Variant - {$color} / {$size}";

    return [
      'id_product_variant' => strtotime(now()) . uniqid(),
      'name'               => $name,
      'slug'               => Str::slug($name) . '-' . uniqid(),
      'description'        => fake()->sentence(),
      'is_variant_active'  => fake()->boolean(95),
      'sku'                => 'SKU-' . strtoupper(uniqid()) . '-' . rand(100, 999),
      'weight'             => fake()->numberBetween(100, 2500),
      'stock'              => fake()->numberBetween(5, 100),
      'price'              => fake()->numberBetween(15, 600) * 1000,
      'color'              => $color,
      'size'               => $size,
      'product_id'         => Product::inRandomOrder()->first()?->id_product ?? Product::factory(),
      'created_by'         => 'factory',
      'updated_by'         => 'factory',
    ];
  }
}


