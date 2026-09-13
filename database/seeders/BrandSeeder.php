<?php
namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $brands = [
      [
        'name'        => 'Apple',
        'description' => 'Innovative consumer electronics, software, and online services.',
        'image_path'  => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&q=80',
      ],
      [
        'name'        => 'Samsung',
        'description' => 'Global leader in mobile phones, displays, semiconductors, and home appliances.',
        'image_path'  => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&q=80',
      ],
      [
        'name'        => 'Sony',
        'description' => 'Pioneer in audio, video, gaming consoles, and professional cameras.',
        'image_path'  => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80',
      ],
      [
        'name'        => 'Nike',
        'description' => 'World-renowned athletic footwear, apparel, equipment, and accessories.',
        'image_path'  => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80',
      ],
      [
        'name'        => 'Adidas',
        'description' => 'Iconic sportswear brand empowering athletes and street fashion culture.',
        'image_path'  => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=400&q=80',
      ],
      [
        'name'        => 'Asus',
        'description' => 'Top-tier motherboards, gaming laptops, and high-performance PC hardware.',
        'image_path'  => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&q=80',
      ],
      [
        'name'        => 'Logitech',
        'description' => 'Premium computer peripherals, streaming devices, and gaming gear.',
        'image_path'  => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&q=80',
      ],
      [
        'name'        => 'Xiaomi',
        'description' => 'Smartphones, smart home IoT ecosystem, and lifestyle technology products.',
        'image_path'  => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400&q=80',
      ],
      [
        'name'        => 'Puma',
        'description' => 'Fast athletic brand delivering dynamic sports performance and lifestyle gear.',
        'image_path'  => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=400&q=80',
      ],
      [
        'name'        => 'LG',
        'description' => 'Life is Good with cutting-edge OLED televisions, monitors, and smart electronics.',
        'image_path'  => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=400&q=80',
      ],
    ];

    if ($this->command) {
      $this->command->info('Creating brands...');
      $bar = $this->command->getOutput()->createProgressBar(count($brands));
      $bar->start();
    }

    foreach ($brands as $brand) {
      Brand::updateOrCreate(
        ['slug' => Str::slug($brand['name'])],
        [
          'id_brand'    => strtotime(now()) . uniqid(),
          'name'        => $brand['name'],
          'image_path'  => $brand['image_path'],
          'description' => $brand['description'],
          'created_by'  => 'system',
          'updated_by'  => 'system',
        ]
      );

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('Brands created successfully!');
    }
  }
}
