<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        'name'        => 'Electronics',
        'description' => 'Devices, gadgets, and tech accessories.',
      ],
      [
        'name'        => 'Fashion & Apparel',
        'description' => 'Clothing, footwear, and fashion accessories.',
      ],
      [
        'name'        => 'Home & Garden',
        'description' => 'Furniture, decor, tools, and gardening supplies.',
      ],
      [
        'name'        => 'Sports & Outdoors',
        'description' => 'Sporting goods, fitness equipment, and outdoor gear.',
      ],
      [
        'name'        => 'Books & Media',
        'description' => 'Books, magazines, audiobooks, and multimedia.',
      ],
      [
        'name'        => 'Beauty & Personal Care',
        'description' => 'Cosmetics, skincare, hair care, and fragrances.',
      ],
      [
        'name'        => 'Toys & Games',
        'description' => 'Toys, board games, puzzles, and video games.',
      ],
      [
        'name'        => 'Automotive',
        'description' => 'Car parts, tools, accessories, and maintenance items.',
      ],
      [
        'name'        => 'Health & Wellness',
        'description' => 'Vitamins, supplements, and health monitoring devices.',
      ],
      [
        'name'        => 'Pet Supplies',
        'description' => 'Food, toys, and care products for pets.',
      ],
    ];

    if ($this->command) {
      $this->command->info('Creating categories...');
      $bar = $this->command->getOutput()->createProgressBar(count($categories));
      $bar->start();
    }

    foreach ($categories as $category) {
      Category::updateOrCreate(
        ['slug' => Str::slug($category['name'])],
        [
          'id_category' => strtotime(now()) . uniqid(),
          'name'        => $category['name'],
          'description' => $category['description'],
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
      $this->command->info('Categories created successfully!');
    }
  }
}
