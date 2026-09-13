<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;

  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $name          = fake()->name();
    $username      = strtolower(fake()->userName() . '_' . uniqid());
    $is_google     = fake()->boolean(30);
    $provider_auth = $is_google ? 'google' : 'email';
    $id_auth_user  = $is_google ? fake()->numerify('10#############') : null;
    $has_photo     = fake()->boolean(75);
    $photo         = $has_photo ? 'https://i.pravatar.cc/300?u=' . md5($username) : null;

    return [
      'id_user'           => strtotime(now()) . uniqid(),
      'name'              => $name,
      'username'          => $username,
      'email'             => 'user_' . uniqid() . '_' . rand(100, 999) . '@example.com',
      'number_phone'      => '08' . fake()->numerify('##########'),
      'email_verified_at' => now(),
      'photo'             => $photo,
      'password'          => static::$password ??= Hash::make('password'),
      'provider_auth'     => $provider_auth,
      'id_auth_user'      => $id_auth_user,
      'remember_token'    => Str::random(10),
      'created_by'        => 'factory',
      'updated_by'        => 'factory',
      'deleted_by'        => null,
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified(): static
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }

  /**
   * Indicate that the user authenticated with Google.
   */
  public function google(): static
  {
    return $this->state(fn(array $attributes) => [
      'provider_auth' => 'google',
      'id_auth_user'  => fake()->numerify('10#############'),
    ]);
  }

  /**
   * Indicate that the user authenticated with Email.
   */
  public function email(): static
  {
    return $this->state(fn(array $attributes) => [
      'provider_auth' => 'email',
      'id_auth_user'  => null,
    ]);
  }

  /**
   * Indicate that the user has a custom photo.
   */
  public function withPhoto(?string $photo_url = null): static
  {
    return $this->state(fn(array $attributes) => [
      'photo' => $photo_url ?? 'https://i.pravatar.cc/300?u=' . uniqid(),
    ]);
  }

  /**
   * Indicate that the user has no photo.
   */
  public function withoutPhoto(): static
  {
    return $this->state(fn(array $attributes) => [
      'photo' => null,
    ]);
  }
}
