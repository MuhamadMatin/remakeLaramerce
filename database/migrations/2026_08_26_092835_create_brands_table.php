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
    Schema::create('brands', function (Blueprint $table) {
      $table->string('id_brand', 50)->primary();
      $table->string('name')->index();
      $table->string('slug')->unique();
      $table->string('image_path')->nullable();
      $table->text('description')->nullable();
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
    Schema::dropIfExists('brands');
  }
};
