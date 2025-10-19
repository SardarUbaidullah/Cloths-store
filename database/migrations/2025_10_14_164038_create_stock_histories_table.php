<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('stock_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('change'); // negative for out, positive for in
        $table->string('type')->nullable(); // 'order', 'manual', etc.
        $table->string('reference')->nullable(); // order_number or admin note
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // admin who changed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
