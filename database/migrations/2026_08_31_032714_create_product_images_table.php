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
    Schema::create('product_images', function (Blueprint $table) {
      $table->string('id_product_image', 50)->primary();
      $table->string('image_path');
      $table->boolean('is_primary');
      $table->string('product_variant_id')->index();
      $table->foreign('product_variant_id')->references('id_product_variant')->on('product_variants')->cascadeOnDelete();
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
    Schema::dropIfExists('product_images');
  }
};
