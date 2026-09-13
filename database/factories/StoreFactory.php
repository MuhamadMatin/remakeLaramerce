<?php
namespace Database\Factories;

use App\Models\Owner;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Store::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id_store'     => strtotime(now()) . uniqid(),
      'name'         => fake()->company() . ' Store',
      'email'        => 'store_' . uniqid() . '_' . rand(100, 999) . '@example.com',
      'phone_number' => fake()->phoneNumber(),
      'description'  => fake()->paragraph(),
      'logo_path'    => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80',
      'owner_id'     => Owner::inRandomOrder()->first()?->id_owner ?? Owner::factory(),
      'created_by'   => 'factory',
      'updated_by'   => 'factory',
    ];
  }
}

