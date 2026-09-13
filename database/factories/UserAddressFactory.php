<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAddress>
 */
class UserAddressFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = UserAddress::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id_user_address' => strtotime(now()) . uniqid(),
      'address'         => fake()->streetAddress() . ', ' . fake()->city(),
      'zip_code'        => fake()->postcode(),
      'province_id'     => fake()->numberBetween(1, 38),
      'city_id'         => fake()->numberBetween(1, 500),
      'subdistrict_id'  => fake()->numberBetween(1, 7000),
      'is_primary'      => false,
      'label'           => fake()->randomElement(['home', 'office', 'apartment', 'main']),
      'user_id'         => User::inRandomOrder()->first()?->id_user ?? User::factory(),
      'created_by'      => 'factory',
      'updated_by'      => 'factory',
    ];
  }
}
