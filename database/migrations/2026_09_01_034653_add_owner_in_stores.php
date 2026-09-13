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
    Schema::table('stores', function (Blueprint $table) {
      $table->string('owner_id')->index();
      $table->foreign('owner_id')->references('id_owner')->on('owners')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('stores', function (Blueprint $table) {
      $table->dropForeign(['owner_id']);
      $table->dropColumn('owner_id');
    });
  }
};
