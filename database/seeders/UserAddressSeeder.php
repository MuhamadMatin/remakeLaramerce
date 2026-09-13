<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $totalAddresses = 100;

    if ($this->command) {
      $this->command->info('Creating user addresses...');
      $bar = $this->command->getOutput()->createProgressBar($totalAddresses);
      $bar->start();
    }

    // 1. Pastikan user tersedia
    if (User::count() === 0) {
      $this->call(UserSeeder::class);
    }

    $users = User::all();

    // 2. Generate 100 alamat user
    for ($i = 0; $i < $totalAddresses; $i++) {
      $user       = $users->random();
      $hasPrimary = UserAddress::where('user_id', $user->id_user)->where('is_primary', true)->exists();

      UserAddress::create([
        'id_user_address' => strtotime(now()) . uniqid(),
        'address'         => fake()->streetAddress() . ', ' . fake()->city(),
        'zip_code'        => fake()->postcode(),
        'province_id'     => fake()->numberBetween(1, 38),
        'city_id'         => fake()->numberBetween(1, 500),
        'subdistrict_id'  => fake()->numberBetween(1, 7000),
        'is_primary'      => ! $hasPrimary, // Jika belum ada alamat primary, jadikan yang ini primary

        'label'           => fake()->randomElement(['home', 'office', 'apartment', 'main']),
        'user_id'         => $user->id_user,
        'created_by'      => 'system',
        'updated_by'      => 'system',
      ]);

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('User addresses created successfully!');
    }
  }
}
