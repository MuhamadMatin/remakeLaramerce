<?php
namespace Database\Factories;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = ProductImage::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $sampleImages = [
      'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80',
      'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
      'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
      'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=800&q=80',
      'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80',
      'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=800&q=80',
      'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&q=80',
      'https://images.unsplash.com/photo-1584992236310-6edddc08acff?w=800&q=80',
      'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80',
    ];

    return [
      'id_product_image'   => strtotime(now()) . uniqid(),
      'image_path'         => fake()->randomElement($sampleImages),
      'is_primary'         => false,
      'product_variant_id' => ProductVariant::inRandomOrder()->first()?->id_product_variant ?? ProductVariant::factory(),
      'created_by'         => 'factory',
      'updated_by'         => 'factory',
    ];
  }
}
