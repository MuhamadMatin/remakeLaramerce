<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $total_users = 700;

    // Buat akun admin jika belum ada
    User::firstOrCreate(
      ['email' => 'admin@gmail.com'],
      [
        'id_user'           => strtotime(now()) . uniqid(),
        'name'              => 'Admin Laramerce',
        'username'          => 'admin',
        'number_phone'      => '081234567890',
        'email_verified_at' => now(),
        'photo'             => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&auto=format&fit=crop&q=80',
        'password'          => Hash::make('passwordadmin'),
        'provider_auth'     => 'email',
        'id_auth_user'      => null,
        'remember_token'    => Str::random(10),
        'created_by'        => 'seeder',
        'updated_by'        => 'seeder',
      ]
    );

    // Buat akun demo biasa jika belum ada
    User::firstOrCreate(
      ['email' => 'user@gmail.com'],
      [
        'id_user'           => strtotime(now()) . uniqid(),
        'name'              => 'Demo User',
        'username'          => 'user',
        'number_phone'      => '081298765432',
        'email_verified_at' => now(),
        'photo'             => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
        'password'          => Hash::make('passworduser'),
        'provider_auth'     => 'email',
        'id_auth_user'      => null,
        'remember_token'    => Str::random(10),
        'created_by'        => 'seeder',
        'updated_by'        => 'seeder',
      ]
    );

    // Buat akun demo Google OAuth jika belum ada
    User::firstOrCreate(
      ['email' => 'google@gmail.com'],
      [
        'id_user'           => strtotime(now()) . uniqid(),
        'name'              => 'Google User',
        'username'          => 'google_user',
        'number_phone'      => '081311223344',
        'email_verified_at' => now(),
        'photo'             => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
        'password'          => Hash::make('passwordgoogle'),
        'provider_auth'     => 'google',
        'id_auth_user'      => '10987654321098765',
        'remember_token'    => Str::random(10),
        'created_by'        => 'seeder',
        'updated_by'        => 'seeder',
      ]
    );

    if ($this->command) {
      $this->command->info('Creating additional users with factory...');
      $bar = $this->command->getOutput()->createProgressBar($total_users);
      $bar->start();
    }

    // Generate user acak menggunakan factory
    for ($i = 1; $i <= $total_users; $i++) {
      User::factory()->create();

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('Users created successfully!');
    }
  }
}
