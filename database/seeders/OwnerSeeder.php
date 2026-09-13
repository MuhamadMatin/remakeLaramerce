<?php
namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $totalOwners = 1000;

    if ($this->command) {
      $this->command->info('Creating owners...');
      $bar = $this->command->getOutput()->createProgressBar($totalOwners);
      $bar->start();
    }

    // 1. Pastikan user tersedia
    if (User::count() < $totalOwners) {
      $needed = $totalOwners - User::count();
      User::factory($needed)->create();
    }

    $users = User::inRandomOrder()->get();

    // 2. Loop generate 100 owner bersama dengan tokonya
    for ($i = 0; $i < $totalOwners; $i++) {
      $user    = $users->get($i) ?? User::factory()->create();
      $ownerId = strtotime(now()) . uniqid();
      $storeId = strtotime(now()) . uniqid();

      // Nonaktifkan foreign key checks sementara untuk menghindari circular reference antara store dan owner
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');

      $store = Store::create([
        'id_store'     => $storeId,
        'name'         => fake()->company() . ' Store',
        'email'        => 'store_owner_' . $i . '_' . uniqid() . '@example.com',
        'phone_number' => fake()->phoneNumber(),
        'description'  => fake()->paragraph(),
        'logo_path'    => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80',
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
      $this->command->info('Owners created successfully!');
    }
  }
}
