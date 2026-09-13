<?php
namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreAddress;
use Illuminate\Database\Seeder;

class StoreAddressSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $totalAddresses = 300;

    if ($this->command) {
      $this->command->info('Creating store addresses...');
      $bar = $this->command->getOutput()->createProgressBar($totalAddresses);
      $bar->start();
    }

    // 1. Pastikan store tersedia
    if (Store::count() === 0) {
      $this->call(StoreSeeder::class);
    }

    $stores = Store::all();

    // 2. Generate 100 alamat store
    for ($i = 0; $i < $totalAddresses; $i++) {
      $store      = $stores->random();
      $hasPrimary = StoreAddress::where('store_id', $store->id_store)->where('is_primary', true)->exists();

      StoreAddress::create([
        'id_store_address' => strtotime(now()) . uniqid(),
        'address'          => fake()->streetAddress() . ', ' . fake()->city(),
        'zip_code'         => fake()->postcode(),
        'province_id'      => fake()->numberBetween(1, 38),
        'city_id'          => fake()->numberBetween(1, 500),
        'subdistrict_id'   => fake()->numberBetween(1, 7000),
        'is_primary'       => ! $hasPrimary, // Jika belum ada alamat primary, jadikan yang ini primary

        'label'            => fake()->randomElement(['store', 'storage', 'warehouse', 'outlet']),
        'store_id'         => $store->id_store,
        'created_by'       => 'system',
        'updated_by'       => 'system',
      ]);

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('Store addresses created successfully!');
    }
  }
}
