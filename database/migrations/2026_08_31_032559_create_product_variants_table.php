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
    Schema::create('product_variants', function (Blueprint $table) {
      $table->string('id_product_variant', 50)->primary();
      $table->string('name')->index();
      $table->string('slug')->unique();
      $table->text('description')->nullable();
      $table->boolean('is_variant_active')->default(1);
      $table->string('sku')->index()->unique();
      $table->integer('weight');
      $table->integer('stock')->index();
      $table->integer('price')->index();
      $table->string('color')->nullable();
      $table->string('size')->nullable();
      $table->string('product_id')->index();
      $table->foreign('product_id')->references('id_product')->on('products')->cascadeOnDelete();
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
    Schema::dropIfExists('product_variants');
  }
};
