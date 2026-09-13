<?php
namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $totalStores = 100;

    if ($this->command) {
      $this->command->info('Creating stores...');
      $bar = $this->command->getOutput()->createProgressBar($totalStores);
      $bar->start();
    }

    // 1. Pastikan user tersedia
    if (User::count() < $totalStores) {
      $needed = $totalStores - User::count();
      User::factory($needed)->create();
    }

    $users = User::inRandomOrder()->get();

    // Kumpulan logo toko sampel
    $sampleLogos = [
      'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80',
      'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200&q=80',
      'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&q=80',
      'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=200&q=80',
      'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=200&q=80',
    ];

    // 2. Generate 100 Store lengkap dengan relasi Owner
    for ($i = 0; $i < $totalStores; $i++) {
      $user    = $users->get($i) ?? User::factory()->create();
      $storeId = strtotime(now()) . uniqid();
      $ownerId = strtotime(now()) . uniqid();

      // Nonaktifkan foreign key checks sementara untuk menghindari circular reference antara store dan owner
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');

      $store = Store::create([
        'id_store'     => $storeId,
        'name'         => fake()->company() . ' ' . fake()->randomElement(['Official', 'Store', 'Shop', 'Direct', 'Outlet', 'Hub']),
        'email'        => 'store_' . $i . '_' . uniqid() . '@example.com',
        'phone_number' => fake()->phoneNumber(),
        'description'  => fake()->paragraph(),
        'logo_path'    => fake()->randomElement($sampleLogos),
        'owner_id'     => $ownerId,
        'created_by'   => 'system',
        'updated_by'   => 'system',
      ]);


      Owner::create([
        'id_owner'   => $ownerId,
        'user_id'    => $user->id_user,
        'store_id'   => $store->id_store,
        'created_by' => 'system',
        'updated_by' => 'system',
      ]);

      DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('Stores created successfully!');
    }
  }
}
