<?php
namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Owner;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $totalProducts = 2500;

    if ($this->command) {
      $this->command->info('Creating products...');
      $bar = $this->command->getOutput()->createProgressBar($totalProducts);
      $bar->start();
    }

    // 1. Pastikan minimal ada Category
    if (Category::count() === 0) {
      $this->call(CategorySeeder::class);
    }
    $categories = Category::all();

    // 2. Pastikan minimal ada Store & Owner (jika belum ada, panggil OwnerSeeder)
    if (Store::count() === 0 || Owner::count() === 0) {
      $this->call(OwnerSeeder::class);
    }
    $stores = Store::all();

    // 3. Pastikan minimal ada Brand
    if (Brand::count() === 0) {
      $this->call(BrandSeeder::class);
    }
    $brands = Brand::all();

    // Kumpulan foto produk berkualitas tinggi untuk varian
    $curatedImages = [
      'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80', // Headphones
      'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80',    // Red Shoes
      'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80', // Watch
      'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=800&q=80',    // Shoes
      'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80', // Polaroid Camera
      'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=800&q=80', // Perfume
      'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&q=80', // Gadget / headphones
      'https://images.unsplash.com/photo-1584992236310-6edddc08acff?w=800&q=80', // Tech device
      'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80',    // Kitchen / Cookware
      'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=800&q=80',    // Smartwatch
      'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=800&q=80', // Sneakers
      'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&q=80', // Sunglasses
    ];

    $colors = ['Midnight Black', 'Pearl White', 'Ocean Blue', 'Space Gray', 'Forest Green', 'Sunset Orange', 'Rose Gold'];
    $sizes  = ['S', 'M', 'L', 'XL', '128GB', '256GB', '512GB', 'Standard Edition'];

    // 4. Generate Produk
    for ($i = 1; $i <= $totalProducts; $i++) {
      $category    = $categories->random();
      $store       = $stores->random();
      $brand       = $brands->random();
      $productName = ucwords(fake()->words(rand(2, 4), true));
      $productId   = strtotime(now()) . uniqid();

      $product = Product::create([
        'id_product'  => $productId,
        'name'        => $productName,
        'slug'        => Str::slug($productName) . '-' . $i . '-' . uniqid(),
        'is_active'   => fake()->boolean(95),
        'is_featured' => fake()->boolean(25),
        'description' => fake()->paragraphs(rand(4, 6), true),
        'brand_id'    => $brand->id_brand,
        'category_id' => $category->id_category,
        'store_id'    => $store->id_store,
        'created_by'  => 'system',
        'updated_by'  => 'system',
      ]);

      // Setiap produk memiliki 1 sampai 3 varian
      $variantCount = rand(7, 9);
      for ($v = 1; $v <= $variantCount; $v++) {
        $variantId   = strtotime(now()) . uniqid();
        $color       = fake()->randomElement($colors);
        $size        = fake()->randomElement($sizes);
        $variantName = $variantCount > 1 ? "{$productName} - {$color} / {$size}" : "Default Variant";
        $basePrice   = fake()->numberBetween(25, 750) * 1000;

        $variant = ProductVariant::create([
          'id_product_variant' => $variantId,
          'name'               => $variantName,
          'slug'               => Str::slug($variantName) . '-' . $i . '-' . $v . '-' . uniqid(),
          'description'        => "Specification: Color {$color}, Size/Capacity {$size}. High durability and premium material.",
          'is_variant_active'  => fake()->boolean(95),
          'sku'                => 'SKU-' . $i . '-' . $v . '-' . strtoupper(uniqid()),
          'weight'             => fake()->numberBetween(150, 2500),
          'stock'              => fake()->numberBetween(10, 100),
          'price'              => $basePrice,
          'color'              => $color,
          'size'               => $size,
          'product_id'         => $product->id_product,
          'created_by'         => 'system',
          'updated_by'         => 'system',
        ]);


        // Setiap varian memiliki 1 sampai 3 gambar
        $imageCount     = rand(5, 9);
        $shuffledImages = fake()->randomElements($curatedImages, $imageCount);

        foreach ($shuffledImages as $imgIndex => $imgPath) {
          ProductImage::create([
            'id_product_image'   => strtotime(now()) . uniqid(),
            'image_path'         => $imgPath,
            'is_primary'         => ($imgIndex === 0), // Gambar pertama adalah primary
            'product_variant_id' => $variant->id_product_variant,
            'created_by'         => 'system',
            'updated_by'         => 'system',
          ]);
        }
      }

      if (isset($bar)) {
        $bar->advance();
      }
    }

    if (isset($bar)) {
      $bar->finish();
      $this->command->newLine();
      $this->command->info('Products created successfully!');
    }
  }
}
