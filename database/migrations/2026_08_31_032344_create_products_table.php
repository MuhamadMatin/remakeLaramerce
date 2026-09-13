<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('products', function (Blueprint $table) {
      $table->string('id_product', 50)->primary();
      $table->string('name')->index();
      $table->string('slug')->unique();
      $table->boolean('is_active')->default(1);
      $table->boolean('is_featured')->default(1);
      $table->text('description')->nullable();
      $table->string('brand_id')->nullable()->index();
      $table->foreign('brand_id')->references('id_brand')->on('brands')->nullOnDelete();
      $table->string('category_id')->index();
      $table->foreign('category_id')->references('id_category')->on('categories')->cascadeOnDelete();
      $table->string('store_id')->index();
      $table->foreign('store_id')->references('id_store')->on('stores')->cascadeOnDelete();
      $table->timestamps();
      $table->string('created_by')->nullable();
      $table->string('updated_by')->nullable();
      $table->softDeletes();
      $table->string('deleted_by')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
