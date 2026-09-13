<?php
namespace Database\Factories;

use App\Models\Store;
use App\Models\StoreAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreAddress>
 */
class StoreAddressFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = StoreAddress::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id_store_address' => strtotime(now()) . uniqid(),
      'address'          => fake()->streetAddress() . ', ' . fake()->city(),
      'zip_code'         => fake()->postcode(),
      'province_id'      => fake()->numberBetween(1, 38),
      'city_id'          => fake()->numberBetween(1, 500),
      'subdistrict_id'   => fake()->numberBetween(1, 7000),
      'is_primary'       => false,
      'label'            => fake()->randomElement(['store', 'storage', 'warehouse', 'outlet']),
      'store_id'         => Store::inRandomOrder()->first()?->id_store ?? Store::factory(),
      'created_by'       => 'factory',
      'updated_by'       => 'factory',
    ];
  }
}
