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
    Schema::create('owners', function (Blueprint $table) {
      $table->string('id_owner', 50)->primary();
      $table->string('user_id')->index();
      $table->foreign('user_id')->references('id_user')->on('users')->cascadeOnDelete();
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
    Schema::dropIfExists('owners');
  }
};
