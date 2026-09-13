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
    Schema::create('store_addresses', function (Blueprint $table) {
      $table->string('id_store_address', 50)->primary();
      $table->string('address');
      $table->string('zip_code')->index();
      $table->string('province_id');
      $table->string('subdistrict_id');
      $table->string('city_id');
      $table->boolean('is_primary');
      $table->string('label')->nullable()->comment('store or storage');
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
    Schema::dropIfExists('store_addresses');
  }
};
