<?php
namespace Database\Factories;

use App\Models\Owner;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Owner>
 */
class OwnerFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Owner::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id_owner'   => strtotime(now()) . uniqid(),
      'user_id'    => User::inRandomOrder()->first()?->id_user ?? User::factory(),
      'store_id'   => Store::inRandomOrder()->first()?->id_store ?? Store::factory(),
      'created_by' => 'factory',
      'updated_by' => 'factory',
    ];
  }
}
